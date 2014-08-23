<?php get_header(); ?>

<div id="content">

	<div class="wrap">

		<div id="main" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part( '/partials/post-formats/format', get_post_format() ); ?>

			<?php endwhile; else : ?>
				<?php get_template_part( '/partials/content', 'missing' ); ?>
			<?php endif; ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
