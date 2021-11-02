<?php
/**
 * Admin: WordPress Dashboard
 * 
 * Author: Creative Slice
 * URI: https://github.com/creativeslice/goldenegg
 * Version: 1.0
*/


/**
 * Remove some admin pages like links
 */
function egg_remove_menu_pages() {
	remove_menu_page('link-manager.php');
	remove_submenu_page( 'tools.php', 'site-health.php' );
	if (! current_user_can('manage_options') ) remove_menu_page('tools.php');
	
	// Hide CPT UI plugin menu
	//remove_menu_page('cptui_main_menu');
	
	//echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
}
//add_action( 'admin_menu', 'egg_remove_menu_pages', 999 );



/**
 * Customize admin footer
 */
function egg_admin_footer() { ?>
	<span id="footer-thankyou">Built by Creative Slice with WordPress <?php echo get_bloginfo( 'version' ); ?></span>
<?php }
add_filter( 'admin_footer_text', 'egg_admin_footer' );

