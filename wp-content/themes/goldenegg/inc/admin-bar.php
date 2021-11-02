<?php
/**
 * Cleanup: WordPress Admin
 * 
 * Author: Creative Slice
 * URI: https://github.com/creativeslice/goldenegg
 * Version: 1.0
*/
 
 

/**
* Removes hard-coded admin bar offsets
*/
add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );


/**
 * Style front end admin bar.
 */
function egg_admin_bar_style() {
	if ( is_user_logged_in() ) {
	    echo "<style type='text/css'>
	    @media (min-width: 782px){
			#wpadminbar {
				height: 40px;
				width: auto;
				min-width: 40px;
				background: rgba(29,35,39,.8);
				/*
				border-right: 4px solid var(--wp--preset--color--primary);
				border-color: rgb(29,35,39);
				box-shadow: 1px 1px 0 1px rgb(29,35,39);
				*/
				border-bottom-right-radius: 3px;
				outline: 1px solid rgba(255,255,255,.4);
				padding-right: 4px;
			}
			#wpadminbar .quicklinks a {
				height: 40px;
				line-height: 40px;
			}
			#wpadminbar .quicklinks a::before {
				padding: 8px 0;
			}
			#wp-admin-bar-my-account {
				display: none;
			}
		}
		#wpadminbar #wp-admin-bar-site-name>.ab-item {
			/*border-right: 1px solid rgba(255,255,255,.2);*/
			padding: 0 12px 0 10px;
			/*background: rgb(30,30,30);*/
		}
		#wpadminbar #wp-admin-bar-site-name>.ab-item::before {
			content: '\\f324';
			margin-right: 0;
			color: white;
		}
		</style>";
	}
}
add_action( 'wp_head', 'egg_admin_bar_style' );


/**
* Modify the admin bar left link title
*/
function egg_admin_bar_titles( ) {
	if(is_admin()) { 
		$title = "Home";
	} else {
		$title = "";
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array(
			'id'    => 'site-name',
			'title' => $title,
		));
	}
}
add_action( 'wp_before_admin_bar_render', 'egg_admin_bar_titles' );


/**
 * Remove howdy next to username in the admin bar
 */
function egg_replace_howdy( $translated, $text, $domain ) {
	if ( false !== strpos($translated, "Howdy") ) {
		return str_replace("Howdy,", "", $translated);
	}
	return $translated;
}
add_filter( 'gettext', 'egg_replace_howdy', 10, 3 );


/**
 * Remove top admin menu items
 */
function egg_customize_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('search');
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
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('customize-themes');
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('widgets');
	
	// Plugins
	# $wp_admin_bar->remove_node('rank-math'); // Rank Math plugin
}
add_action( 'wp_before_admin_bar_render', 'egg_customize_admin_bar' );


