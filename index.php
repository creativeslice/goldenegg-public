<?php get_header(); ?>

<div id="content" class="wrap">

	<div id="inner-content">

		<div id="main" class="goldlarge" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class( 'cf' ); ?> role="article">

				<header class="article-header">

					<h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					<?php get_template_part( 'partials/content', 'byline' ); ?>

				</header>

				<section class="entry-content">
				
					<?php the_content(); ?>
					
				</section>

			</article>

			<?php endwhile; ?>
				
				<?php bones_page_navi(); ?>
			
			<?php else : ?>
				
				<?php get_template_part( 'partials/content', 'missing' ); ?>
			
			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
