<?php
/**
 * Admin: WordPress Dashboard
 * 
 * Author: Creative Slice
 * URI: https://github.com/creativeslice/goldenegg
 * Version: 1.0.1
*/


/**
 * Disable default dashboard widgets.
 */
function egg_disable_dashboard_widgets() {
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');    	// Right Now Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core'); 	// Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');			// Plugins Widget
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');		// Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');	// Recent Drafts Widget
	remove_meta_box('dashboard_activity', 'dashboard', 'core');			// Activity Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');			// WordPress News Widget
	remove_meta_box('dashboard_site_health', 'dashboard', 'normal');	// Site Health Widget
	
	// Plugins
	#remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');	// Gravity Forms Widget
}
add_action( 'admin_menu', 'egg_disable_dashboard_widgets' );


/**
 * Remove Help Tab
 */
function egg_remove_help_tabs() {
	$screen = get_current_screen();
	$screen->remove_help_tabs();
}
add_action('admin_head', 'egg_remove_help_tabs');


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
