<?php
/**
 * Basic Theme Support Settings
 */

/**
 * Add an oembed content width
 * /
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}


/**
 * Image sizes
 */
#add_image_size( 'fhd', 1920, 1080, true );
#add_image_size( 'hd', 1280, 720, true );


/**
 * Force all galleries to link to file instead of attachment page
 */
function my_gallery_shortcode( $atts ) {
    $atts['link'] = 'file';
    return gallery_shortcode( $atts );
}
add_shortcode( 'gallery', 'my_gallery_shortcode' );


/**
 * Add responsive ".videoContainer" to YouTube and Vimeo embeds
 */
function vnmFunctionality_embedWrapper($html, $url, $attr) {
    if (strpos($html, 'youtube') !== false || strpos($html, 'vimeo') !== false) {
        return '<div class="videoContainer">' . $html . '</div>';
    }
	return $html;
}
add_filter( 'embed_oembed_html', 'vnmFunctionality_embedWrapper', 10, 3 );
//add_filter( 'video_embed_html', 'vnmFunctionality_embedWrapper' ); // Jetpack


/**
 * Customize Search Box
 */
function egg_wpsearch($form) {
$form = '<div class="search-form">
<form role="search" method="get" class="wrap-inner" action="' . esc_url( home_url( '/' ) ) . '">
        <label>
            <span class="screen-reader-text">' . _x( 'Search for:', 'label' ) . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search Term&hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" />
        </label>
        <input type="submit" class="search-submit button" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
    </form>
</div>';
return $form;
}
add_filter( 'get_search_form', 'egg_wpsearch' );


/**
 * Example widgetized areas
 * /
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
 */
add_action( 'after_setup_theme', 'custom_theme_support' );
function custom_theme_support() {
	
	/* Featured Image */
	add_theme_support( 'post-thumbnails', array( 'post', 'page', ) ); // Posts, Pages

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

	/* registering WP menus */
	add_theme_support( 'menus' );
	register_nav_menus(
		array(
			'mainNav'     => 'Main Menu',  		// main nav in header
			'footerLinks' => 'Footer Links',	// links in footer
		)
	);
}