<?php
/**
 * Admin: WordPress Login
 * 
 * Author: Creative Slice
 * URI: https://github.com/creativeslice/goldenegg
 * Version: 1.0.1
*/


/**
 * Change logo from WordPress to site logo.
 */
function egg_login_css() {
	echo '<style type="text/css">
		body.login #login h1 a {
			background: url("' . get_template_directory_uri() . '/assets/img/login-logo.png") no-repeat top center;
			background-size: contain;
			width: 300px;
			height: 80px;
		}
		</style>';
}
add_action( 'login_enqueue_scripts', 'egg_login_css' );


// Change logo link from WordPress to the site home.
function egg_login_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'egg_login_url' );


// Change alt text on the logo to site name
function egg_login_title() {
	return get_option('blogname');
}
add_filter( 'login_headertext', 'egg_login_title' );
