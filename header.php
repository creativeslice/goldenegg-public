<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title><?php wp_title( '/' ); ?></title>
	
	<!-- Place a file called favicon.ico in the root directory -->
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon-16.png" sizes="16x16" type="image/png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon-32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon-48.png" sizes="48x48" type="image/png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon-62.png" sizes="62x62" type="image/png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon-192.png" sizes="192x192" type="image/png">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/apple-touch-icon.png">
    
    <?php wp_head(); ?>

<!--[if lt IE 9]>
	<link rel="stylesheet" id="egg-ie-only-css" href="<?php echo get_template_directory_uri(); ?>/assets/css/ie.css" type="text/css" media="all" />
	<script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php // Include partials/analytics-tracking.php if WP_DEBUG is NOT true in wp-config
if ( ! defined('WP_DEBUG') || false === WP_DEBUG ) {
	get_template_part( 'partials/analytics', 'tracking' );
} ?>

</head>

<body <?php body_class(); ?>>
<div id="container">
	
	<?php get_search_form(); // hidden by default ?>
	
	<header class="header">  

		<div id="inner-header" class="wrap cf">

			<div id="logo">
				<a href="<?php echo home_url(); ?>" title="Home">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php echo get_option('blogname'); ?>" />
				</a>
			</div>
			
			<span id="search-toggle">
				<span class="icon-search" aria-hidden="true"></span>
				<span class="screen-reader-text">SEARCH</span>
			</span>
			
			<span id="mobilemenu">
				<span class="icon-menu" aria-hidden="true"></span>
				<span class="screen-reader-text">MENU</span>
			</span>

			<nav role="navigation">
			<?php wp_nav_menu(array(
				'container' => false,						// remove nav container
				'menu' => 'The Main Menu',					// nav name
				'menu_id' => 'main-menu',					// adding custom nav id
				'menu_class' => 'main-nav',					// adding custom nav class
				'theme_location' => 'main-nav',				// where it's located in the theme
				'before' => '',								// before the menu
				'after' => '',								// after the menu
				'link_before' => '',						// before each link
				'link_after' => '',							// after each link
				'depth' => 2								// limit the depth of the nav
			)); ?>
			</nav>

		</div>

	</header>
