<?php
/**
 * Makes adjustments for disabling ALL comments
 */

// actions
add_action( 'wp_before_admin_bar_render', 'comments_admin_bar' );
add_action( 'admin_menu', 'adjust_the_wp_menu', 999 );
add_action( 'admin_head-edit.php', 'modify_quick_edit' );
add_action( 'admin_menu','remove_my_comment_metaboxes');
add_action( 'xmlrpc_call', 'pmg_kt_kill_xmlrpc' );

// filters
add_filter( 'manage_edit-page_columns', 'my_columns_filter',10, 1 );	
add_filter( 'manage_edit-post_columns', 'my_columns_filter',10, 1 );
add_filter( 'manage_media_columns', 'my_columns_filter',10, 1 );	
add_filter( 'manage_edit-CUSTOMPOSTTYPE_columns', 'my_columns_filter',10, 1 );
add_filter( 'wp_headers', 'pmg_kt_filter_headers', 10, 1 );
add_filter( 'rewrite_rules_array', 'pmg_kt_filter_rewrites' );
add_filter( 'bloginfo_url', 'pmg_kt_kill_pingback_url', 10, 2 );
add_filter( 'pre_update_option_enable_xmlrpc', '__return_false' );
add_filter( 'pre_option_enable_xmlrpc', '__return_zero' );

/**
 * Remove from wpadmin menu (TOP BAR)
 **/
function comments_admin_bar()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}

/**
 * Remove from admin menu (LEFT SIDEBAR)
 **/
function adjust_the_wp_menu()
{	
	remove_menu_page('edit-comments.php');
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
}

/**
 * Remove ping option and comments option from Quick Edit
 **/
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

/**
 * Remove Comments Widget from dashboard and metaboxes from Pages & Posts
 **/
function remove_my_comment_metaboxes()
{
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core');	// Comments Widget
	remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments Status Metabox
	remove_meta_box( 'commentsdiv','post','normal' ); // Comments Metabox
	remove_meta_box( 'commentstatusdiv','page','normal' ); // Comments Metabox
	remove_meta_box( 'commentsdiv','page','normal' ); // Comments Metabox
}

/**
 * Remove Comments Column from lists-table
 **/
function my_columns_filter( $columns )
{
   unset($columns['comments']);
   return $columns;
}

/**
 * DISABLING PINGBACKS AND TRACKBACKS
 * Intercepts header and rewrites X-Pingback
 * Does not modify $post['ping_status'] - could read 'open'
 * Does not modify $default_ping_status - could read 'open'
 **/
function pmg_kt_filter_headers( $headers )
{
	if( isset( $headers['X-Pingback'] ) )
	{
		unset( $headers['X-Pingback'] );
	}
	return $headers;
}
 
/**
 * Kill the rewrite rule
 **/
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

/**
 * Kill bloginfo( 'pingback_url' )
 **/
function pmg_kt_kill_pingback_url( $output, $show )
{
	if( $show == 'pingback_url' )
	{
		$output = '';
	}
	return $output;
}

/**
 * remove RSD link
 **/
remove_action( 'wp_head', 'rsd_link' );

/**
 * Disable XMLRPC call
 **/
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