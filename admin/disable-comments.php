<?php
//Remove ping and comments from Quick Edit
add_action( 'admin_head-edit.php', 'modify_quick_edit' );
function modify_quick_edit() 
{    
    global $current_screen;
    if( 'edit-post' != $current_screen->id && 'edit-page' != $current_screen->id )
        return;
    ?>
    <script type="text/javascript">         
        jQuery(document).ready( function($) {
            $('span:contains("Allow Comments")').each(function (i) {
                $(this).parent().remove();
            });
            $('span:contains("Allow Pings")').each(function (i) {
                $(this).parent().remove();
            });
        });    
    </script>
    <?php
} 
//Remove Comments from dashboard
function remove_my_comment_metaboxes() {
	remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments Status Metabox
	remove_meta_box( 'commentsdiv','post','normal' ); // Comments Metabox
	remove_meta_box( 'commentstatusdiv','page','normal' ); // Comments Metabox
	remove_meta_box( 'commentsdiv','page','normal' ); // Comments Metabox
}
add_action('admin_menu','remove_my_comment_metaboxes');

//Remove Comments Column from dashboard
function my_columns_filter( $columns ) {
   unset($columns['comments']);
   return $columns;
}
add_filter( 'manage_edit-page_columns', 'my_columns_filter',10, 1 );	
add_filter( 'manage_edit-post_columns', 'my_columns_filter',10, 1 );
add_filter( 'manage_edit-CUSTOMPOSTTYPE_columns', 'my_columns_filter',10, 1 );

/**
 * DISABLING PINGBACKS AND TRACKBACKS
 * Intercepts header and rewrites X-Pingback
 * Does not modify $post['ping_status'] - could read 'open'
 * Does not modify $default_ping_status - could read 'open'
 **/
 
add_filter( 'wp_headers', 'pmg_kt_filter_headers', 10, 1 );
function pmg_kt_filter_headers( $headers )
{
	if( isset( $headers['X-Pingback'] ) )
	{
		unset( $headers['X-Pingback'] );
	}
	return $headers;
}
 
// Kill the rewrite rule
add_filter( 'rewrite_rules_array', 'pmg_kt_filter_rewrites' );
function pmg_kt_filter_rewrites( $rules )
{
	foreach( $rules as $rule => $rewrite )
	{
		if( preg_match( '/trackback\/\?\$$/i', $rule ) )
		{
			unset( $rules[$rule] );
		}
	}
	return $rules;
}
 
// Kill bloginfo( 'pingback_url' )
add_filter( 'bloginfo_url', 'pmg_kt_kill_pingback_url', 10, 2 );
function pmg_kt_kill_pingback_url( $output, $show )
{
	if( $show == 'pingback_url' )
	{
		$output = '';
	}
	return $output;
}
 
// remove RSD link
remove_action( 'wp_head', 'rsd_link' );
 
// hijack options updating for XMLRPC
add_filter( 'pre_update_option_enable_xmlrpc', '__return_false' );
add_filter( 'pre_option_enable_xmlrpc', '__return_zero' );
 
// Disable XMLRPC call
add_action( 'xmlrpc_call', 'pmg_kt_kill_xmlrpc' );
function pmg_kt_kill_xmlrpc( $action )
{
	if( 'pingback.ping' === $action )
	{
		wp_die( 
			'Pingbacks are not supported', 
			'Not Allowed!', 
			array( 'response' => 403 )
		);
	}
}

?>