<?php
/**
 * Golden Egg Cleanup WP
 *
 * @package   Egg_Cleanup
 * @author    Jacob Snyder <jake@jcow.com>
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */
add_action( 'init', array('Egg_Cleanup', 'init') );

class Egg_Cleanup
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = 'egg_cleanup';

	/**
	 * Initialize the Class
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function init()
	{
		// actions
		add_action( 'after_setup_theme',          array(__CLASS__, 'cleanup') );
		add_action( 'wp_before_admin_bar_render', array(__CLASS__, 'customize_admin_bar') );

		// filters
		add_filter( 'comments_open',              array(__CLASS__, 'filter_media_comment_status'), 10 , 2 );
		add_filter( 'show_admin_bar',             array(__CLASS__, 'admin_bar_permissions') );
		add_filter( 'gettext',                    array(__CLASS__, 'replace_howdy'), 10, 3 );
		add_filter( 'mce_buttons',                array(__CLASS__, 'mce_buttons') );
		add_filter( 'mce_buttons_2',              array(__CLASS__, 'mce_buttons_2') );
		add_filter( 'tiny_mce_before_init',       array(__CLASS__, 'tiny_mce_before_init') );
	}

	/**
	 * Launch some basic cleanup
	 *
	 * Based off Bones by Eddie Machado
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public static function cleanup()
	{
		// launching operation cleanup
		add_action( 'init',                       array(__CLASS__, 'head_cleanup') );
		// remove WP version from RSS
		add_filter( 'the_generator',              array(__CLASS__, 'rss_version') );
		// cleaning up random code around images
		add_filter( 'the_content',                array(__CLASS__, 'filter_ptags_on_images') );
		// cleaning up excerpt
		add_filter( 'excerpt_more',               array(__CLASS__, 'excerpt_more') );
	}

	/**
	 * Cleanup the head output
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public static function head_cleanup() {
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
		add_filter( 'style_loader_src',           array(__CLASS__, 'remove_wp_ver_css_js'), 9999 );
		// remove Wp version from scripts
		add_filter( 'script_loader_src',          array(__CLASS__, 'remove_wp_ver_css_js'), 9999 );
	}

	/**
	 * Remove WP version from RSS
	 *
	 * @since	1.0.0
	 * @return	string Empty string
	 */
	public static function rss_version()
	{
		return '';
	}

	/**
	 * Remove the p from around imgs
	 *
	 * @since	1.0.0
	 * @return	string Modified content
	 */
	public static function filter_ptags_on_images( $content )
	{
		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}

	/**
	 * Updates the [É] for Read More links
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	bool Modified status for comments.
	 */
	public static function excerpt_more( $more )
	{
		global $post;
		return "&hellip;" . '  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="Read ' . get_the_title($post->ID).'">Read more &raquo;</a>';
	}

	/**
	 * Remove WP version from scripts
	 *
	 * @since	1.0.0
	 * @return	bool Modified status for comments.
	 */
	public static function remove_wp_ver_css_js( $src )
	{
		if ( strpos( $src, 'ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}

	/**
	 * Turn off comments on media posts
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	bool Modified status for comments.
	 */
	public static function filter_media_comment_status( $open, $post_id )
	{
		$post = get_post( $post_id );
		if ( 'attachment' == $post->post_type ) return false;

		return $open;
	}

	/**
	 * Remove top admin menu items
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function customize_admin_bar()
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
	 * @author  Tim Bowen
	 * @since	1.0.0
	 * @return	array Modified settings
	 */
	public static function admin_bar_permissions( $content )
	{
		return ( current_user_can('edit_others_posts') ) ? true : false;
	}

	/**
	 * Replace howdy in the admin bar
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	string Modified welcome message.
	 */
	public static function replace_howdy( $translated, $text, $domain )
	{
		if ( false !== strpos($translated, "Howdy") )
		{
			return str_replace("Howdy", "Welcome back", $translated);
		}
		return $translated;
	}

	/**
	 * Customize TinyMCE buttons in row 1
	 *
	 * @author  Tim Bowen
	 * @since	1.0.0
	 * @return	array Modified buttons in row 1
	 */
	public static function mce_buttons( $buttons )
	{
		$remove = array('strikethrough', 'wp_more');
		return array_diff($buttons, $remove);
	}

	/**
	 * Customize TinyMCE buttons in row 2
	 *
	 * @author  Tim Bowen
	 * @since	1.0.0
	 * @return	array Modified buttons in row 2
	 */
	public static function mce_buttons_2( $buttons )
	{
		// Remove items
		$remove  = array('styleselect', 'underline', 'forecolor', 'alignjustify', 'pastetext', 'removeformat', 'wp_help');
		$buttons = array_diff($buttons,$remove);

		// Add in the style selector
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}

	/**
	 * Callback function to filter the MCE settings
	 *
	 * @author  Tim Bowen
	 * @since	1.0.0
	 * @return	array Modified settings
	 */
	public static function tiny_mce_before_init( $settings )
	{
		// Insert the array, JSON ENCODED, into 'style_formats'
		$settings['block_formats'] = "Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5";
		return $settings;
	}
}