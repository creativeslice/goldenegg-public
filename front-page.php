<?php get_header(); // Template Name: Home ?>

<div id="content">

	<article class="wrap">

		<header class="articleHeader">
			<h1><?php the_title(); ?></h1>
		</header>

		<section class="entryContent">
			<?php the_post(); the_content(); ?>
		</section>

	</article>

</div>

<?php get_footer(); ?>
