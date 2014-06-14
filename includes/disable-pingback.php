<?php
/**
 * Golden Egg Disable XMLRPC and Pingbacks/Trackbacks
 */

// remove RSD link
remove_action( 'wp_head', 'rsd_link' );

// actions
add_action( 'xmlrpc_call',                        'egg_disable_xmlrpc' );

// filters
add_filter( 'wp_headers',                         'egg_remove_pt_headers', 10, 1 );
add_filter( 'rewrite_rules_array',                'egg_remove_pt_rewrites' );
add_filter( 'bloginfo_url',                       'egg_remove_pt_pingback_url', 10, 2 );
add_filter( 'pre_update_option_enable_xmlrpc',    '__return_false' );
add_filter( 'pre_option_enable_xmlrpc',           '__return_zero' );

/**
 * Disable XMLRPC call
 */
function egg_disable_xmlrpc( $action )
{
	if ( 'pingback.ping' === $action )
	{
		wp_die( 
			'Pingbacks are not supported', 
			'Not Allowed!', 
			array( 'response' => 403 )
		);
	}
}

/**
 * DISABLING PINGBACKS AND TRACKBACKS
 * Intercepts header and rewrites X-Pingback
 * Does not modify $post['ping_status'] - could read 'open'
 * Does not modify $default_ping_status - could read 'open'
 */
function egg_remove_pt_headers( $headers )
{
	if( isset( $headers['X-Pingback'] ) )
	{
		unset( $headers['X-Pingback'] );
	}
	return $headers;
}
 
/**
 * Kill the rewrite rule
 */
function egg_remove_pt_rewrites( $rules )
{
	foreach ( $rules as $rule => $rewrite )
	{
		if ( preg_match( '/trackback\/\?\$$/i', $rule ) )
		{
			unset( $rules[$rule] );
		}
	}
	return $rules;
}
 
/**
 * Kill bloginfo( 'pingback_url' )
 */
function egg_remove_pt_pingback_url( $output, $show )
{
	if ( 'pingback_url' == $show )
	{
		$output = '';
	}
	return $output;
}