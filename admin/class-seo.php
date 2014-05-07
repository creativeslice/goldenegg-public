<?php
/**
 * Golden Egg SEO Support
 *
 * @package   Egg_Seo
 * @author    Jacob Snyder <jake@jcow.com>
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */
add_action( 'init', array('Egg_Seo', 'init') );

class Egg_Seo
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = 'egg_seo';

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
		add_action( self::PREFIX . '/meta_description',      array(__CLASS__, 'meta_description') );
		add_action( self::PREFIX . '/meta/description',      array(__CLASS__, 'meta_description') );
		add_action( self::PREFIX . '/meta/classification',   array(__CLASS__, 'meta_classification') );
		add_action( self::PREFIX . '/meta/og:title',         array(__CLASS__, 'meta_og_title') );
		add_action( self::PREFIX . '/meta/og:image',         array(__CLASS__, 'meta_og_image') );
		add_action( self::PREFIX . '/meta/og:type',          array(__CLASS__, 'meta_og_type') );
		add_action( self::PREFIX . '/meta/permalink',        array(__CLASS__, 'meta_permalink') );
		add_action( 'admin_enqueue_scripts',                 array(__CLASS__, 'admin_enqueue_scripts') );

		// filters
		add_filter( 'wp_title',                              array(__CLASS__, 'wp_title'), 10, 2 );

		// Load ACF Fields
		self::register_field_groups();
	}

	/**
	 * Better SEO: meta title, supported by ACF
	 *
	 * @author  Jake Snyder
	 * @since	0.3
	 * @return	void
	 */
	public static function wp_title( $title, $sep )
	{
		if ( is_feed() ) return $title;

		global $paged, $page;

		$title = '';

		if ( is_archive() )
		{
	        if ( $title ) $title .= " $sep ";
	        $title .= get_bloginfo('name');
		}
		else
		{
			if ( function_exists('get_field') && $meta_title = get_field('meta_title') )
				$title = $meta_title;

			if ( $paged >= 2 || $page >= 2 )
				$title .= " $sep Page " . max( $paged, $page );

			if ( $title ) $title .= ' - ';
			$title .= get_bloginfo('name');
		}

		return trim($title);
	}

	/**
	 * Load text limiter script in the admin for meta fields
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function admin_enqueue_scripts( $hook )
	{
		$panels = array(
			'post.php',
			'post-new.php'
		);
		if (! in_array($hook, $panels) ) return;

		wp_register_script( self::PREFIX, 'assets/js/seo.js', array( 'jquery' ), '', true );
		wp_enqueue_script( self::PREFIX );
	}

	/**
	 * Better SEO: meta description, supported by ACF
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function meta_description()
	{
		if ( function_exists('get_field') )
		{
			$content = '';
			$field   = '<meta property="og:description" name="description" content="%s">'."\n";
			if ( is_home() && $meta = get_field('meta_description', 'options') )
				$content = $meta;
			elseif ( $meta = get_field('meta_description') )
				$content = $meta;

			if ( $content ) printf( $field, $content );
		}
	}

	/**
	 * Better SEO: meta classification, supported by ACF
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function meta_classification()
	{
		if ( function_exists('get_field') )
		{
			$content = '';
			$field   = '<meta property="og:classification" content="%s">'."\n";
			if ( $meta = get_field('meta_classification', 'options') )
				$content = $meta;

			if ( $content ) printf( $field, $content );
		}
	}

	/**
	 * Better SEO: open graph title, supported by ACF
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function meta_og_title()
	{
		if ( function_exists('get_field') )
		{
			$content = '';
			$field   = '<meta property="og:title" content="%s">'."\n";
			if ( is_home() && $meta = get_field('meta_title', 'options') )
				$content = $meta;
			elseif ( $meta = get_field('meta_title') )
				$content = $meta;
			else
				$content = get_bloginfo('name');

			if ( $content ) printf( $field, $content );
		}
	}

	/**
	 * Better SEO: open graph image, supported by ACF
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function meta_og_image()
	{
		if ( function_exists('get_field') )
		{
			$content = '';
			$field   = '<meta property="og:image" content="%s">'."\n";
			if ( is_home() && $meta = get_field('meta_image', 'options') )
				$content = $meta;
			elseif ( $meta = get_field('meta_image') )
				$content = $meta;
			elseif ( $meta = get_field('meta_image', 'options') )
				$content = $meta;

			if ( $content ) printf( $field, $content );
		}
	}

	/**
	 * Better SEO: open graph type, supported by ACF
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function meta_og_type()
	{
		if ( function_exists('get_field') )
		{
			$content = '';
			$field   = '<meta property="og:type" content="%s">'."\n";
			if ( $meta = get_field('meta_type', 'options') )
				$content = $meta;

			if ( $content ) printf( $field, $content );
		}
	}

	/**
	 * Better SEO: open graph type, supported by ACF
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function meta_permalink()
	{
		if ( is_home() )
		{
			echo home_url('/');
		}
		else
		{
			echo get_permalink();
		}
	}

	/**
	 * Better SEO: ACF SEO Fields
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function register_field_groups()
	{
		if ( function_exists("register_field_group") )
		{
			register_field_group(array (
				'id' => 'acf_seo-meta-data',
				'title' => 'SEO Meta Data',
				'fields' => array (
					array (
						'key' => 'field_52790f158068a',
						'label' => 'Title',
						'name' => 'meta_title',
						'type' => 'text',
						'instructions' => 'Title display in search engines is limited to 70 chars',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => 70,
					),
					array (
						'key' => 'field_52790f308068b',
						'label' => 'Description',
						'name' => 'meta_description',
						'type' => 'textarea',
						'instructions' => 'The meta description will be limited to 156 chars and will show up on the search engine results page.',
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => 156,
						'formatting' => 'none',
					),
					array (
						'key' => 'field_52f9a1023c772',
						'label' => 'Exclude from XML Sitemap',
						'name' => 'xml_sitemap_exclude',
						'type' => 'true_false',
						'instructions' => 'This will keep the page from showing in the XML sitemap',
						'message' => '',
						'default_value' => 0,
					),
					array (
						'key' => 'field_53093d4fff08f',
						'label' => 'Open Graph Image',
						'name' => 'meta_image',
						'type' => 'image',
						'instructions' => 'Used by Facebook when a user a shares this content.',
						'save_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'post',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'page',
							'order_no' => 0,
							'group_no' => 1,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'default',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
			register_field_group(array (
				'id' => 'acf_seo-open-graph',
				'title' => 'Sitewide SEO',
				'fields' => array (
					array (
						'key' => 'field_53093bd7b3336',
						'label' => 'Site Classification',
						'name' => 'meta_classification',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_53093e1ac70ac',
						'label' => 'Type',
						'name' => 'meta_type',
						'type' => 'text',
						'instructions' => 'Used by Facebook when a user a shares site content.',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_53093e49c70ad',
						'label' => 'Image',
						'name' => 'meta_image',
						'type' => 'image',
						'instructions' => 'Used by Facebook when a user a shares site content.',
						'save_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'default',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 10,
			));
		}
	}
}