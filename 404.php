<?php get_header(); ?>

<main id="content" class="wrap">

	<header class="articleHeader">
		<h1>Page Not Found</h1>
	</header>

	<section class="entryContent">
		<p>The page you were looking for may have moved:</p>
		<p><?php get_search_form(); ?></p>
	</section>

	<section class="siteMap">
		<h2>All Pages:</h2>
		<ul><?php wp_list_pages('title_li=&depth=5'); ?></ul>
	</section>

</main>

<?php get_footer();