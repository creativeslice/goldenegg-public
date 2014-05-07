<?php
/**
 * Golden Egg Basic Theme Support Settings
 *
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */

/**
 * Add an oembed content width
 *
 * @since	1.0.0
 */
if ( ! isset( $content_width ) )
{
	$content_width = 640;
}

/**
 * Example custom thumbnail sizes
 *
 * @since	1.0.0
 * /
add_image_size( 'custom-thumb-600', 600, 150, true );
add_image_size( 'custom-thumb-300', 300, 100, true );

// Customize the names in select new images sizes from media manager
add_filter( 'image_size_names_choose', 'custom_image_sizes' );
	function bones_custom_image_sizes( $sizes )
	{
		return array_merge( $sizes, array(
			'custom-thumb-600' => __('600px by 150px'),
			'custom-thumb-300' => __('300px by 100px'),
		) );
	}

/**
 * Example widgetized areas
 *
 * @since	1.0.0
 */
add_action( 'widgets_init', 'custom_register_sidebars' );
	function custom_register_sidebars()
	{
		register_sidebar(array(
			'id' => 'sidebar1',
			'name' => 'Sidebar 1',
			'description' => 'The first (primary) sidebar.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}

/**
 * Updating WordPress Functions & Theme Support
 *
 * Use this to turn off/on and customize support for features as needed by your theme
 *
 * @since	1.0.0
 */
add_action( 'after_setup_theme', 'custom_theme_support' );
	function custom_theme_support()
	{
		/* Featured Image * /
		add_theme_support( 'post-thumbnails', array( 'post', 'press', 'calendar' ) ); // Posts, Press & Calendar
	
		/* default thumb size * /
		set_post_thumbnail_size(120, 120, true);
	
		/* This feature enables post and comment RSS feed links to head * /
		add_theme_support('automatic-feed-links');
		
		/* Enable support for HTML5 markup. */
		add_theme_support( 'html5', 
			array(
				'comment-list',
				'search-form',
				'comment-form',
				'gallery',
				'caption'
			)
		);
				
		/* adding post format support */
		add_theme_support( 'post-formats',
			array(
				'aside',             // title less blurb
				'gallery',           // gallery of images
				'link',              // quick link to other site
				'image',             // an image
				'quote',             // a quick quote
				'status',            // a Facebook like status update
				'video',             // video
				'audio',             // audio
				'chat'               // chat transcript
			)
		);
	
		/* wp menus */
		add_theme_support( 'menus' );
	
		/* registering menus */
		register_nav_menus(
			array(
				'main-nav'     => 'The Main Menu',  // main nav in header
				'footer-links' => 'Footer Links',   // secondary nav in footer
			)
		);
	}