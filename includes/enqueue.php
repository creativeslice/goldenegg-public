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

	/* Call jQuery from Google CDN */
	//wp_deregister_script('jquery');
	//wp_register_script('jquery', ('//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'), false, '3.3.1', false);
	
	/* Add modified date for cache busting */
	$jschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/js/scripts.js' );
	
	/* Scripts */
	wp_register_script( 'egg-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js?' . $jschanged, array( 'jquery' ), '', false );
	wp_enqueue_script( 'egg-js');
}


/**
 * Defer ALL enqueued scripts
 */
if (! is_admin() ) {
	add_filter( 'script_loader_tag', function ( $tag, $handle ) {
		return str_replace( ' src', ' defer="defer" src', $tag );
	}, 10, 2 );
}


/**
 * Gravity Form Scripts
 * wrap GF inline scripts in DOMContentLoaded event listeners 
 * so they aren't triggered before jQuery loads
 */
/*
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open' );
function wrap_gform_cdata_open( $content = '' ) {
    $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
    return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close' );
function wrap_gform_cdata_close( $content = '' ) {
    $content = ' }, false );';
    return $content;
}

// GF fix AJAX forms to work with redirect
add_filter( 'gform_confirmation', 'cs_gform_ajax_redirect', 10, 4);
function cs_gform_ajax_redirect( $confirmation, $form, $entry, $ajax ) {
    if ( $ajax && $form['confirmation']['type'] == 'page' ) {
        $confirmation = "<script>function gformRedirect(){document.location.href='" . $confirmation['redirect'] . "';}</script>";    
    } elseif ( $ajax && $form['confirmation']['type'] == 'redirect' ) {
	    $confirmation = "<script>function gformRedirect(){document.location.href='" . $form['confirmation']['url'] . "';}</script>"; 
    }
    return $confirmation;
}
*/


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
