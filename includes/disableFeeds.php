<?php
/*
Plugin Name: Sewn In Remove WordPress Feeds
Description: Disable feeds in order to not leak information out through unused feeds.
Version: 1.0.0
Author: Jake Snyder
Author URI: http://Jupitercow.com/
*/

if (! class_exists('sewn_remove_feeds') ) :

add_action( 'init', array('sewn_remove_feeds', 'init') );

class sewn_remove_feeds
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = __CLASS__;

	/**
	 * Add feed types
	 *
	 * @since 	1.0.0
	 * @var 	array
	 */
	public static $feed_types = array( '', 'rdf', 'rss', 'rss2', 'atom', 'rss2_comments', 'atom_comments' );

	/**
	 * Initialize the Class
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function init()
	{
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		foreach( apply_filters( self::PREFIX . '/all_feeds', self::$feed_types ) as $feed )
		{
			if ( $feed )
			{
				if ( apply_filters( self::PREFIX . '/type=' . $feed, true ) )
				{
					add_action( 'do_feed_' . $feed, array(__CLASS__, 'disable_feeds'), 1 );
				}
			}
		}
	}

	/**
	 * Disable the feeds by redirecting them to the homepage
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function disable_feeds()
	{
		wp_redirect( home_url('/'), 302 );
		die;
	}
}

endif;