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
#require_once( 'admin/recently-updated-content.php' ); 	// Shows recently updated content. Requires customization before use
#require_once( 'admin/disable-comments.php' );          // Completely remove comments from the admin area

// Front end
require_once( 'includes/egg-calendar.php' );
require_once( 'includes/calendarTest.php' );
require_once( 'includes/cleanup.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/page-navi.php' );
require_once( 'includes/related-posts.php' );
require_once( 'includes/youtube-customization.php' );
#require_once( 'includes/custom-post-types.php' );		// Create custom post types
#require_once( 'includes/nice-search.php' );			// Clean search urls
#require_once( 'includes/disable-pingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disable-feeds.php' );			// Disable site feeds
#require_once( 'includes/seo-meta-data.php' );			// SEO Meta Data
#require_once( 'includes/xml-sitemap.php' );			// XML Sitemap
#require_once( 'includes/cleanup-plugins.php' );		// Cleanup commonly used plugins
#require_once( 'includes/assets-rewrites.php' );		// Rewrite theme assets to /assets and plugins to /plugins. Does not work on nginx servers.
//get_all_events();
function get_all_events( $max_limit = 31 ){
	date_default_timezone_set ( "America/Phoenix" );
	// set max limit in days:
	$today = date( 'Ymd');
	$max_time = $today + $max_limit;
	$single_events = array();
	$recurring_events = array();
	$single_query = new WP_Query(
		array (
		    'posts_per_page' => 9,
		    'post_type' => 'post',
		    'meta_key' => 'date',
		    'orderby' => 'meta_value_num',
		    'order' => 'ASC',
		    'meta_query' => array(
		    	array(
		           'key' => 'date',
		           'value' => $today,
		           'compare' => '>=',
		           'type' => 'numeric',
		       ),
		       array(
		       	   'key' => 'date',
		           'value' => $max_time,
		           'compare' => '<=',
		           'type' => 'numeric',
		       )
		   )
		)
	);
	foreach( $single_query->posts as $se_key=>$se_post ){
		$event_date = get_post_meta($se_post->ID, 'date', true);
		$single_events[strtotime($event_date)] = $se_post;
	}
print_r($single_events);

	$recurring_query = new WP_Query(
		array (
		    'posts_per_page' => 9,
		    'post_type' => 'events',
		    'meta_key' => 'recurring_day',
		    'orderby' => 'meta_value_num',
		    'order' => 'ASC',
		    'meta_query' => array(
		    	array(
		           'key' => 'recurring_day'
		       )
		   )
		)
	);
	$recurring_count = floor($max_limit/ 7);
	foreach($recurring_query->posts as $re_key => $re_post){
		$recurring_day = get_field( 'recurring_day', $re_post->ID );
		$dif_num = $recurring_day - date('w');
		if( $dif_num < 0 ){ $dif_num = $dif_num + 7;}
		$i = 0;		
		while($i < $recurring_count){
			$recurring_timestamp = strtotime( 'today 12:00am +' . $dif_num .' day');
			$recurring_events[$recurring_timestamp] = $re_post;
			$dif_num = $dif_num +7;
			$i++;
		}			
	}
	$all_events = $single_events + $recurring_events;
	ksort($all_events);
	return $all_events;
}
function get_event( $stamp, $max_limit = 1 ){
	$today = date( 'Ymd', $stamp);
	$max_time = $today ;
	$single_events = array();
	$single_query = new WP_Query(
		array (
		    'posts_per_page' => 9,
		    'post_type' => 'post',
		    'meta_key' => 'date',
		    'orderby' => 'meta_value_num',
		    'order' => 'ASC',
		    'meta_query' => array(
		    	array(
		           'key' => 'date',
		           'value' => $today,
		           'compare' => '>=',
		           'type' => 'numeric',
		       ),
		       array(
		       	   'key' => 'date',
		           'value' => $max_time,
		           'compare' => '<=',
		           'type' => 'numeric',
		       )
		   )
		)
	);
	if( count ($single_query->posts) > 0 ){
		foreach( $single_query->posts as $se_key=>$se_post ){
			$event_date = get_post_meta($se_post->ID, 'date', true);
//			$single_events[strtotime($event_date)] = $se_post;
			$single_events[] = $se_post;
		}
		return $single_events;
	}
	else{
		return false;
	}
}