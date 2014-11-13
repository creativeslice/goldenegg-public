<?php
/**
 * Example dashboard widget for admin
 */
 
add_action( 'wp_dashboard_setup', 'custom_dashboard_widgets' );

function custom_dashboard_widgets() {
	wp_add_dashboard_widget( 'instructions_dashboard_widget', 'Website Instructions', 'instructions_dashboard_widget' );
}

/**
 * Create a basic instructions area on the Dashboard
 */
function instructions_dashboard_widget() { ?>

<h2>Use the menus on the left to add and edit website content</h2>
<h1><a class="button" href="<?php echo admin_url( 'post.php?post=5&action=edit' ); ?>">Edit Home Page</a></h1>
<p>If you need help, please read the instructions below.</p>
<!-- <a class="button" href="<?php bloginfo('stylesheet_directory'); ?>/Website_Instructions.pdf" target="_blank">Website Instructions</a> -->

<?php } ?>