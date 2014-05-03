<?php

/*********************
SCRIPTS & ENQUEUEING
*********************/

function bones_enqueue() {

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );

}

add_action( 'after_setup_theme', 'bones_enqueue' );




// loading modernizr and jquery, and reply script
function bones_scripts_and_styles() {
global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet

  if (!is_admin()) {
  
  	// call jQuery from Google and move to footer
	// wp_deregister_script('jquery');
	// wp_register_script('jquery', ("//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"), false, '1.11.0', true);

	// modernizr (without media query polyfill)
	wp_register_script( 'bones-modernizr', get_stylesheet_directory_uri() . '/assets/js/modernizr.custom.min.js', array(), '2.5.3', false );

	// register main stylesheet
	wp_register_style( 'bones-stylesheet', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), '', 'all' );

	// ie-only style sheet
	wp_register_style( 'bones-ie-only', get_stylesheet_directory_uri() . '/assets/css/ie.css', array(), '' );

	// comment reply script for threaded comments
	if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
		wp_enqueue_script( 'comment-reply' );
	}

	//adding scripts file in the footer
	wp_register_script( 'bones-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '', true );

	// enqueue styles and scripts
	wp_enqueue_script( 'bones-modernizr' );
	wp_enqueue_style( 'bones-stylesheet' );
	wp_enqueue_style( 'bones-ie-only' );

	$wp_styles->add_data( 'bones-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bones-js' );

	}
}

?>