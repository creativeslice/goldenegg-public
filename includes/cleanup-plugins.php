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


/**
 * Deregister admin styles on the front end when using ACF forms
 * /
add_action( 'wp_print_styles', 'custom_acf_deregister_styles', 100 );
function custom_acf_deregister_styles()
{
	if (! is_admin() ) wp_deregister_style( 'wp-admin' );
}
/**
 * Deregister most of the ACF default styles
 * /
add_action( 'wp_print_styles', 'remove_acf_styles', 200 );
function remove_acf_styles()
{
	$styles = array(
		'acf',
		'acf-field-group',
		'acf-pro-field-group',
		'acf-global',
		'acf-input',
		'acf-pro-input',
		'acf-datepicker',
	);
	foreach( $styles as $v ) {
		wp_deregister_style( $v ); 
	}
}
