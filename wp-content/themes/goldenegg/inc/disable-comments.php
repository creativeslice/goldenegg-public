<?php
/**
 * Admin: Disable Comments
 * 
 * Author: Creative Slice
 * URI: https://github.com/creativeslice/goldenegg
 * Version: 1.0
*/




/*************** NEEDS REFINEMENT FOR GUTENBERG ***************/




 
/**
 * Remove Comments from wpadmin menu (TOP BAR)
 */
function egg_remove_comments_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'egg_remove_comments_admin_bar' );


/**
 * Remove Comments from admin menu (LEFT SIDEBAR)
 */
function egg_remove_comments_admin_menu() {	
	remove_menu_page('edit-comments.php');
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
}
add_action( 'admin_menu', 'egg_remove_comments_admin_menu', 999 );


/**
 * Remove Comments from admin menu (LEFT SIDEBAR)
 *
ISSUE. This doesn't seem to work for Gutenberg
 */
function egg_comments_init() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
add_action( 'init', 'egg_comments_init' );

