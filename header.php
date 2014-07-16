<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<title><?php wp_title(''); ?></title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/apple-touch-icon.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png">
	<!--[if IE]><link rel="shortcut icon" href="<?php echo bloginfo('template_directory'); ?>/assets/img/favicon.ico"><![endif]-->
	<meta name="msapplication-TileColor" content="#e7c12a">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/img/mstile-310x310.png">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="container">

		<header class="header" role="banner" id='headroom'>  

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
					'container_class' => 'menu',				// class of container
					'menu' => 'The Main Menu',					// nav name
					'menu_id' => 'top-nav',				        // adding custom nav id
					'menu_class' => 'nav top-nav',				// adding custom nav class
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
