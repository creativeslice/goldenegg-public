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
#require_once( 'admin/dashboard-widget.php' ); 			// A basic example to show instructions
#require_once( 'admin/recently-updated-content.php' ); 	// Shows recently updated content. REQUIRES customization
#require_once( 'admin/disable-comments.php' );          // Completely remove comments from the admin area

// Front end
require_once( 'includes/cleanup.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/page-navi.php' );
#require_once( 'includes/related-posts.php' );
require_once( 'includes/youtube-customization.php' );	// Customize iframe and youtube parameters
#require_once( 'includes/custom-post-types.php' );		// Create custom post types
#require_once( 'includes/nice-search.php' );			// Clean search urls
#require_once( 'includes/disable-pingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disable-feeds.php' );			// Disable site feeds
#require_once( 'includes/seo-meta-data.php' );			// SEO Meta Data
#require_once( 'includes/xml-sitemap.php' );			// XML Sitemap
#require_once( 'includes/cleanup-plugins.php' );		// Cleanup commonly used plugins
#require_once( 'includes/assets-rewrites.php' );		// Rewrite theme assets to /assets and plugins to /plugins. DOES NOT WORK ON NGINX SERVERS LIKE WPENGINE

// In Development

#require_once( 'includes/10up-lazy-load.php' );				// Lazy load content
#require_once( 'includes/one-time-code.php' );
#require_once( 'includes/egg-calendar.php' );			// Flexible calendar (monthly, weekly, daily)

/**
 * Customize what post types are added to the XML sitemap
 *
 * @param   array   $post_types List of post types to be added to the XML Sitemap
 * @return  array   $post_types Modified list of post types
 */
add_filter( 'sewn_seo/post_types', 'custom_sitemap_post_types' );
function custom_sitemap_post_types( $post_types )
{
    $post_types = array('page','post');
    return $post_types;
}