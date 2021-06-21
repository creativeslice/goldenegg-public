<?php // CLEANUP WP

/**
 * Basic WordPress cleanup
 */
add_action( 'after_setup_theme', 'egg_cleanup' );
function egg_cleanup() {
	// launching operation cleanup
	add_action( 'init',						'egg_head_cleanup' );
	// remove WP version from RSS
	add_filter( 'the_generator',			'egg_rss_version' );
}

/**
 * Remove WP version from RSS
 */
function egg_rss_version() {
	return '';
}


/**
 * Cleanup the head output
 */
function egg_head_cleanup() {
	
	// Remove shortlink from head and header
	remove_action( 'wp_head', 				'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'template_redirect',		'wp_shortlink_header', 11, 0 );
	
	// Remove category feeds
	remove_action( 'wp_head',				'feed_links_extra', 3 );
	// Remove windows live writer
	remove_action( 'wp_head',				'wlwmanifest_link' );
	
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
	// Remove WP version from css
	add_filter( 'style_loader_src',			'egg_remove_wp_ver_css_js', 9999 );
	// Remove WP version from scripts
	add_filter( 'script_loader_src',		'egg_remove_wp_ver_css_js', 9999 );
	
	// Remove emoji script
	remove_action( 'wp_head',				'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 	'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 	'print_emoji_styles' );
	remove_action( 'wp_print_styles',		'print_emoji_styles' );
	remove_filter( 'the_content_feed', 		'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 		'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 				'wp_staticize_emoji_for_email' );
	//add_filter( 'emoji_svg_url', 			'__return_false' );
	add_filter( 'wp_resource_hints', 		'egg_disable_emojis_remove_dns_prefetch', 10, 2 );
	add_filter( 'option_use_smilies', 		'__return_false' );
	
	// Remove REST API links
	remove_action( 'wp_head', 				'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 				'wp_oembed_add_discovery_links', 10 );
	remove_action( 'template_redirect', 	'rest_output_link_header', 11 );
	
	// Remove EditURI/RSD link
	remove_action('wp_head', 				'rsd_link');
	
	// Remove Comments Feed
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
	
	// Remove DNS Prefetch
	//remove_action( 'wp_head', 			'wp_resource_hints', 2 );
	
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


/**
 * Disable Comments
 */

// Remove Comments from wpadmin menu (TOP BAR)
add_action( 'wp_before_admin_bar_render', 'egg_remove_comments_admin_bar' );
function egg_remove_comments_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}

// Remove Comments from admin menu (LEFT SIDEBAR)
add_action( 'admin_menu', 'egg_remove_comments_admin_menu', 999 );
function egg_remove_comments_admin_menu() {	
	remove_menu_page('edit-comments.php');
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
}

// Remove from default post types - This doesn't seem to work for Gutenberg
add_action( 'init', 'egg_comments_init' );
function egg_comments_init() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
