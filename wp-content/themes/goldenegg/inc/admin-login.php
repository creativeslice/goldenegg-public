<?php
/**
 * Admin: WordPress Login
 * 
 * Author: Creative Slice
 * URI: https://github.com/creativeslice/goldenegg
 * Version: 1.0
*/


/**
 * Change logo from WordPress to site logo.
 */
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


// Change logo link from WordPress to the site home.
function cslice_login_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'cslice_login_url' );


// Change alt text on the logo to site name
function cslice_login_title() {
	return get_option('blogname');
}
add_filter( 'login_headertext', 'cslice_login_title' );

