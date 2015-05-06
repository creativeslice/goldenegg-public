<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title( '/' ); ?></title>
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<link rel="apple-touch-icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/apple-touch-icon.png">
	<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon.ico">
	<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon.png">
	
	<!--[if lt IE 9]>
	    <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="container">

		<header class="header" role="banner" >  

			<div id="inner-header" class="wrap cf">

				<div id="logo"><a href="<?php echo home_url(); ?>" title="Home">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php echo get_option('blogname'); ?>" />
				</a></div>

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
