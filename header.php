<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title><?php wp_title( '/' ); ?></title>
	
	<?php //get_template_part( 'partials/head', 'favicons' ); // Place a file called favicon.ico in the root directory ?>
    
    <?php wp_head(); ?>

<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/ie.css" type="text/css" media="all" />
	<script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

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
				<svg title="search">
					<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#search"></use>
				</svg>
			</span>
			
			<span id="menu-toggle">
				<svg title="menu">
					<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#menu"></use>
				</svg>
			</span>

			<nav role="navigation">
			<?php wp_nav_menu(array(
				'container' => false,						// remove nav container
				'menu_class' => 'main-nav',					// adding custom nav class
				'theme_location' => 'main-nav',				// where it's located in the theme
				'depth' => 2								// limit the depth of the nav
			)); ?>
			</nav>

		</div>

	</header>
