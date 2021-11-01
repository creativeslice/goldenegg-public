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


// Plugin: SearchWP - Remove top bar menu item
add_filter( 'searchwp\admin_bar', '__return_false' ); 




/**
 * WordPress Admin Login
 * 
 */
// Change logo from WordPress to custom theme.
function cslice_login_css() {
	echo '<style type="text/css">
		body.login {
			background: #efefef;
		}
		body.login h1 a {
			background: url("' . get_template_directory_uri() . '/assets/img/login-logo.png") no-repeat top center;
			background-size: contain;
			width: 300px;
			height: 40px;
		}
		</style>';
}
add_action( 'login_enqueue_scripts', 'cslice_login_css' );

// Change logo link from wordpress.org to the site home.
function cslice_login_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'cslice_login_url' );

// Change alt text on the logo to site name
function cslice_login_title() {
	return get_option('blogname');
}
add_filter( 'login_headertext', 'cslice_login_title' );




/**
 * DASHBOARD
 */


/**
 * Remove some admin pages like links
 */
function egg_remove_menu_pages() {
	remove_menu_page('link-manager.php');
	remove_submenu_page( 'tools.php', 'site-health.php' );
	if (! current_user_can('manage_options') ) remove_menu_page('tools.php');
	
	// Hide CPT UI plugin menu
	//remove_menu_page('cptui_main_menu');
	
	//echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
}
//add_action( 'admin_menu', 'egg_remove_menu_pages', 999 );




/**
 * Customize admin footer
 */
function egg_admin_footer() { ?>
	<span id="footer-thankyou">Built by Creative Slice with WordPress <?php echo get_bloginfo( 'version' ); ?></span>
<?php }
add_filter( 'admin_footer_text', 'egg_admin_footer' );

