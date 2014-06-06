<?php
/**
 * Golden Egg Disable Comments in the Admin
 */

// actions
add_action( 'wp_before_admin_bar_render',         'egg_remove_comments_admin_bar' );
add_action( 'admin_menu',                         'egg_remove_comments_admin_menu', 999 );
add_action( 'admin_head-edit.php',                'egg_remove_comments_quick_edit' );
add_action( 'admin_menu',                         'egg_remove_comments_metaboxes' );

// filters
add_filter( 'manage_edit-page_columns',           'egg_remove_comments_list_columns', 10, 1 );	
add_filter( 'manage_edit-post_columns',           'egg_remove_comments_list_columns', 10, 1 );
add_filter( 'manage_media_columns',               'egg_remove_comments_list_columns', 10, 1 );	
#add_filter( 'manage_edit-CUSTOMPOSTTYPE_columns', 'egg_remove_comments_list_columns', 10, 1 );

/**
 * Remove from wpadmin menu (TOP BAR)
 */
function egg_remove_admin_bar_comments()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}

/**
 * Remove from admin menu (LEFT SIDEBAR)
 */
function egg_remove_comments_admin_menu()
{	
	remove_menu_page('edit-comments.php');
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
}

/**
 * Remove ping option and comments option from Quick Edit
 */
function egg_remove_comments_quick_edit() 
{    
	global $current_screen;
	if ( 'edit-post' != $current_screen->id && 'edit-page' != $current_screen->id )
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
 */
function remove_my_comment_metaboxes()
{
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core');	// Comments Widget
	remove_meta_box( 'commentstatusdiv','post','normal' );              // Comments Status Metabox
	remove_meta_box( 'commentsdiv','post','normal' );                   // Comments Metabox
	remove_meta_box( 'commentstatusdiv','page','normal' );              // Comments Metabox
	remove_meta_box( 'commentsdiv','page','normal' );                   // Comments Metabox
}

/**
 * Remove Comments Column from lists-table
 */
function egg_remove_comments_list_columns( $columns )
{
	unset($columns['comments']);
	return $columns;
}