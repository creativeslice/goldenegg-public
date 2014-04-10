<?php get_header(); // Template Name: Custom Template ?>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?>>

				<header class="article-header">

					<h1 class="page-title"><?php the_title(); ?></h1>

				</header>

				<section class="entry-content cf" itemprop="articleBody">
					
					<?php the_content(); ?>

				</section>


				<footer class="article-footer">

				</footer>

			</article>

			<?php endwhile; else : ?>

				<?php get_template_part( 'partials/content', 'missing' ); ?>

			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
