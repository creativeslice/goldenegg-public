<?php
/**
 * Cleanup WP functionality
 *
 * @return	void
 */
add_action( 'init', 'egg_init' );
function egg_init()
{
	// actions
	add_action( 'after_setup_theme',          'egg_cleanup' );
	add_action( 'wp_before_admin_bar_render', 'egg_customize_admin_bar' );

	// filters
	add_filter( 'comments_open',              'egg_filter_media_comment_status', 10 , 2 );
	add_filter( 'show_admin_bar',             'egg_admin_bar_permissions' );
	add_filter( 'gettext',                    'egg_replace_howdy', 10, 3 );
}

/**
 * Launch some basic cleanup
 *
 * @return	void
 */
function egg_cleanup()
{
	// launching operation cleanup
	add_action( 'init',                       'egg_head_cleanup' );
	// remove WP version from RSS
	add_filter( 'the_generator',              'egg_rss_version' );
	// cleaning up random code around images
	add_filter( 'the_content',                'egg_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more',               'egg_excerpt_more' );
}

/**
 * Cleanup the head output
 *
 * @return	void
 */
function head_cleanup() {
	// Remove shortlink from head and header
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
	// category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0); 
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src',           'egg_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src',          'egg_remove_wp_ver_css_js', 9999 );
}

/**
 * Remove WP version from RSS
 *
 * @return	string Empty string
 */
function egg_rss_version()
{
	return '';
}

/**
 * Remove the p from around imgs
 *
 * @return	string Modified content
 */
function egg_filter_ptags_on_images( $content )
{
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

/**
 * Updates the [É] for Read More links
 *
 * @return	bool Modified status for comments.
 */
function egg_excerpt_more( $more )
{
	global $post;
	return "&hellip;" . '  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="Read ' . get_the_title($post->ID).'">Read more &raquo;</a>';
}

/**
 * Remove WP version from scripts
 *
 * @return	bool Modified status for comments.
 */
function egg_remove_wp_ver_css_js( $src )
{
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

/**
 * Turn off comments on media posts
 *
 * @return	bool Modified status for comments.
 */
function egg_filter_media_comment_status( $open, $post_id )
{
	$post = get_post( $post_id );
	if ( 'attachment' == $post->post_type ) return false;

	return $open;
}

/**
 * Remove top admin menu items
 *
 * @return	void
 */
function egg_customize_admin_bar()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('view-site');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('new-link');
	$wp_admin_bar->remove_menu('new-media');
	$wp_admin_bar->remove_menu('new-user');
	$wp_admin_bar->remove_menu('comments');
}

/**
 * Force the admin bar on for editors and admins and off for below
 *
 * @return	array Modified settings
 */
function egg_admin_bar_permissions( $content )
{
	return ( current_user_can('edit_others_posts') ) ? true : false;
}

/**
 * Replace howdy in the admin bar
 *
 * @return	string Modified welcome message.
 */
function egg_replace_howdy( $translated, $text, $domain )
{
	if ( false !== strpos($translated, "Howdy") )
	{
		return str_replace("Howdy", "Welcome back", $translated);
	}
	return $translated;
}