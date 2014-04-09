<!doctype html>

<!--[if lt IE 7]><html lang="en-US" class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html lang="en-US" class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html lang="en-US" class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-US" class="no-js"><!--<![endif]-->

<head>
	<title><?php wp_title(''); ?></title>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<![endif]-->
	<meta name="msapplication-TileColor" content="#e7c12a">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/mstile-310x310.png">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="container">

		<header class="header" role="banner">

			<div id="inner-header" class="wrap cf">

				<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p>

				<nav role="navigation">
					<?php wp_nav_menu(array(
					'container' => false,                           // remove nav container
					'container_class' => 'menu cf',                 // class of container
					'menu' => 'The Main Menu',  					// nav name
					'menu_class' => 'nav top-nav cf',               // adding custom nav class
					'theme_location' => 'main-nav',                 // where it's located in the theme
					'before' => '',                                 // before the menu
					'after' => '',                                  // after the menu
					'link_before' => '',                            // before each link
					'link_after' => '',                             // after each link
					'depth' => 0                              		// limit the depth of the nav
					)); ?>

				</nav>

			</div>

		</header>
