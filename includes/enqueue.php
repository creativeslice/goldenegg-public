<?php

/**
 * Load in the styles
 */
add_action( 'wp_enqueue_scripts', 'egg_styles', 999 );
function egg_styles() {
	
	/* Add modified date for cache busting */
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/style.css' );
	
	wp_register_style( 'egg-stylesheet', get_stylesheet_directory_uri() . '/assets/css/style.css?v=' . $csschanged, array(), '', 'all' );
	wp_enqueue_style( 'egg-stylesheet');
}

/**
 * Load in the scripts
 */
add_action( 'wp_enqueue_scripts', 'egg_scripts', 999 );
function egg_scripts() {
	
	/* Move Gravity Form scripts to footer - does NOT work with AJAX */
	//add_filter( 'gform_init_scripts_footer', '__return_true' );
	
	/* Move core jQuery to footer */
	wp_deregister_script('jquery');
	wp_register_script('jquery', includes_url( '/js/jquery/jquery.js' ), false, null, true);
	//wp_register_script('jquery', ('//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js'), false, '2.2.4', true);
	
	/* Add modified date for cache busting */
	$jschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/js/scripts.js' );
	
	/* Scripts */
	wp_register_script( 'egg-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js?' . $jschanged, array( 'jquery' ), '', true );
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
