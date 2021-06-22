<?php 
/**
 * Favicons
 *
 * Place in root directory: favicon.ico, apple-touch-icon.png
 * https://realfavicongenerator.net/favicon_checker
 *
 * Server Environment Type
 *
 * set in wp-config.php
 * define( 'WP_ENVIRONMENT_TYPE', 'development' );
 *
 */
switch ( wp_get_environment_type() ) {
	
	// Dev
	case 'local': case 'development': ?>
		<link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/partials/favicons/favicon_dev.svg">
	<?php break; 
		
	// Staging
	case 'staging': ?>
		<link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/partials/favicons/favicon_dev.svg">
	<?php break; 
		
	// Production
	case 'production': default: ?>
		<link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/partials/favicons/favicon.svg">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<meta name="theme-color" content="#393">
		
		<meta name="apple-mobile-web-app-title" content="Creative Slice">
		<meta name="author" content="Creative Slice">
		<meta name="revisit-after" content="15 days">
		<meta name="rating" content="general">
		<meta name="distribution" content="global">
	<?php break; 
}
