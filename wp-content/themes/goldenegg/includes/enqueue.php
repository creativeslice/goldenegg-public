<?php

/**
 * Load CSS
 */
add_action( 'wp_enqueue_scripts', 'egg_styles', 999 );
function egg_styles() {
	
	/* Add modified date for cache busting */
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/styles.css' );
	
	wp_register_style( 'egg-stylesheet', get_stylesheet_directory_uri() . '/assets/css/styles.css?v=' . $csschanged, array(), '', 'all' );
	wp_enqueue_style( 'egg-stylesheet');
}


/**
 * Load JS
 */
add_action( 'wp_enqueue_scripts', 'egg_scripts', 999 );
function egg_scripts() {

	/* Call jQuery from Google CDN */
	wp_deregister_script('jquery');
	wp_register_script('jquery', ('//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'), false, '3.4.1', false);
	
	/* Add modified date for cache busting */
	$jschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/js/scripts.js' );
	
	/* Scripts */
	wp_register_script( 'egg-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js?' . $jschanged, array( 'jquery' ), '', false );
	wp_enqueue_script( 'egg-js');

    /* Enqueue Live-Reload only in local environent */
    if ( $_SERVER["SERVER_ADDR"] == '172.17.0.2' || $_SERVER["SERVER_ADDR"] == '127.0.0.1') {
        /* Scripts */
        wp_enqueue_script('live-reload', 'http://localhost:35729/livereload.js' , '', '', false );
    }
}


/**
 * Defer most enqueued scripts
 */
if (!is_admin() ) {
	add_filter( 'script_loader_tag', function ( $tag, $handle ) {
		// We need jquery as soon as possible because GF captcha is inline and doesn't defer
		// Note that our jquery enqueued above has a handle of "jquery" but the gravity forms
		// modal window is enqueued as "jquery-core".
		/*if (($handle == 'jquery') || ($handle == 'jquery-core')) {
			return $tag;
			/// return str_replace( ' src', ' async="async" src', $tag ); // only works in chrome
		} else {
			return str_replace( ' src', ' defer="defer" src', $tag );
		}
		*/
		return str_replace( ' src', ' defer="defer" src', $tag );
	}, 99, 2 );
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

