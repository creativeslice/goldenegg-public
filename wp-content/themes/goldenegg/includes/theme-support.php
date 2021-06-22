<?php // THEME SUPPORT
	
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
 * Force galleries to link to file instead of attachment page
 */
add_shortcode( 'gallery', 'my_gallery_shortcode' );
function my_gallery_shortcode($atts) {
    $atts['link'] = 'file';
    return gallery_shortcode($atts);
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
 * Updating WordPress Functions & Theme Support
 */
add_action( 'after_setup_theme', 'custom_theme_support' );
function custom_theme_support() {
	
	/* Title Tag for SEO */
	add_theme_support( 'title-tag' );
	
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


/**
 * Updates the […] for Read More links
 *
 * @return	bool Modified status for comments.
 */
add_filter( 'excerpt_more',	'egg_excerpt_more' );
function egg_excerpt_more($more) {
	global $post;
	return "&hellip;";
}


/**
 * Shorten excerpt length
 *
 * @return	Modified character length
 */
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length($length) {
	return 33; // number of characters
}


/**
 * Limit excerpt by number of words
 *
 * example: echo excerpt(8); // limit to 8 words
 */
function excerpt($limit) {
	return wp_trim_words(get_the_excerpt(), $limit);
}
