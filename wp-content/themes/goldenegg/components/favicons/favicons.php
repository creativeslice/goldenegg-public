<?php
/**
 * Favicons
 *
 * https://www.favicon-generator.org/
 * https://favicon.io/
 * https://realfavicongenerator.net/favicon_checker
 *
 * place in root directory: favicon.ico, apple-touch-icon.png
 *
 */
?>

<?php 
/**
 * Server Environment Type
 *
 * set in wp-config.php
 * define( 'WP_ENVIRONMENT_TYPE', 'development' );
 */
switch ( wp_get_environment_type() ) {
	
	// Dev
	case 'local': case 'development': ?>
		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/components/favicons/icon-evergreen.png">
	<?php break; 
		
	// Staging
	case 'staging': ?>
		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/components/favicons/icon-vividblue.png">
	<?php break; 
		
	// Production
	case 'production': default: ?>
		<link rel="manifest" crossorigin="use-credentials" href="<?php echo get_template_directory_uri(); ?>/components/favicons/manifest.webmanifest" >
		<link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/components/favicons/favicon.svg">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<meta name="theme-color" content="#339933">
		
		<meta name="apple-mobile-web-app-title" content="Creative Slice">
		<meta name="author" content="Creative Slice">
		<meta name="revisit-after" content="15 days">
		<meta name="rating" content="general">
		<meta name="distribution" content="global">
	<?php break; 
}
