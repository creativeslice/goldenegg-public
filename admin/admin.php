<?php
/**
 * Make adjustments to the admin
 */

// actions
add_action( 'admin_menu',                 'egg_disable_dashboard_widgets' );
add_action( 'admin_head',                 'egg_admin_favicon', 11 );
add_action( 'welcome_panel',              'egg_dashboard_welcome_cleanup' );
add_action( 'admin_menu',                 'egg_remove_menu_pages' );
add_action( 'wp_before_admin_bar_render', 'egg_customize_admin_bar' );
add_action( 'admin_init',                 'egg_dependencies' );
add_action( 'wp_head', 					  'style_admin_bar' );
add_action( 'wp_before_admin_bar_render', 'custom_adminbar_titles' );
add_action( 'manage_event_posts_custom_column', 'event_table_content', 10, 2 );
add_action( 'pre_get_posts', 			  'my_change_sort_order');

// filters
add_filter( 'show_admin_bar',             'egg_admin_bar_permissions' );
add_filter( 'gettext',                    'egg_replace_howdy', 10, 3 );
add_filter( 'admin_footer_text',          'egg_admin_footer' );
add_filter( 'screen_options_show_screen', 'egg_remove_screen_options' );
add_filter( 'manage_edit-event_columns',  'event_table_head');
add_filter( 'manage_edit-event_sortable_columns', 'sortable_event_table' );
add_filter( 'manage_event_posts_columns', 'columns_filter', 10, 1 );
add_filter( 'wp' , 						  'event_resort');

// Modify the admin bar left label

function custom_adminbar_titles( ) {
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

function style_admin_bar() { // changes admin area left icon to odometer
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
 * Check for dependencies
 */
function egg_dependencies()
{
	if ( ! class_exists( 'acf' ) )
	{
		add_action( 'admin_notices', 'egg_acf_dependency_message' );
	}
}

/**
 * Add a nag for required dependencies that are missing
 */
function egg_acf_dependency_message()
{
	?>
	<div class="update-nag">
		This theme requires the <a href="http://wordpress.org/plugins/advanced-custom-fields/">Advanced Custom Fields</a> plugin to be installed and activated.
	</div>
	<?php
}


/**
 * Disable default dashboard widgets.
 */
function egg_disable_dashboard_widgets()
{

	remove_meta_box('dashboard_right_now', 'dashboard', 'core');    	// Right Now Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core'); 	// Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');			// Plugins Widget
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');		// Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');	// Recent Drafts Widget
	remove_meta_box('dashboard_activity', 'dashboard', 'core');			// Activity Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');			// WordPress News Widget

	// removing plugin dashboard boxes
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');			// Yoast's SEO Plugin Widget
	remove_meta_box('tribe_dashboard_widget', 'dashboard', 'normal');	// Modern Tribe Plugin Widget
	remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');		// Gravity Forms Plugin Widget
	remove_meta_box('bbp-dashboard-right-now', 'dashboard', 'core');	// bbPress Plugin Widget

}

/**
 * Add a developer favicon
 */
function egg_admin_favicon()
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
 */
function egg_dashboard_welcome_cleanup()
{
	global $pagenow;
	if ( 'index.php' == $pagenow )
	{
		?>
		<style type="text/css">
			.welcome-panel-column h4,
			.welcome-panel-last,
			.hide-if-no-customize {display: none !important;}
		</style>
		<?php
	}
}

/**
 * Add Table Head 'Event Date'
 */
function event_table_head( $columns ) {
    $columns['event_date']  = 'Event Date';
    return $columns;
}

/**
 * Remove Publich date from Table 'Events'
 */
function columns_filter( $columns ) {
    unset($columns['date']);
    return $columns;
}

/**
 * Disable sort by Title for 'Event Table'
 */
function sortable_event_table( $columns ) {
    unset($columns['title']);
    return $columns;
}

/**
 * 'Event Date' content set as latest date of multiple dates 
 */
function event_table_content( $column_name, $post_id ) {
    if ($column_name == 'event_date') {
		if( get_field('event_dates', $post_id ) ){
			$count = 0;
			$eventstamps = array();
			while ( $event_date = get_post_meta( $post_id , "event_dates_". $count ."_event_date", true) ){ 
				$eventstamps[] = strtotime( $event_date );
				$count++;
			}
			arsort($eventstamps);
			$date = current ($eventstamps);
			echo date_i18n('M j, Y  g:i a', $date );
			if($count > 1 ){ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  *has multiple dates";	}
		}
	}
}

/**
 * Changes default sort order - same sort is performed again on meta_values to correct for multiple dates - thus this could be removed but is the standard practice so will keep as fall back just in case 
 */
function my_change_sort_order( $query ) {
	if($query->get( 'post_type') == 'event'){
		$query->set('orderby', 'meta_value');
		$query->set('order', 'desc');
		$query->set('meta_key', 'event_dates_%_event_date');
		return $query;
	}
}

/**
 * 'Event_Resort()' loops through the event posts for the event admin table and corrects for multiple dates: the latest event date is used and the array is resorted latest on top.
 */
function event_resort( $post ){
	global $wp_query;
	if( is_admin() && $wp_query->get( 'post_type') == 'event'){
		$new_posts = array();
		foreach($wp_query->posts as $key =>	 $post){
			if( get_field('event_dates', $post->ID ) ){
				$count = 0;
				$eventstamps = array();
				while ( $event_date = get_post_meta( $post->ID , "event_dates_". $count ."_event_date", true) ){ 
					$eventstamps[] = strtotime( $event_date );
					$count++;
				}
				arsort($eventstamps);
				$date = current ($eventstamps);
				$new_posts[$date] = $post;
			}
		}
		krsort($new_posts);
		unset($wp_query->posts);
		foreach($new_posts as $post){
			$wp_query->posts[] = $post;			
		}
	}
}

/**
 * Remove some admin pages that we never want
 */
function egg_remove_menu_pages()
{
	remove_menu_page('link-manager.php');
	if (! current_user_can('manage_options') ) remove_menu_page('tools.php');
}

/**
 * Remove top admin menu items
 *
 * @return	void
 */
function egg_customize_admin_bar()
{
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
	if(!is_admin()){ 
		$wp_admin_bar->remove_menu('my-account'); // removes my account bar from top right
	}
}

/**
 * Force the admin bar on for editors and admins and off for below
 *
 * @return	array Modified settings
 */
function egg_admin_bar_permissions( $content )
{
	return ( current_user_can('edit_others_posts') ) ? true : false;
}

/**
 * Replace howdy in the admin bar
 *
 * @return	string Modified welcome message.
 */
function egg_replace_howdy( $translated, $text, $domain )
{
	if ( false !== strpos($translated, "Howdy") )
	{
		return str_replace("Howdy", "Welcome back", $translated);
	}
	return $translated;
}

/**
 * Customize admin footer
 */
function egg_admin_footer()
{
	?>
	<span id="footer-thankyou">Crafted with WordPress by <a href="<?php echo EGG_DEVELOPER_URL; ?>" target="_blank"><?php echo EGG_DEVELOPER; ?></a></span>
	<?php
}

/**
 * Remove screen options from the dashboard
 */
function egg_remove_screen_options()
{
	global $pagenow;

	if ( 'index.php' == $pagenow ) return false;
	return true;
}
