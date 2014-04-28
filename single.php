<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<div id="main" class="goldlarge" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'post-formats/format', get_post_format() ); ?>

			<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'includes/content', 'missing' ); ?>

			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
