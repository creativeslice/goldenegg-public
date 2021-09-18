<?php get_template_part('partials/header/header'); ?>

<main id="content">
	<article class="gutenbergBlocks">
		<?php the_post(); the_content(); ?>
	</article>
</main>

<?php get_template_part('partials/footer/footer');
