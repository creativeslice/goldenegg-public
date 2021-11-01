<?php // Template Name: Has Sidebar
get_template_part( 'partials/header/header' ); ?>

<article id="content" class="wrapper-wide">

	<main class="wp-site-blocks post-content-blocks ">
		<?php the_post(); the_content();
		?>
	</main>

	<?php get_template_part( 'partials/sidebar/sidebar' ); ?>

	<footer class="article-footer">

		<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>

		<span class="post-prev"><?php previous_post_link( '%link', '&lsaquo;&nbsp;Previous' ); ?></span>
		<span class="post-next"><?php next_post_link( '%link', 'Next&nbsp;&rsaquo;' ); ?></span>

	</footer>

</article>

<?php
get_template_part( 'partials/footer/footer' );

