<?php
/**
 * Refine WP plugin functionality
 *
 */


/**
 * ACF
 *
 * Adds Options functionality
 */
/*
if(function_exists('acf_add_options_page')) { 
	acf_add_options_page( 
		array (
		'title' => 'Site Elements',
		'position' => '21.1',
		'icon_url' => 'dashicons-archive'
		) 
	);
}
*/


/**
 * Remove front end styles and scripts
 */
function dequeue_plugin_styles() {
	wp_dequeue_style( 'se-link-styles' ); // Search Everything plugin
	wp_dequeue_style( 'acf_locations' ); // ACF Location plugin
}
// add_action( 'wp_enqueue_scripts', 'dequeue_plugin_styles', 20 );


/**
 * Search Everything plugin head cleanup
 */
// remove_action( 'wp_head', 'se_global_head', 10 );
