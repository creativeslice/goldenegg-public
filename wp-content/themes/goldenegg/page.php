<?php get_header(); ?>

<main id="content">
	<article class="gutenbergBlocks">
		<?php the_post(); the_content(); ?>
	</article>
</main>

<?php get_footer();
