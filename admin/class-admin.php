<?php
/**
 * Golden Egg Admin
 *
 * @package   Egg_Admin
 * @author    Jacob Snyder <jake@jcow.com>
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */
add_action( 'admin_init', array('Egg_Admin', 'init') );

class Egg_Admin
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = 'egg_admin';

	/**
	 * Initialize the Class
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function init()
	{
		self::check_dependencies();

		// actions
		add_action( 'admin_menu',                 array(__CLASS__, 'disable_default_dashboard_widgets') );
		add_action( 'admin_head',                 array(__CLASS__, 'admin_favicon'), 11 );
		add_action( 'welcome_panel',              array(__CLASS__, 'dashboard_welcome_cleanup') );
		add_action( 'admin_menu',                 array(__CLASS__, 'remove_menu_pages') );

		// filters
		add_filter( 'admin_footer_text',          array(__CLASS__, 'admin_footer') );
		add_filter( 'screen_options_show_screen', array(__CLASS__, 'remove_screen_options') );
	}

	/**
	 * Check for dependencies
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function check_dependencies()
	{
		if ( ! class_exists( 'acf' ) )
		{
			add_action( 'admin_notices', 'message_dependencies_acf' );
		}
	}

	/**
	 * Add a nag for required dependencies that are missing
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function message_dependencies_acf()
	{
		?>
		<div class="update-nag">
			This theme requires the <a href="http://wordpress.org/plugins/advanced-custom-fields/">Advanced Custom Fields</a> plugin to be installed and activated.
		</div>
		<?php
	}

	/**
	 * Disable default dashboard widgets.
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function disable_default_dashboard_widgets()
	{
		remove_meta_box('dashboard_right_now', 'dashboard', 'core');       // Right Now Widget
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
		remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget
		remove_meta_box('dashboard_quick_press', 'dashboard', 'core');     // Quick Press Widget
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
		remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
		remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

		// removing plugin dashboard boxes
		remove_meta_box('yoast_db_widget', 'dashboard', 'normal');			// Yoast's SEO Plugin Widget
		remove_meta_box('tribe_dashboard_widget', 'dashboard', 'normal');	// Modern Tribe Plugin Widget
		remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');		// Gravity Forms Plugin Widget
		remove_meta_box('bbp-dashboard-right-now', 'dashboard', 'core');	// bbPress Plugin Widget
	}

	/**
	 * Add a developer favicon
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function admin_favicon()
	{
		?>
		<link rel="icon" href="<?php echo get_template_directory_uri() . '/admin/assets/img/favicon.png'; ?>">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/admin/assets/img/favicon.ico'; ?>">
		<![endif]-->
		<?php
	}

	/**
	 * Remove some screen options from the dashboard
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function dashboard_welcome_cleanup()
	{
		#global $pagenow;

		#if ( 'index.php' == $pagenow )
		#{
			?>
			<style type="text/css">
				.welcome-panel-column h4,
				.welcome-panel-last,
				.hide-if-no-customize {display: none !important;}
			</style>
			<?php
		#}
	}

	/**
	 * Add custom dashboard widgets
	 *
	 * @author  Tim Bowen
	 * @since	1.0.0
	 * @return	void
	 */
	public static function admin_footer()
	{
		?>
		<span id="footer-thankyou">Crafted with WordPress by <a href="<?php echo EGG_DEVELOPER_URL; ?>" target="_blank"><?php echo EGG_DEVELOPER; ?></a></span>
		<?php
	}

	/**
	 * Remove screen options from the dashboard
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	bool
	 */
	public static function remove_screen_options()
	{
		global $pagenow;

		if ( 'index.php' == $pagenow ) return false;
		return true;
	}

	/**
	 * Remove some admin pages that we never want
	 *
	 * @author  Tim Bowen
	 * @since	1.0.0
	 * @return	array Modified settings
	 */
	public static function remove_menu_pages()
	{
		remove_menu_page('link-manager.php');
		if (! current_user_can('manage_options') ) remove_menu_page('tools.php');
	}
}