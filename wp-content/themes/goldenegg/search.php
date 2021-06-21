<?php get_header(); // Search Results ?>

<div id="content" class="wrap">
	
	<h1 class="archiveTitle"><span>Search Results for:</span> <?php echo get_search_query(); ?></h1>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php // PAGE
		if( 'page' == get_post_type() ):?>
		<article <?php post_class('cf'); ?>>
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
		</article>
		
		<?php // POST
		elseif( 'post' == get_post_type() ): ?>
		<article <?php post_class('cf'); ?>>
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<span class="byline">Posted <?php the_time('F j, Y'); ?></span>
			<?php the_excerpt(); ?>
		</article>
	
		<?php // CPT
		else : ?>
		<article <?php post_class('cf'); ?>>
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
		</article>
		
		<?php endif; ?>

	<?php endwhile;
		get_template_part( 'partials/archive-nav/archive-nav' );
	else : 
		echo '<h1>Nothing Found Here</h1>';
	endif; ?>

</div>

<?php get_footer();
