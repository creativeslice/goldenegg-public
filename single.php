<?php get_header(); ?>

<div id="content">

	<div class="wrap-inner">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php /* Use POST FORMATS with this include OR use <article> below
		get_template_part( '/partials/post-formats/format', get_post_format() ); 
		*/ ?>
		
		<article <?php post_class('cf'); ?>>
		
			<header class="article-header">
				<h1 class="entry-title single-title">
					<?php the_title(); ?>
				</h1>
				<?php get_template_part( '/partials/content', 'byline' ); ?>
			</header>
		
			<section class="entry-content cf">
				<?php the_content(); ?>
			</section>
		
			<footer class="article-footer">
				<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>
				<?php get_template_part( 'partials/content', 'share-links' ); ?>
				<span class="post-prev"><?php previous_post_link('%link', '&lsaquo;&nbsp;Previous'); ?></span>
				<span class="post-next"><?php next_post_link('%link', 'Next&nbsp;&rsaquo;'); ?></span>
			</footer>
		
			<?php //comments_template(); ?>
		
		</article>	

		<?php endwhile; else : ?>
			<?php get_template_part( '/partials/content', 'missing' ); ?>
		<?php endif; ?>

	</div>

</div>

<?php get_footer(); ?>
