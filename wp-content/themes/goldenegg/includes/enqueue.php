<?php

/**
 * Load CSS
 */
add_action( 'wp_enqueue_scripts', 'egg_styles', 999 );
function egg_styles() {
	
	/* Add modified date for cache busting */
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/style.css' );
	
	wp_register_style( 'egg-stylesheet', get_stylesheet_directory_uri() . '/assets/css/style.css?v=' . $csschanged, array(), '', 'all' );
	wp_enqueue_style( 'egg-stylesheet');
}


/**
 * Load JS
 */
add_action( 'wp_enqueue_scripts', 'egg_scripts', 999 );
function egg_scripts() {
	
	/* Add modified date for cache busting */
	$jschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/js/scripts.js' );
	
	/* Scripts */
	wp_register_script( 'egg-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js?' . $jschanged, array( 'jquery' ), '', false );
	wp_enqueue_script( 'egg-js');
}


 /**
 * Remove jQuery Migrate and wp-embed scripts
 */
add_filter('wp_default_scripts', 'egg_dequeue_jquery_migrate');
function egg_dequeue_jquery_migrate(&$scripts) {
    if (!is_admin()) {
        $scripts->remove('wp-embed');
        $scripts->remove('jquery');
        $scripts->add('jquery', FALSE, array('jquery-core'), '1.10.2');
    }
}
