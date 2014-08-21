<?php get_header(); // Template Name: Calendar ?>


<div id="content">

	<div class="wrap">

		<div id="main" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class( 'cf' ); ?>>

				<header class="article-header">
					<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
				</header>

				<section class="entry-content" itemprop="articleBody">
					<?php the_content(); ?>
				</section>

			</article>

			<?php endwhile; endif; ?>

		</div>

	</div>
	
	<!-- custom field for navigation intercept -->
	<?php if(get_field('popup_message')) : ?>
	<div style='display:none' id='popup_message'>
		<?php  echo get_field('popup_message'); ?>
	</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
