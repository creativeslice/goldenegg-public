<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<div id="main" class="goldlarge" role="main">
			<h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_html(get_search_query()); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class('cf'); ?> role="article">

				<header class="article-header">
					<h3 class="search-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				</header>

				<section class="entry-content">
					<?php the_excerpt( '<span class="read-more">Read more &raquo;</span>' ); ?>
				</section>

			</article>

			<?php endwhile; ?>

				<?php do_action('egg/page_navi'); ?>

			<?php else : ?>

				<?php get_template_part( 'partials/content', 'missing' ); ?>

			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
