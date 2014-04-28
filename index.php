<?php get_header(); ?>

<div id="content" class="wrap">

	<div id="inner-content" class="cf">

		<div id="main" class="goldlarge" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class( 'cf' ); ?> role="article">

				<header class="article-header">

					<h1 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					<?php get_template_part( 'includes/content', 'byline' ); ?>
					</p>

				</header>

				<section class="entry-content cf">
					<?php the_content(); ?>
				</section>

				<footer class="article-footer cf">
					<p class="footer-comment-count">
						<?php comments_number( __( '<span>No</span> Comments', 'bonestheme' ), __( '<span>One</span> Comment', 'bonestheme' ), _n( '<span>%</span> Comments', '<span>%</span> Comments', get_comments_number(), 'bonestheme' ) );?>
					</p>


 	<?php printf( __( '<p class="footer-category">Filed under: %1$s</p>', 'bonestheme' ), get_the_category_list(', ') ); ?>

  <?php the_tags( '<p class="footer-tags tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>


				</footer>

			</article>

			<?php endwhile; ?>

					<?php bones_page_navi(); ?>

			<?php else : ?>

				<?php get_template_part( 'includes/content', 'missing' ); ?>

			<?php endif; ?>


		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
