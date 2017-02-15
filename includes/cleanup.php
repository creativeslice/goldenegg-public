<?php
/**
 * Cleanup WP functionality
 */
add_action( 'after_setup_theme',			'egg_cleanup' );


/**
 * Launch some basic cleanup
 */
function egg_cleanup() {
	// launching operation cleanup
	add_action( 'init',						'egg_head_cleanup' );
	// remove WP version from RSS
	add_filter( 'the_generator',			'egg_rss_version' );
	// cleaning up random code around images
	add_filter( 'the_content',				'egg_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more',				'egg_excerpt_more' );
	// shorten excerpt
	#add_filter( 'excerpt_length',			'custom_excerpt_length', 999 );
	// stop srcset images
	add_filter( 'wp_calculate_image_srcset', '__return_false' );
	// change thumbnail image quality
	#add_filter( 'jpeg_quality', 			'custom_jpeg_quality', 10, 2 );
}


/**
 * Update JPEG compression quality (WP 4.5 sets 82 by default)
 *
 * @return	quality percentage
 */
function custom_jpeg_quality( $quality, $context ) {
	return 90;
}


/**
 * Cleanup the head output
 */
function egg_head_cleanup() {
	// Remove canonical links
	#remove_action('wp_head', 				'rel_canonical');
	// Remove shortlink from head and header
	remove_action( 'wp_head', 				'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'template_redirect',		'wp_shortlink_header', 11, 0 );
	// Remove category feeds
	remove_action( 'wp_head',				'feed_links_extra', 3 );
	// Remove post and comment feeds
	remove_action( 'wp_head',				'feed_links', 2 );
	// Remove windows live writer
	remove_action( 'wp_head',				'wlwmanifest_link' );
	// Remove index link
	remove_action( 'wp_head',				'index_rel_link' );
	// Remove previous link
	remove_action( 'wp_head',				'parent_post_rel_link', 10, 0 );
	// Remove start link
	remove_action( 'wp_head',				'start_post_rel_link', 10, 0 );
	// Remove links for adjacent posts
	remove_action( 'wp_head',				'adjacent_posts_rel_link', 10, 0); 
	remove_action( 'wp_head',				'adjacent_posts_rel_link_wp_head', 10, 0 );
	// Remove WP version from head
	remove_action( 'wp_head',				'wp_generator' );
	// Remove WP version from css
	add_filter( 'style_loader_src',			'egg_remove_wp_ver_css_js', 9999 );
	// Remove WP version from scripts
	add_filter( 'script_loader_src',		'egg_remove_wp_ver_css_js', 9999 );
	// Remove emoji script
	remove_action( 'wp_head',				'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles',		'print_emoji_styles' );
	add_filter( 'emoji_svg_url', 			'__return_false' );
	// Remove REST API links
	remove_action( 'wp_head', 				'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 				'wp_oembed_add_discovery_links', 10 );
	// Remove DNS Prefetch
	//remove_action( 'wp_head', 			'wp_resource_hints', 2 );
}


/**
 * Remove WP version from RSS
 *
 * @return	string Empty string
 */
function egg_rss_version() {
	return '';
}


/**
 * Remove the p from around imgs
 *
 * @return	string Modified content
 */
function egg_filter_ptags_on_images( $content ) {
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


/**
 * Updates the […] for Read More links
 *
 * @return	bool Modified status for comments.
 */
function egg_excerpt_more( $more ) {
	global $post;
	return "&hellip;" . '  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="Read ' . get_the_title($post->ID).'">Read more &raquo;</a>';
}


/**
 * Shorten excerpt length
 *
 * @return	Modified character length
 */
function custom_excerpt_length( $length ) {
	return 33; // number of characters
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
