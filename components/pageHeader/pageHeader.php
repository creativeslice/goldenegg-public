<header class="pageHeader">  

	<div class="wrap cf">

		<a id="logo" href="<?php echo home_url(); ?>" title="Home">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php echo get_option('blogname'); ?>" />
		</a>

		<?php egg_component( 'searchToggle' ); ?>

		<?php egg_component( 'headerMenu' ); ?>

	</div>

</header>
