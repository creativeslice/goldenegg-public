<?php // CLEANUP WP ADMIN


/**
 * Customize the login screen
 */
add_action( 'login_init', 'egg_login_init' );
function egg_login_init() {
	add_action( 'login_enqueue_scripts', 'egg_login_css' );
	add_filter( 'login_headerurl',		'egg_login_url' );
	add_filter( 'login_headertext',		'egg_login_title' );
}

// Add theme login CSS
function egg_login_css() {
	wp_enqueue_style( 'egg_admin_login', get_template_directory_uri() . '/assets/css/login.css', false );
}

// Change logo link to site home
function egg_login_url() {
	return home_url( '/' );
}

// Change the alt text on the logo to site name
function egg_login_title() {
	return get_option('blogname');
}


/**
 * Turn OFF Theme Editor - PAGELY already does this
 */
#define( 'DISALLOW_FILE_EDIT', true );


/**
 * Turn off Autosave
 */
//add_action( 'admin_init', 'disable_autosave' );
function disable_autosave() {
	wp_deregister_script( 'autosave' );
}


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
	if(is_admin()) { 
		$title = "Home";
	} else {
		$title = "Dashboard";
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
	if ( is_user_logged_in() ) {
	    echo "<style type='text/css'>#wpadminbar #wp-admin-bar-site-name>.ab-item:before {content: '\\f226';}</style>";
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
	remove_meta_box('dashboard_site_health', 'dashboard', 'normal');	// Site Health Widget
	// remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');	// Gravity Forms Widget
	//remove_meta_box('wpe_dify_news_feed', 'dashboard', 'normal');		// WPEngine News Widget
}
	

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
			.hide-if-no-customize {
				display: none !important;
			}
		</style>
		<?php
	}
}

/**
 * Filter the show welcome panel meta data to always be false.
 */
add_filter( 'get_user_metadata', 'egg_hide_welcome_panel', 10, 3 );
function egg_hide_welcome_panel( $value, int $user_id, string $meta_key ) {
	if ( $meta_key !== 'show_welcome_panel' ) {
		return $value;
	}
	return [0];
}


/**
 * Remove some admin pages like links
 */
add_action( 'admin_menu', 'egg_remove_menu_pages' );
function egg_remove_menu_pages() {
	remove_menu_page('link-manager.php');
	remove_submenu_page( 'tools.php', 'site-health.php' );
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
}


/**
 * Replace howdy in the admin bar
 */
add_filter( 'gettext', 'egg_replace_howdy', 10, 3 );
function egg_replace_howdy( $translated, $text, $domain ) {
	if ( false !== strpos($translated, "Howdy") ) {
		return str_replace("Howdy", "Welcome", $translated);
	}
	return $translated;
}


/**
 * Customize admin footer
 */
add_filter( 'admin_footer_text', 'egg_admin_footer' );
function egg_admin_footer() { ?>
	<span id="footer-thankyou">Built by Creative Slice with WordPress <?php echo get_bloginfo( 'version' ); ?></span>
<?php }
