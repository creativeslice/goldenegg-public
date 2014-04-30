<?php


/* Custom TinyMCE styling
-------------------------------------------------------------------------------------- */
 
// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter('mce_buttons_2', 'my_mce_buttons_2');
 
// Remove from first row
function remove_tinymce_buttons1($buttons) {
	$remove = array('strikethrough', 'wp_more');
	return array_diff($buttons,$remove);
}
add_filter('mce_buttons','remove_tinymce_buttons1');
 
// Remove from second row
function remove_tinymce_buttons2($buttons) {
	$remove = array('styleselect', 'underline', 'forecolor', 'alignjustify', 'pastetext', 'removeformat', 'wp_help');
	return array_diff($buttons,$remove);
}
add_filter('mce_buttons_2','remove_tinymce_buttons2');
 
// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['block_formats'] = "Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5";
	return $init_array;
}
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );



/* Remove top admin menu items (WordPress icon)
-------------------------------------------------------------------------------------- */
function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
    $wp_admin_bar->remove_menu('new-content');		// Remove ALL New links from header menu
    $wp_admin_bar->remove_menu('new-link');			// Remove New Link link from header menu
    $wp_admin_bar->remove_menu('new-media');		// Remove New Media link from header menu
    $wp_admin_bar->remove_menu('new-user');			// Remove New User link from header menu
    $wp_admin_bar->remove_menu('comments');			// Remove Comments header menu
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );


/************* REMOVING DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');    	// Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');	// Comments Widget
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
}

// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');


/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it
function bones_login_css() {
	wp_enqueue_style( 'bones_login_css', get_template_directory_uri() . '/assets/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function bones_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function bones_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'bones_login_css', 10 );
add_filter( 'login_headerurl', 'bones_login_url' );
add_filter( 'login_headertitle', 'bones_login_title' );


/************* CUSTOMIZE ADMIN FOOTER *******************/

// Custom Backend Footer
function bones_custom_admin_footer() {
	echo '<span id="footer-thankyou">Crafted by Creative Slice | Built on WordPress.</span>';
}

// adding it to the admin area
add_filter('admin_footer_text', 'bones_custom_admin_footer');

?>