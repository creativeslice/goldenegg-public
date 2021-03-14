<?php

// Admin
require_once( 'admin/admin.php' );
require_once( 'admin/login.php' );
require_once( 'admin/gutenberg.php' );					// Gutenberg Editor
require_once( 'admin/tinymce.php' );					// Classic WYSIWYG Editor
#require_once( 'admin/disableComments.php' );			// Remove comments
#require_once( 'admin/dashboardWidget.php' );			// Custom admin widget

// Front End
require_once( 'includes/enqueue.php' );
require_once( 'includes/themeSupport.php' );
require_once( 'includes/cleanup.php' );					// Cleanup WordPress scripts
#require_once( 'includes/contentBlockFunctions.php' );	// Classic ACF Method
#require_once( 'includes/disablePingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disableFeeds.php' );			// Disable site feeds

require_once( 'includes/customPostTypes.php' );		// Create custom post types
#require_once( 'includes/niceSearch.php' );				// Clean search urls
#require_once( 'includes/excludeFromMenu.php' );		// Exclude from menu checkbox


/**
 * SVG Icons with version number
 *
 * replaces: <svg><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#close"></use></svg>
 * with: <svg><use xlink:href="<?php echo get_svg('globe'); ?>"></use></svg>
 *
 * @param $which string the name of the icon
 * @return string
 *
 */
// set the modified time for icons.svg to bust caching
define('SVG_LAST_MTIME', filemtime( realpath(__DIR__) . '/assets/icons/icons.svg' ));
function get_svg($which) {
	$version = SVG_LAST_MTIME;
	return get_template_directory_uri() . "/assets/icons/icons.svg?". $version . "#" . $which;
}


/**
 * ACF Options Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	
	// Used by components/notices
	acf_add_options_page(array(
		'title'    => 'Notices',
		'position' => '2.1',
		'icon_url' => 'dashicons-megaphone',
	));
	
	// Footer settings
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Footer',
		'parent_slug' 	=> 'themes.php',
		'capability' 	=> 'add_users', // Admin only
	));

}



