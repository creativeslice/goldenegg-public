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
require_once( 'admin/recently_updated_content.php' );
#require_once( 'admin/dashboard-widget.php' ); // A basic example, should generally be reviewed and customized before use

// Front end
require_once( 'includes/cleanup.php' );
require_once( 'includes/comments.php' );
require_once( 'includes/egg-functions.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/custom-post-types.php' );

/**
 * Customize Site
 */