<?php
/**
 * Customize the login screen
 */
 
add_action( 'login_init', 'egg_login_init' );
function egg_login_init() {
	
	// actions
	add_action( 'login_enqueue_scripts', 'egg_login_css' );

	// filters
	add_filter( 'login_headerurl',       'egg_login_url' );
	add_filter( 'login_headertitle',     'egg_login_title' );
}


/**
 * Add theme log in CSS
 */
function egg_login_css() {
	wp_enqueue_style( 'egg_admin_login', get_template_directory_uri() . '/assets/css/login.css', false );
}


/**
 * Change the logo link from wordpress.org to the site home
 */
function egg_login_url() {
	return home_url( '/' );
}


/**
 * Change the alt text on the logo to site name
 */
function egg_login_title() {
	return get_option('blogname');
}
