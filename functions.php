<?php

// Admin
require_once( 'admin/admin.php' );
require_once( 'admin/login.php' );
require_once( 'admin/tinymce.php' );
#require_once( 'admin/disableComments.php' );			// Completely remove comments from the admin area

// Front End
require_once( 'includes/enqueue.php' );
require_once( 'includes/themeSupport.php' );
require_once( 'includes/cleanup.php' );					// Cleanup WordPress scripts
require_once( 'includes/components.php' );
#require_once( 'includes/disablePingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disableFeeds.php' );			// Disable site feeds
#require_once( 'includes/customPostTypes.php' );		// Create custom post types
#require_once( 'includes/niceSearch.php' );				// Clean search urls & Relevanssi custom fields
#require_once( 'includes/excludeFromMenu.php' );		// Exclude from menu checkbox