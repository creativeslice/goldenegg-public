<?php // Default page template
get_template_part( 'partials/header/header' ); ?>

<main id="content" class="wp-site-blocks">

	<!-- wp:separator -->
	<hr class="wp-block-separator alignwide"/>
	<!-- /wp:separator -->

	<?php // Gutenberg blocks
		the_post(); the_content();
	?>
	
</main>

<?php
get_template_part( 'partials/footer/footer' );
