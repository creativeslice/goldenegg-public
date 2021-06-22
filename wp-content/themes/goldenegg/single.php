<?php get_header(); // Template Name: Has Sidebar ?>

<article id="content" class="wrapperWide">
	
	<main class="postContentBlocks gutenbergBlocks">
		<?php the_post(); the_content(); ?>
    </main>
    
    <?php get_sidebar(); ?>
    
    <footer class="articleFooter">

		<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>
		
		<?php // Social Share Links
			get_template_part( 'partials/share-links/share-links' ); 
		?>

		<span class="postPrev"><?php previous_post_link('%link', '&lsaquo;&nbsp;Previous'); ?></span>
		<span class="postNext"><?php next_post_link('%link', 'Next&nbsp;&rsaquo;'); ?></span>

	</footer>

</article>

<?php get_footer();
	