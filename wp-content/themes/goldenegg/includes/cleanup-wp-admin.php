<?php // CLEANUP WP ADMIN

/**
 * Customize the login screen
 */
function egg_login_init() {
	add_action( 'login_enqueue_scripts', 	'egg_login_css' );
	add_filter( 'login_headerurl',			'egg_login_url' );
	add_filter( 'login_headertext',			'egg_login_title' );
}
add_action( 'login_init', 'egg_login_init' );

// Add theme login CSS
function egg_login_css() { wp_enqueue_style( 'egg_admin_login', get_template_directory_uri() . '/assets/css/login.css', false ); }

// Change logo link to site home
function egg_login_url() { return home_url( '/' ); }

// Change the alt text on the logo to site name
function egg_login_title() { return get_option('blogname'); }



/**
 * Re-enable infinite scrolling in media library
 */
add_filter( 'media_library_infinite_scrolling', '__return_true' );


/**
 * Turn OFF Theme Editor - PAGELY already does this
 */
#define( 'DISALLOW_FILE_EDIT', true );


/**
 * Turn off Autosave (does not currently work with Gutenberg)
 */

function disable_autosave() {
	wp_deregister_script( 'autosave' );
}
add_action( 'admin_init', 'disable_autosave', 999);



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

