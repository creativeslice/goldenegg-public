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

// Front end
require_once( 'includes/cleanup.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/page-navi.php' );
require_once( 'includes/comments.php' );
#require_once( 'includes/related-posts.php' );
#require_once( 'includes/custom-post-types.php' );
#require_once( 'includes/assets-rewrites.php' );
#require_once( 'includes/nice-search.php' );

/**
 * CUSTOM FUNCTIONS
 */

/**
 * Customize which post types are used for SEO fields and XML sitemap plugins:
 *
 * https://bitbucket.org/jupitercow/sewn-in-xml-sitemap
 * https://bitbucket.org/jupitercow/sewn-in-simple-seo
 *
 * @param   array   $post_types List of post types to be added to the XML Sitemap
 * @return  array   $post_types Modified list of post types
 * /

add_filter( 'customize_wordpress_xml_sitemap/post_types', 'custom_seo_post_types' );
add_filter( 'customize_wordpress_seo/post_types', 'custom_seo_post_types' );
function custom_seo_post_types( $post_types ) {
    $post_types = array("post","page","films");
    return $post_types;
}
/**/