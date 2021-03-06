<?php get_header(); ?>

<main id="content">
	
	<header class="articleHeader wrap">
		<h1><?php the_title(); ?></h1>
	</header>
	
	<article class="gutenbergBlocks">
		<?php the_post(); the_content(); ?>
	</article>

</main>

<?php // Content Blocks
	get_template_part( 'includes/contentBlocks' ); 
?>

<?php get_footer();
