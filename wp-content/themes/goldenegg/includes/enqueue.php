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
 * Enqueue block JavaScript and CSS for Gutenberg Editor
 */
// Hook the enqueue functions into the editor
add_action( 'enqueue_block_editor_assets', 'egg_block_editor_scripts' );
function egg_block_editor_scripts() {
	
	//$csschanged = filemtime( realpath(__DIR__ . '/..') . '/blocks/portfolio-item/portfolio-item.css' );
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/editor.css' );
	
    // Enqueue block editor JS
/*
    wp_enqueue_script(
        'my-block-editor-js',
        plugins_url( '/blocks/portfolio-item/portfolio-item.js', __FILE__ ),
        [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/portfolio-item/portfolio-item.js' )	
    );
*/

    // Enqueue block editor styles
/*
    wp_enqueue_style(
        'my-block-editor-css',
        plugins_url( '/blocks/custom-block/editor-styles.css', __FILE__ ),
        [ 'wp-edit-blocks' ],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/portfolio-item/portfolio-item.css' )	
    );
*/
    
    wp_register_style( 'egg-block-editor-css', get_stylesheet_directory_uri() . '/assets/css/editor.css?v=' . $csschanged, [ 'wp-edit-blocks' ], '', 'all' );


}



/**
 * Enqueue frontend and editor JavaScript and CSS
 */
// Hook the enqueue functions into the frontend and editor
add_action( 'enqueue_block_assets', 'egg_block_scripts' );
function egg_block_scripts() {
	
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/style.css' );
	
    // Enqueue block editor styles
/*
    wp_enqueue_style(
        'my-block-css',
        plugins_url( '/blocks/portfolio-item/portfolio-item.css', __FILE__ ),
        [],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/portfolio-item/portfolio-item.css' )	
    );
*/
    wp_enqueue_style( 'egg-block-css', get_stylesheet_directory_uri() . '/assets/css/editor.css?v=' . $csschanged, [ 'wp-edit-blocks' ], '', 'all' );

}

