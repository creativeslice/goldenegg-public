<?php

/**
 * Set up the theme
 */
define( 'EGG_DEVELOPER',     'Creative Slice' );
define( 'EGG_DEVELOPER_URL', 'http://creativeslice.com/' );

#$egg_info = wp_get_theme();
#define( 'EGG_VERSION',        $egg_info->Version );

/**
 * Load modules
 *
 * Comment out modules that are not desired for the current site.
 */

// Admin
require_once( 'admin/admin.php' );
require_once( 'admin/login.php' );
#require_once( 'admin/tinymce.php' );
#require_once( 'admin/dashboard-widget.php' ); 			// A basic example, should be customized before use
#require_once( 'admin/recently-updated-content.php' ); 	// Shows recently updated content. Requires customization before use
#require_once( 'admin/disable-comments.php' );          // Completely remove comments from the admin area

// Front end
require_once( 'includes/cleanup.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/page-navi.php' );
require_once( 'includes/related-posts.php' );
#require_once( 'includes/custom-post-types.php' );		// Create custom post types
#require_once( 'includes/nice-search.php' );			// Clean search urls
#require_once( 'includes/disable-pingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disable-feeds.php' );			// Disable site feeds
#require_once( 'includes/seo_meta_data.php' );			// SEO Meta Data
#require_once( 'includes/xml_sitemap.php' );			// XML Sitemap
#require_once( 'includes/assets-rewrites.php' );		// Rewrite theme assets to /assets and plugins to /plugins. Does not work on nginx servers.



/**
 * Moving Gravity Form scripts to footer (even the ajax ones)
 * /
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
	return true;
}

add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open' );
function wrap_gform_cdata_open( $content = '' ) {
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
	return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close' );
function wrap_gform_cdata_close( $content = '' ) {
	$content = ' }, false );';
	return $content;
}

/**
 * Tabindex fix for Gravity Form
 * /
add_filter("gform_tabindex", create_function("", "return 4;"));


/**
 * Remove front end styles from Search Everything plugin
 * /
function dequeue_badly_written_se() {
  wp_dequeue_style( 'se-link-styles' );
}
add_action('wp_enqueue_scripts', 'dequeue_badly_written_se');

*/