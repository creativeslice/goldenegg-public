<?php

/**
 * Set up the theme
 */
define( 'EGG_DEVELOPER',     'Creative Slice' );
define( 'EGG_DEVELOPER_URL', 'https://creativeslice.com/' );


/**
 * Load modules
 */

// Admin
require_once( 'admin/admin.php' );
require_once( 'admin/login.php' );
require_once( 'admin/tinymce.php' );
#require_once( 'admin/disable-comments.php' );          // Completely remove comments from the admin area
#require_once( 'admin/recently-updated-content.php' ); 	// Shows recently updated content. REQUIRES customization
#require_once( 'admin/dashboard-widget.php' ); 			// Widget example to show instructions

// Front End
require_once( 'includes/enqueue.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/cleanup.php' );					// Cleanup WordPress scripts
#require_once( 'includes/disable-pingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disable-feeds.php' );			// Disable site feeds

#require_once( 'includes/custom-post-types.php' );		// Create custom post types

#require_once( 'includes/nice-search.php' );			// Clean search urls & Relevanssi custom fields
#require_once( 'includes/exclude-from-menu.php' );		// Exclude from menu checkbox