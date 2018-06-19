<?php get_header(); // Template Name: Home ?>

<div id="content">

	<article class="wrap">

		<header class="articleHeader">
			<h1><?php the_title(); ?></h1>
		</header>

		<section class="entryContent">
			<?php the_post(); the_content(); ?>
			
			<figure class="lazy70">
				<img
					data-sizes="100vw"
					data-src="<?php echo get_template_directory_uri(); ?>/assets/img/img_600x400.jpg"
					data-srcset="<?php echo get_template_directory_uri(); ?>/assets/img/img_1000x700.jpg 1000w,
					<?php echo get_template_directory_uri(); ?>/assets/img/img_600x400.jpg 600w"
					alt="Gold Egg Alt Text"
					class="lazyload lazypreload" />
			</figure>
			
		</section>

	</article>

</div>

<?php get_footer(); ?>
