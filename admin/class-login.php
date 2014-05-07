<?php
/**
 * Golden Egg Customize Login
 *
 * @package   Egg_Login
 * @author    Jacob Snyder <jake@jcow.com>
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */
add_action( 'admin_init', array('Egg_Login', 'init') );

class Egg_Login
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = 'egg_login';

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
		add_action( 'login_enqueue_scripts',      array(__CLASS__, 'login_css'), 10 );

		// filters
		add_filter( 'login_headerurl',            array(__CLASS__, 'login_url') );
		add_filter( 'login_headertitle',          array(__CLASS__, 'login_title') );
	}

	/**
	 * Add theme log in css
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function login_css()
	{
		wp_enqueue_style( self::PREFIX . '_login', get_template_directory_uri() . '/assets/css/login.css', false );
	}

	/**
	 * Change the logo link from wordpress.org to the site home
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function login_url()
	{
		return home_url( '/' );
	}

	/**
	 * Change the alt text on the logo to site name
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function login_title()
	{
		return get_option('blogname');
	}
}