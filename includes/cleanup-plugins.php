<?php
/**
 * Cleanup WP plugin functionality
 *
 * @return	void
 */


/**
 * Moving Gravity Form scripts to footer (even the ajax ones)
 */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
	return true;
}

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

/**
 * Tabindex fix for Gravity Forms
 */
add_filter("gform_tabindex", create_function("", "return 4;"));


/**
 * Remove front end styles and scripts from Search Everything plugin
 */
function dequeue_badly_written_se() {
  wp_dequeue_style( 'se-link-styles' );
}
add_action('wp_enqueue_scripts', 'dequeue_badly_written_se');

remove_action( 'wp_head', 'se_global_head', 10 );
