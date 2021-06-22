<?php // FUNCTIONS

// Core WordPress Functions
include_once get_stylesheet_directory() . '/includes/cleanup-wp-admin.php';
include_once get_stylesheet_directory() . '/includes/cleanup-wp.php';
include_once get_stylesheet_directory() . '/includes/enqueue.php';

// Custom Theme Functions
//include_once get_stylesheet_directory() . '/includes/custom-post-types.php'; // Or use CPT plugin
include_once get_stylesheet_directory() . '/includes/theme-support.php';
include_once get_stylesheet_directory() . '/includes/gutenberg.php';

// Partials & Block Functions
include_once get_stylesheet_directory() . '/partials/search/search-functions.php';
include_once get_stylesheet_directory() . '/blocks/blocks-acf.php'; // Custom ACF Gutenberg Blocks


/**
 * SVG Icons with version number
 *
 * replaces: <svg><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#close"></use></svg>
 * with: <svg><use href="<?php echo get_svg('globe'); ?>"></use></svg>
 *
 */
define('SVG_LAST_MTIME', filemtime( realpath(__DIR__) . '/assets/icons/icons.svg' ));
function get_svg($which) {
	$version = SVG_LAST_MTIME;
	return get_template_directory_uri() . "/assets/icons/icons.svg?". $version . "#" . $which;
}


/**
 * Allow SVG uploads
 */
add_filter( 'upload_mimes', 'cc_mime_types' );
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svg'] = 'image/svg';
	return $mimes;
}


/**
 * ACF Options Page for site-wide fields
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	
	// Used by partials/notices
	acf_add_options_page(array(
		'title'    		=> 'Notices',
		'parent_slug' 	=> 'themes.php',
		'capability' 	=> 'add_users', // Admin only
		'icon_url' 		=> 'dashicons-megaphone', // https://developer.wordpress.org/resource/dashicons/#megaphone
	));

}
