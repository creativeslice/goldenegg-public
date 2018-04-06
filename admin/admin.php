<?php
/**
 * Make adjustments to the admin
 */


/**
 * Disable the auto generated email sent to the admin after a successful core update:
 */
add_filter( 'auto_core_update_send_email', 'egg_bypass_auto_update_email', 10, 4 );
function egg_bypass_auto_update_email( $send, $type, $core_update, $result ) {
    if ( ! empty( $type ) && $type == 'success' ) {
        return false;
    }
    return true;
}


/**
 * Modify the admin bar left label
 */
add_action( 'wp_before_admin_bar_render', 'egg_adminbar_titles' );
function egg_adminbar_titles( ) {
	if(is_admin()){ 
		$title = "Home";
	}
	else{
		$title = "Admin Area";
	}
    global $wp_admin_bar;
    $wp_admin_bar->add_menu( array(
            'id'    => 'site-name',
            'title' => $title,
        )
    );
}


/**
 * Change admin area left icon to odometer
 */
add_action( 'wp_head', 'egg_style_admin_bar' );
function egg_style_admin_bar() {
	if ( is_user_logged_in() ){
	    echo "<style type='text/css'>
	    #wpadminbar #wp-admin-bar-site-name>.ab-item:before {
			content: '\\f226';
			top: 2px;
		}
		</style>";
	}
}


/**
 * Remove Help Tab
 */
add_action('admin_head', 'egg_remove_help_tabs');
function egg_remove_help_tabs() {
	$screen = get_current_screen();
	$screen->remove_help_tabs();
}


/**
 * Disable default dashboard widgets.
 */
add_action( 'admin_menu', 'egg_disable_dashboard_widgets' );
function egg_disable_dashboard_widgets() {
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');    	// Right Now Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core'); 	// Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');			// Plugins Widget
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');		// Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');	// Recent Drafts Widget
	remove_meta_box('dashboard_activity', 'dashboard', 'core');			// Activity Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');			// WordPress News Widget

	// remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');	// Gravity Forms Plugin Widget
	remove_meta_box('wpe_dify_news_feed', 'dashboard', 'normal');		// WPEngine News Widget
}


/**
 * Add a developer favicon to admin area
 */
add_action( 'admin_head', 'egg_admin_favicon', 11 );
function egg_admin_favicon() { ?>
	<link rel="icon" href="<?php echo get_template_directory_uri() . '/admin/assets/img/favicon.png'; ?>">
<?php }


/**
 * Remove some screen options from the dashboard
 */
add_action( 'welcome_panel', 'egg_dashboard_welcome_cleanup' );
function egg_dashboard_welcome_cleanup() {
	global $pagenow;
	if ( 'index.php' == $pagenow ) { ?>
		<style type="text/css">
			.welcome-panel-column h4,
			.welcome-panel-last,
			.hide-if-no-customize {display: none !important;}
		</style>
		<?php
	}
}


/**
 * Remove some admin pages like links
 */
add_action( 'admin_menu', 'egg_remove_menu_pages' );
function egg_remove_menu_pages() {
	remove_menu_page('link-manager.php');
	if (! current_user_can('manage_options') ) remove_menu_page('tools.php');
}


/**
 * Remove top admin menu items
 */
add_action( 'wp_before_admin_bar_render', 'egg_customize_admin_bar' );
function egg_customize_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('search');
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('view-site');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('new-link');
	$wp_admin_bar->remove_menu('new-media');
	$wp_admin_bar->remove_menu('new-user');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('customize-themes');
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('widgets');
    //$wp_admin_bar->remove_menu('menus');
    /*
	// removes top right account info. ERRORS if jQuery in footer
	if(!is_admin()){
		$wp_admin_bar->remove_menu('my-account'); 
	}
	*/
}


/**
 * Replace howdy in the admin bar
 *
 * @return	string Modified welcome message.
 */
add_filter( 'gettext', 'egg_replace_howdy', 10, 3 );
function egg_replace_howdy( $translated, $text, $domain ) {
	if ( false !== strpos($translated, "Howdy") ) {
		return str_replace("Howdy", "Welcome back", $translated);
	}
	return $translated;
}


/**
 * Customize admin footer
 */
add_filter( 'admin_footer_text', 'egg_admin_footer' );
function egg_admin_footer() { ?>
	<span id="footer-thankyou">Built by <a href="https://creativeslice.com" target="_blank">Creative Slice</a></span>
<?php }
