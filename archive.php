<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

			<?php if (is_category()) { ?>
				<h1 class="archive-title h2">
					<span><?php _e( 'Posts Categorized:', 'bonestheme' ); ?></span> <?php single_cat_title(); ?>
				</h1>

			<?php } elseif (is_tag()) { ?>
				<h1 class="archive-title h2">
					<span><?php _e( 'Posts Tagged:', 'bonestheme' ); ?></span> <?php single_tag_title(); ?>
				</h1>

			<?php } elseif (is_author()) {
				global $post;
				$author_id = $post->post_author;
			?>
				<h1 class="archive-title h2">

					<span><?php _e( 'Posts By:', 'bonestheme' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>

				</h1>
			<?php } elseif (is_day()) { ?>
				<h1 class="archive-title h2">
					<span><?php _e( 'Daily Archives:', 'bonestheme' ); ?></span> <?php the_time('l, F j, Y'); ?>
				</h1>

			<?php } elseif (is_month()) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Monthly Archives:', 'bonestheme' ); ?></span> <?php the_time('F Y'); ?>
					</h1>

			<?php } elseif (is_year()) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Yearly Archives:', 'bonestheme' ); ?></span> <?php the_time('Y'); ?>
					</h1>
			<?php } ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

				<header class="article-header">

					<h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<?php get_template_part( 'partials/content', 'byline' ); ?>

				</header>

				<section class="entry-content cf">

					<?php the_post_thumbnail( 'bones-thumb-300' ); ?>

					<?php the_excerpt(); ?>

				</section>

				<footer class="article-footer">

				</footer>

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
