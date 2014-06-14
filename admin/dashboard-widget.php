<?php
/**
 * Example dashboard widget for admin
 */
add_action( 'wp_dashboard_setup', 'custom_dashboar_widgets' );
function custom_dashboar_widgets()
{
	wp_add_dashboard_widget( 'instructions_dashboard_widget', 'Website Instructions', array(__CLASS__, 'instructions_dashboard_widget') );
}

/**
 * Create a basic instructions area on the Dashboard
 */
function instructions_dashboard_widget()
{
	?>
	<h2><?php echo apply_filters( self::PREFIX . '/dashboard_instructions/title', __("Use the menus on the left to add and edit website content.") ); ?></h2>
	<h1><a class="button" href="<?php echo admin_url( 'admin.php?page=acf-options' ); ?>"><?php _e("Update your organization options"); ?></a></h1>
	<h1><a class="button" href="<?php echo admin_url( 'edit.php?post_type=acf' ); ?>"><?php _e("Customize site forms"); ?></a></h1>
	<?php /** /<p><?php echo apply_filters( self::PREFIX . '/dashboard_instructions/content', __("If you need help, please read the instructions below.") ); ?></p>
	<?php /** /<h1><a class="button" href="<?php bloginfo('stylesheet_directory'); ?>/Website_Instructions.pdf" target="_blank">Website Instructions</a></h1>
	/**/
}