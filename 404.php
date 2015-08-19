<?php get_header(); ?>

<div id="content">
	
	<div class="wrap">

		<article id="post-not-found" class="hentry">

			<header class="article-header">
				<h1>Page Not Found</h1>
			</header>

			<section class="entry-content">
				<p>The page you were looking for may have moved:</p>
				<p><?php get_search_form(); ?></p>
			</section>

			<section class="site-map">
				<h2>All Pages:</h2>
				<ul><?php wp_list_pages('title_li=&depth=5'); ?></ul>
			</section>

		</article>
		
	</div>
	
</div>

<?php get_footer(); ?>
