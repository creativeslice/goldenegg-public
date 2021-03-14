<?php get_header(); ?>

<article id="content">

	<header class="articleHeader">
		<h1><?php the_title(); ?></h1>
		<p class="byline"><?php the_time('F j, Y'); ?> <?php the_category(', '); ?></p>
	</header>

	<section class="entryContent cf">
		<?php the_post(); the_content(); ?>
	</section>

	<footer class="articleFooter">

		<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>

		<span class="postPrev"><?php previous_post_link('%link', '&lsaquo;&nbsp;Previous'); ?></span>
		<span class="postNext"><?php next_post_link('%link', 'Next&nbsp;&rsaquo;'); ?></span>

	</footer>

</article>

<?php get_footer();
