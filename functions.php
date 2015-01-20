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
require_once( 'admin/tinymce.php' );
#require_once( 'admin/dashboard-widget.php' ); 			// Widget example to show instructions
#require_once( 'admin/recently-updated-content.php' ); 	// Shows recently updated content. REQUIRES customization
#require_once( 'admin/disable-comments.php' );          // Completely remove comments from the admin area

// Front end
require_once( 'includes/cleanup.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/page-navi.php' );
require_once( 'includes/sunrise-set.php' );
#require_once( 'includes/related-content.php' );		// Associated content and related posts
#require_once( 'includes/youtube-customization.php' );	// Customize iframe and youtube parameters
#equire_once( 'includes/custom-post-types.php' );		// Create custom post types
#require_once( 'includes/nice-search.php' );			// Clean search urls AND Relevanssi custom fields.
#require_once( 'includes/disable-pingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disable-feeds.php' );			// Disable site feeds
#require_once( 'includes/cleanup-plugins.php' );		// Cleanup commonly used plugins

// In Development
#require_once( 'includes/10up-lazy-load.php' );			// Lazy load images based on 10up plugin
#require_once( 'includes/egg-calendar.php' );			// Flexible calendar (monthly, weekly, daily)


/**
 * Adds ACF Options functionality
 *
 */
/*
if(function_exists('acf_add_options_page')) { 
	acf_add_options_page( 
		array (
		'title' => 'Site Elements',
		'position' => '21.1',
		'icon_url' => 'dashicons-archive'
		) 
	);
}
*/


/**
 * Requires https://wordpress.org/plugins/sewn-in-xml-sitemap/
 * Customize which post types are added to the XML sitemap
 *
 * @param   array   $post_types List of post types to be added to the XML Sitemap
 * @return  array   $post_types Modified list of post types
 */
/*
add_filter( 'sewn_seo/post_types', 'custom_sitemap_post_types' );
function custom_sitemap_post_types( $post_types )
{
    $post_types = array('page','post');
    return $post_types;
}
*/

/**
 * FILTERS
 **/

add_filter('rewrite_rules_array', 'add_rewrite_rules');
add_filter('query_vars', 'add_query_vars');
  
// Adds a url query to pass date requests in the URL (i.e., example.net/?var1=value1&calendar_date=2014-08
function add_query_vars($aVars) {
	$aVars[] = "page_request";
	$aVars[] = "custom_cat";
	return $aVars;
}

// Rewrite Rule - redirects calendar/2014-08/ to page-calendar.php?calendar_date=2014-08
// ON INSTALL SAVE Permalinks or flush_rewrite_rules();
function add_rewrite_rules($aRules) {
	$aNewRules = array('ajaxRequest/([^/]+)/?$' => 'index.php?pagename=pushStateBlank&page_request=$matches[1]');
//	$aNewRules = array('ajaxRequest/?$' => 'index.php?pagename=ajax_post');
	$aRules = $aNewRules + $aRules;
	return $aRules;
}