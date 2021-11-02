<?php // 404 Page Not Found
get_template_part( 'partials/header/header' ); ?>

<main id="content" class="wrap">

	<header class="article-header">
		<h1>Page Not Found</h1>
	</header>

	<section class="entry-content">
		<p>The page you were looking for may have moved:</p>
		<?php get_search_form(); ?>
	</section>

	<section class="site-map">
		<h2>All Pages:</h2>
		<ul><?php wp_list_pages('title_li=&depth=5'); ?></ul>
	</section>

</main>

<?php get_template_part( 'partials/footer/footer' );
