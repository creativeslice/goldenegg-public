<?php

/**
 * Add enqueue scripts/styles
 */
add_action( 'after_setup_theme', 'egg_enqueue' );
function egg_enqueue() {
	add_action( 'wp_enqueue_scripts', 'egg_styles', 999 );
	add_action( 'wp_enqueue_scripts', 'egg_scripts', 999 );
}


/**
 * Load in the styles
 */
function egg_styles() {

	/* DEV Styles */
	wp_register_style( 'egg-stylesheet', get_stylesheet_directory_uri() . '/assets/css/style.css?' . date("U"), array(), '', 'all' );
	
	/* PRODUCTION Styles */
	//wp_register_style( 'egg-stylesheet', get_stylesheet_directory_uri() . '/assets/css/style.min.css', array(), '', 'all' );

	wp_enqueue_style( 'egg-stylesheet');
}


/**
 * Load in the scripts
 */
function egg_scripts() {
	
	/* Move core jQuery to footer */
	wp_deregister_script('jquery');
	wp_register_script('jquery', includes_url( '/js/jquery/jquery.js' ), false, null, true);
	
	/* DEV Scripts */
	wp_register_script( 'egg-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js?' . date("U"), array( 'jquery' ), '', true );
	
	/* PRODUCTION Scripts */
	//wp_register_script( 'egg-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '', true );
	
	// enqueue styles and scripts
	wp_enqueue_script( 'egg-js');
}


/**
 * Remove jQuery Migrate and wp-embed scripts
 */
add_filter( 'wp_default_scripts', 'egg_dequeue_jquery_migrate' );
function egg_dequeue_jquery_migrate( &$scripts ) {
	if (! is_admin() ) {
		$scripts->remove( 'wp-embed');
		$scripts->remove( 'jquery');
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}
