<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title><?php wp_title( '/' ); ?></title>
    
    <?php wp_head(); ?>
    
    <?php //get_template_part( 'components/favicons/favicons' ); ?>

<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/ie.css" type="text/css" media="all" />
	<script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>

<body <?php body_class(); ?>>
<div id="container">
	
	<?php get_search_form(); // hidden by default ?>
	
	<header class="header">  

		<div class="wrap cf">

			<div id="logo">
				<a href="<?php echo home_url(); ?>" title="Home">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php echo get_option('blogname'); ?>" />
				</a>
			</div>
			
			<span id="searchToggle">
				<svg title="search"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#search"></use></svg>
			</span>
			
			<?php get_template_part( 'components/headerMenu/headerMenu' ); ?>

		</div>

	</header>
