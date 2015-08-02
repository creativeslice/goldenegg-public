<?php get_header(); // Template Name: Home ?>

<div id="content">

	<div class="wrap">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class( 'cf' ); ?>>

			<header class="article-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>

			<section class="entry-content">
				<?php the_content(); ?>
			</section>

		</article>

		<?php endwhile; endif; ?>

	</div>

</div>

<?php get_footer(); ?>
