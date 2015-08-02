<?php get_header(); ?>

<div id="content">

	<div class="wrap">

		<?php if ( is_category() ) : ?>
			<h1 class="archive-title">
				<span>Posts Categorized:</span> <?php single_cat_title(); ?>
			</h1>

		<?php elseif ( is_tag() ) : ?>
			<h1 class="archive-title">
				<span>Posts Tagged:</span> <?php single_tag_title(); ?>
			</h1>

		<?php elseif ( is_author() ) :
			global $post;
			$author_id = $post->post_author;
		?>
			<h1 class="archive-title">
				<span>Posts By:</span> <?php the_author_meta('display_name', $author_id); ?>
			</h1>
		<?php elseif ( is_day() ) : ?>
			<h1 class="archive-title">
				<span>Daily Archives:</span> <?php the_time('l, F j, Y'); ?>
			</h1>

		<?php elseif ( is_month() ) : ?>
			<h1 class="archive-title">
				<span>Monthly Archives:</span> <?php the_time('F Y'); ?>
			</h1>

		<?php elseif ( is_year() ) : ?>
			<h1 class="archive-title">
				<span>Yearly Archives:</span> <?php the_time('Y'); ?>
			</h1>
		<?php endif; ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class( 'cf' ); ?>>

			<header class="article-header">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<?php get_template_part( 'partials/content', 'byline' ); ?>
			</header>

			<section class="entry-content">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
				<?php the_excerpt(); ?>
			</section>

		</article>

		<?php endwhile; ?>
			<?php do_action('egg/page_navi'); ?>
		<?php else : ?>
			<?php get_template_part( 'partials/content', 'missing' ); ?>
		<?php endif; ?>

	</div>

</div>

<?php get_footer(); ?>
