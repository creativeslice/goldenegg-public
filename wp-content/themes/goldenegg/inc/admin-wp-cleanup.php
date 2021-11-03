<?php
/**
 * Admin: WordPress Cleanup
 * 
 * Author: Creative Slice
 * URI: https://github.com/creativeslice/goldenegg
 * Version: 1.0.1
*/


/**
 * Disable the auto generated email sent to the admin after a successful core update:
 */
function egg_bypass_auto_update_email( $send, $type, $core_update, $result ) {
    if ( ! empty( $type ) && $type == 'success' ) {
        return false;
    }
    return true;
}
add_filter( 'auto_core_update_send_email', 'egg_bypass_auto_update_email', 10, 4 );


/**
 * Turn off Autosave (does not currently work with Gutenberg)
 */
/*
function disable_autosave() {
	wp_deregister_script( 'autosave' );
}
add_action( 'admin_init', 'disable_autosave', 999);
*/


/**
 * Basic WordPress cleanup
 */
function egg_cleanup() {
	add_filter( 'the_generator', 'egg_rss_version' ); // function below
	add_action( 'init', 'egg_head_cleanup' ); // function below
}
add_action( 'after_setup_theme', 'egg_cleanup' );


/**
 * Remove WP version from RSS feed.
 */
function egg_rss_version() { 
	return ''; 
}


/**
 * Cleanup the head output.
 */
function egg_head_cleanup() {
	
	// Remove shortlink from head and header
	remove_action( 'wp_head', 				'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'template_redirect',		'wp_shortlink_header', 11, 0 );
	
	// Remove comments feed
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
	// Remove category feeds
	remove_action( 'wp_head',				'feed_links_extra', 3 );
	// Remove windows live writer
	remove_action( 'wp_head',				'wlwmanifest_link' );
	// Remove EditURI/RSD link
	remove_action( 'wp_head', 				'rsd_link' );

	// Remove rel link
	remove_action( 'wp_head',				'index_rel_link' );
	// Remove previous link
	remove_action( 'wp_head',				'parent_post_rel_link', 10, 0 );
	// Remove start link
	remove_action( 'wp_head',				'start_post_rel_link', 10, 0 );
	// Remove links for adjacent posts
	remove_action( 'wp_head',				'adjacent_posts_rel_link', 10, 0); 
	remove_action( 'wp_head',				'adjacent_posts_rel_link_wp_head', 10, 0 );
	
	// Remove WP version
	remove_action( 'wp_head',				'wp_generator' );
	
	// Remove WP version from css and js
	add_filter( 'style_loader_src',			'egg_remove_wp_ver_css_js', 9999 ); // function below
	add_filter( 'script_loader_src',		'egg_remove_wp_ver_css_js', 9999 ); // function below
	
	// Remove emoji scripts
	remove_action( 'wp_head',				'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 	'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 	'print_emoji_styles' );
	remove_action( 'wp_print_styles',		'print_emoji_styles' );
	remove_filter( 'the_content_feed', 		'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 		'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 				'wp_staticize_emoji_for_email' );
	add_filter( 'option_use_smilies', 		'__return_false' );
	add_filter( 'wp_resource_hints', 		'egg_disable_emojis_remove_dns_prefetch', 10, 2 ); // function below
	
	// Remove REST API links
	remove_action( 'wp_head', 				'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 				'wp_oembed_add_discovery_links', 10 );
	remove_action( 'template_redirect', 	'rest_output_link_header', 11 );
	
	// Remove DNS Prefetch
	#remove_action( 'wp_head', 			'wp_resource_hints', 2 );
	
	// Remove canonical links
	#remove_action( 'wp_head', 				'rel_canonical');
}


/**
 * Remove WP version from scripts
 *
 * @return	bool Modified status for comments.
 */
function egg_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}


/**
 * Remove emoji DNS prefetching.
 *
 * @param array $urls URLs for resources.
 * @param string $relation_type Relation type.
 * @return array New array with resources.
 */
function egg_disable_emojis_remove_dns_prefetch( array $urls, string $relation_type ) : array {
	if ( 'dns-prefetch' !== $relation_type ) {
		return $urls;
	}

	// Strip out any URLs referencing the WordPress.org emoji location.
	$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
	foreach ( $urls as $key => $url ) {
		if ( is_array( $url ) ) {
			if ( ! isset( $url['href'] ) ) {
				continue;
			}
			$url = $url['href'];
		}
		if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
			unset( $urls[ $key ] );
		}
	}
	return $urls;
}
