<?php get_header(); // Template Name: Calendar ?>


<div id="content">

	<div class="wrap">

		<div id="main" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class( 'cf' ); ?>>

				<header class="article-header">
					<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
				</header>
<?php

$args = array(
	'selected_time'=>NULL,
	'start_type'=>'selected',
	'add_style'=>1,
	'debug'=>1
);
$cal = new calendar( $args );
$cal->init();

$cal->output_month();
print_r($cal);
unset($cal);
?>
				<section class="entry-content" itemprop="articleBody">
					<?php the_content(); ?>
				</section>

			</article>

			<?php endwhile; endif; ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
