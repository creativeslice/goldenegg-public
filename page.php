<?php get_header(); ?>

<main id="content" class="wrap">
	
	<article>

		<header class="articleHeader">
			<h1><?php the_title(); ?></h1>
		</header>
		
		<?php the_post(); $cc = get_the_content(); if($cc != '') : ?>
		<section class="entryContent">
			<?php the_content(); ?>
		</section>
		<?php endif; ?>
	
	</article>

	<?php get_sidebar(); ?>

</main>

<?php egg_component( 'contentBlocks' ); ?>

<?php get_footer();
