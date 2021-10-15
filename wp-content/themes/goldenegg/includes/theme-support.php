<?php // THEME SUPPORT


/**
 * Updating WordPress Functions & Theme Support
 */
function custom_theme_support() {
	
	// Title Tag for SEO
	add_theme_support( 'title-tag' );
	
	// Add featured image by post type.
	add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	//set_post_thumbnail_size( 1792, 9999 );

	// Add default posts and comments RSS feed links to head.
	//add_theme_support('automatic-feed-links');

	// HTML5 semantic markup.
	add_theme_support( 'html5', array('search-form','gallery','caption'));
	
	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Menu navigation
	add_theme_support( 'menus' );
	register_nav_menus(
		array(
			'mainNav'     => 'Main Menu',  		// main nav in header
			'footerLinks' => 'Footer Links',	// links in footer
		)
	);
	
	// Adding support for core block visual styles.
	//add_theme_support( 'wp-block-styles' );
	
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
		
}
add_action( 'after_setup_theme', 'custom_theme_support' );




/**
 * Image sizes
 */
 
// WP DEFAULTS (Defining in Settings)
# thumbnail		150, 	150,	true
# medium		800, 	800,	false
# large			1600, 	1600,	false

// CUSTOM SIZES
//add_image_size( 'fhd', 		1920, 	1080, 	true );
//add_image_size( 'hd', 		1280, 	720, 	true );
//add_image_size( 'hdsm', 	640, 	360, 	true );

// Disable srcset images
//add_filter( 'wp_calculate_image_srcset', '__return_false' );
	
// Disable large image scaling
add_filter( 'big_image_size_threshold', '__return_false' );

// Remove 'medium_large' image size since we have no control over it
add_filter( 'intermediate_image_sizes', function($sizes) {
    return array_filter( $sizes, function($val) {
        return 'medium_large' !== $val;
    });
});


/**
 * Allow SVG uploads
 */
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svg'] = 'image/svg';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );


/**
 * Force galleries to link to file instead of attachment page
 */
/*
function my_gallery_shortcode($atts) {
    $atts['link'] = 'file';
    return gallery_shortcode($atts);
}
add_shortcode( 'gallery', 'my_gallery_shortcode' );
*/


/**
 * Updates the […] for Read More links
 *
 * @return	bool Modified status for comments.
 */
function egg_excerpt_more($more) {
	global $post;
	return "&hellip;";
}
add_filter( 'excerpt_more',	'egg_excerpt_more' );


/**
 * Shorten excerpt length
 *
 * @return	Modified character length
 */
function custom_excerpt_length($length) {
	return 33; // number of characters
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


/**
 * Limit excerpt by number of words
 *
 * example: echo excerpt(8); // limit to 8 words
 */
function excerpt($limit) {
	return wp_trim_words(get_the_excerpt(), $limit);
}
