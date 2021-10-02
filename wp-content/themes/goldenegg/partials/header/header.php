<!doctype html>
<html dir="ltr" lang="en-US">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php /* Preload Fonts
		<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/FontName.woff2" as="font" type="font/woff2" crossorigin>
	*/ ?>

	<?php wp_head(); ?>

	<?php get_template_part( 'partials/favicons/favicons' ); ?>

	<?php // Server Environment Type
	switch ( wp_get_environment_type() ) {
		case 'local': case 'development': case 'staging': break;
		case 'production': default: ?>
		<!-- Google Tag Manager -->
	<?php break; } ?>

</head>

<body <?php body_class(); ?>>


<div id="container"><?php // #container is closed in footer.php ?>

	<a class="screen-reader-text" href="#content">Skip to Content</a>

	<?php // ACF Alert Bar Notices
		//get_template_part( 'partials/notices/notices' );
	?>

	<?php // Search Form
		get_template_part( 'partials/search/search-form' );
	?>

	<header class="page-header">

		<div class="wrap">

			<a id="logo" href="<?php echo home_url(); ?>" title="Home">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php echo get_option('blogname'); ?>" />
			</a>

			<?php // Header Menu Navigation
				get_template_part( 'partials/main-nav/main-nav' );
			?>

		</div>

	</header>
