<?php

/*********************
XML SITEMAP
Create sitemap.xml file in the root directory
*********************/

add_action( 'save_post', 'cslice_create_sitemap' );
function cslice_create_sitemap() {
	$postsForSitemap = get_posts( array(
		'numberposts' => -1,
		'orderby'     => 'modified',
		'post_type'   => array('post','page','press'),
		'order'       => 'DESC'
	) );

	$sitemap  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" count="'. count($postsForSitemap) .'">'."\n";

	foreach ( $postsForSitemap as $post ) {
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

	$fp = fopen(ABSPATH . "sitemap.xml", 'w');
	if ( $fp ) {
		fwrite($fp, $sitemap);
		fclose($fp);
	}
}

?>
