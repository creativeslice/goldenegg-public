<header class="pageHeader">  

	<div class="wrap cf">

		<a id="logo" href="<?php echo home_url(); ?>" title="Home">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php echo get_option('blogname'); ?>" />
		</a>

		<?php include(locate_template('components/searchToggle/searchToggle.php')); ?>

		<?php include(locate_template('components/headerMenu/headerMenu.php')); ?>

	</div>

</header>
