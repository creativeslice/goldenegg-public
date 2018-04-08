<?php get_header(); ?>

<div id="content" class="cf">

	<div class="wrap">
		
		<article>

			<header class="articleHeader">
				<h1><?php the_title(); ?></h1>
			</header>

			<section class="entryContent">
				<?php the_post(); the_content(); ?>
			</section>
		
		</article>

		<?php //get_sidebar(); ?>

	</div>
	
	<?php //include(locate_template('includes/acfContentBlocks.php')); ?>

</div>

<?php get_footer(); ?>
