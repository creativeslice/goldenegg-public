<?php get_header(); // Template Name: Home ?>

<article id="wrap" class="wrap">

	<header class="articleHeader">
		<h1><?php the_title(); ?></h1>
	</header>

	<section class="entryContent">
		
		<?php the_post(); the_content(); ?>
		
		<hr>
		
		<?php egg_component( 'image', [
			'alt'      => 'Gold Egg Alt Text',
			'class'    => 'lazy70',
			'lazyload' => 'lazypreload',
			'sizes'    => [
				'(max-width: 767px) 100vw',
				'80vw',
			],
			'src'      => get_template_directory_uri() . '/assets/img/img_600x400.jpg',
			'srcset'   => [
				'600w'    => get_template_directory_uri() . '/assets/img/img_600x400.jpg',
				'1000w'   => get_template_directory_uri() . '/assets/img/img_1000x700.jpg',
			],
		]); ?>

		<hr>
		
		<div class="boxImage">
			<figure class="lazy70"><img data-sizes="(max-width: 767px) 100vw, 80vw"
				data-src="<?php echo get_template_directory_uri(); ?>/assets/img/img_600x400.jpg"
				data-srcset="<?php echo get_template_directory_uri(); ?>/assets/img/img_600x400.jpg 600w,
					<?php echo get_template_directory_uri(); ?>/assets/img/img_1000x700.jpg 1000w"
				alt="Gold Egg Alt Text"
				class="lazyload lazypreload" />
			</figure>
		</div>
		
	</section>

</article>

<?php get_footer();
