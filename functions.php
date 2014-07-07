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
require_once( 'includes/cleanup.php' );
require_once( 'includes/theme-support.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/page-navi.php' );
require_once( 'includes/related-posts.php' );
#require_once( 'includes/custom-post-types.php' );		// Create custom post types
#require_once( 'includes/nice-search.php' );			// Clean search urls
#require_once( 'includes/disable-pingback.php' );		// Disable XMLRPC, pingbacks, trackbacks
#require_once( 'includes/disable-feeds.php' );			// Disable site feeds
#require_once( 'includes/seo-meta-data.php' );			// SEO Meta Data
#require_once( 'includes/xml-sitemap.php' );			// XML Sitemap
#require_once( 'includes/cleanup-plugins.php' );		// Cleanup commonly used plugins
#require_once( 'includes/assets-rewrites.php' );		// Rewrite theme assets to /assets and plugins to /plugins. Does not work on nginx servers.

add_filter( 'embed_oembed_html', 'egg_set_youtube_params', 10, 4 ) ;
function egg_set_youtube_params($html, $url, $args, $id) {
// PARAMETER OPTIONS 
	$iframe_args['width'] = '540';
	$iframe_args['height'] = '260';
	$iframe_args['frameborder'] = '0';
	$iframe_args['allowfullscreen'] = 'allowfullscreen';
	
	$video_args['rel'] = '0';
	$video_args['show_info'] = '0';
// END PARAMETER OPTIONS

	if(count(@$video_args)>0){
		$i = 0;
		$query_str = "?";
		foreach($video_args as $key=>$arg){
			if($i == 1){ $query_str .="&"; }
			$query_str .= $key."=".$arg;
			$i=1;
		}
	}
	$iframe_arr = explode ( ' ', htmlentities($html));
	foreach( $iframe_arr as $key=>$value ){
		if(preg_match('/width/',$value)){
			$original_width = preg_replace('/\D/', '', $value);
		}
		if(preg_match('/height/',$value)){
			$original_heght = preg_replace('/\D/', '', $value);
		}
	}
	if(@$iframe_args['width']==0){
		$iframe_args['width'] = $original_width;
	}
	if(@$iframe_args['height']==0){
		$iframe_args['height'] = $original_width;
	}
    $url_string = parse_url($url, PHP_URL_QUERY);
    parse_str($url_string, $id);
    if (isset($id['v'])) {
   	     return '<iframe width="'.$iframe_args['width'].'" height="'.$iframe_args['height'].'" src="http://www.youtube.com/embed/'.$id['v'].@$query_str.'" frameborder="'.@$iframe_args["frameborder"].'" '.@$iframe_args["allowfullscreen"].'></iframe>';
    }
    return $html;
}