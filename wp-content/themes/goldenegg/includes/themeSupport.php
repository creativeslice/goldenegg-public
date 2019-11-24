<?php
	
/**
 * Image sizes
 */
 
// WP DEFAULTS
# thumbnail		150, 	150,	true
# medium		800, 	800,	false
# large			1600, 	1600,	false

// CUSTOM SIZES
add_image_size( 'fhd', 		1920, 	1080, 	true );
add_image_size( 'hd', 		1280, 	720, 	true );
add_image_size( 'hdsm', 	640, 	360, 	true );


/**
 * Title Tag support for SEO
 */
add_action( 'after_setup_theme', 'theme_slug_setup' );
function theme_slug_setup() {
   add_theme_support( 'title-tag' );
}


/**
 * Force galleries to link to file instead of attachment page
 */
add_shortcode( 'gallery', 'my_gallery_shortcode' );
function my_gallery_shortcode( $atts ) {
    $atts['link'] = 'file';
    return gallery_shortcode( $atts );
}


/**
 * Add responsive ".videoContainer" to YouTube and Vimeo embeds
 */
add_filter( 'embed_oembed_html', 'vnmFunctionality_embedWrapper', 10, 3 );
function vnmFunctionality_embedWrapper($html, $url, $attr) {
    if (strpos($html, 'youtube') !== false || strpos($html, 'vimeo') !== false) {
        return '<div class="videoContainer">' . $html . '</div>';
    }
	return $html;
}


/**
 * Customize Search Box
 */
add_filter( 'get_search_form', 'egg_wpsearch' );
function egg_wpsearch($form) {
	$component = 'searchForm';
	ob_start();
	egg_component( $component );
	$form = ob_get_clean();
	return $form;
}


/**
 * Updating WordPress Functions & Theme Support
 */
add_action( 'after_setup_theme', 'custom_theme_support' );
function custom_theme_support() {
	
	/* Featured Image */
	add_theme_support( 'post-thumbnails', array( 'post', 'page' ) ); // Post types

	/* Enables post and comment RSS feed links to head */
	//add_theme_support('automatic-feed-links');

	/* Enable support for HTML5 markup. */
	add_theme_support( 'html5', 
		array(
			'search-form',
			'gallery',
			'caption'
		)
	);

	/* registering WP menus */
	add_theme_support( 'menus' );
	register_nav_menus(
		array(
			'mainNav'     => 'Main Menu',  		// main nav in header
			'footerLinks' => 'Footer Links',	// links in footer
		)
	);
}
