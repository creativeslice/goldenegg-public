<?php get_header(); ?>

<div class="wrap">
	
	<h1 class="archiveTitle"><span>Search Results for:</span> <?php echo get_search_query(); ?></h1>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php if( 'page' == get_post_type() ): // this is a page ?>
		<article <?php post_class('cf'); ?>>
			<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
			<?php the_excerpt(); ?>
		</article>
		
		<?php elseif( 'post' == get_post_type() ): // this is a post ?>
		<article <?php post_class('cf'); ?>>
			<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
			<span class="byline">Posted <?php the_time('F j, Y'); ?></span>
			<?php the_excerpt(); ?>
		</article>
	
		<?php else : // this is another post type ?>
		<article <?php post_class('cf'); ?>>
			<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
			<?php the_excerpt(); ?>
		</article>
		
		<?php endif; ?>

	<?php endwhile; locate_template('components/pageNavi/pageNavi.php'); 
	else : echo '<h1>Nothing Found Here</h1>';
	endif; ?>

</div>

<?php get_footer();