<?php
/**
 * Golden Egg XML Sitemap
 *
 * @package   Egg_Xml_Sitemap
 * @author    Jacob Snyder <jake@jcow.com>
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */
add_action( 'admin_init', array('Egg_Xml_Sitemap', 'init') );

class Egg_Xml_Sitemap
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = 'egg_xml_sitemap';

	/**
	 * Initialize the Class
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function init()
	{
		// actions
		add_action( 'save_post',                  array(__CLASS__, 'create_sitemap') );
	}

	/**
	 * Create sitemap.xml file in the root directory
	 *
	 * @author  Tim Bowen, Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function create_sitemap()
	{
		$postsForSitemap = get_posts( array(
			'numberposts' => -1,
			'orderby'     => 'modified',
			'post_type'   => apply_filters( self::PREFIX . '/sitemap/post_types', array('post','page') ),
			'order'       => 'DESC'
		) );

		$sitemap  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" count="'. count($postsForSitemap) .'">'."\n";

		foreach ( $postsForSitemap as $post )
		{
			$exclude = get_post_meta($post->ID, 'xml_sitemap_exclude', true);
			if ( $exclude ) continue;

			setup_postdata($post);
			$postdate = explode(" ", $post->post_modified);
			$sitemap .= "\t".'<url>'."\n".
				"\t\t".'<loc>' . get_permalink($post->ID) . '</loc>'."\n" .
				"\t\t".'<lastmod>' . $postdate[0] . '</lastmod>'."\n" .
				"\t\t".'<changefreq>monthly</changefreq>'."\n" .
				"\t".'</url>'."\n";
		}

		$sitemap .= '</urlset>';

		$filename = 'sitemap.xml';
		if ( is_multisite() ) $filename = 'sitemap_' . sanitize_title(get_option('blogname')) . '.xml';

		$fp = fopen(ABSPATH . $filename, 'w');
		if ( $fp )
		{
			fwrite($fp, $sitemap);
			fclose($fp);
		}
	}
}