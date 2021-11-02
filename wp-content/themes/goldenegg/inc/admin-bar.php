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
function cslice_admin_bar_style() {
	if ( is_user_logged_in() ) {
	    echo "<style type='text/css'>
	    @media (min-width: 782px){
			#wpadminbar {
				width: auto;
				min-width: 400px;
				background: rgba(29,35,39,.9);
				border-bottom-right-radius: 4px;
			}
		}
		#wpadminbar #wp-admin-bar-site-name>.ab-item::before {
			content: '\\f324';
			margin-right: 0;
		}
		</style>";
	}
}
add_action( 'wp_head', 'cslice_admin_bar_style' );


/**
* Modify the admin bar left link title
*/
function cslice_admin_bar_titles( ) {
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
add_action( 'wp_before_admin_bar_render', 'cslice_admin_bar_titles' );


/**
 * Remove howdy next to username in the admin bar
 */
function cslice_replace_howdy( $translated, $text, $domain ) {
	if ( false !== strpos($translated, "Howdy") ) {
		return str_replace("Howdy,", "", $translated);
	}
	return $translated;
}
add_filter( 'gettext', 'cslice_replace_howdy', 10, 3 );


/**
 * Remove top admin menu items
 */
function cslice_customize_admin_bar() {
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
add_action( 'wp_before_admin_bar_render', 'cslice_customize_admin_bar' );


