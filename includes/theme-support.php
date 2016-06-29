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
 * Example custom thumbnail sizes
 * /
add_image_size( 'custom-thumb-600', 600, 150, true );
add_image_size( 'custom-thumb-300', 300, 100, true );


/**
 * Add responsive ".video-container" to YouTube and Vimeo embeds
 */
function vnmFunctionality_embedWrapper($html, $url, $attr) {
    if (strpos($html, 'youtube') !== false || strpos($html, 'vimeo') !== false) {
        return '<div class="video-container">' . $html . '</div>';
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
function custom_theme_support()
{
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
			
	/* adding post format support * /
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
			'footer-links' => 'Footer Links',   // links in footer
		)
	);
}