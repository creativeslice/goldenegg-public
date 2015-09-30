<?php get_header(); // Template Name: Calendar ?>

<div id="content">

	<div class="wrap">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class( 'cf' ); ?>>

			<header class="article-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>

			<?php // Show Calendar
			$events = new eggEvents;
			$events->get_events('','30' );
			$args = array(
				'range'			=> '1 month',
				'selected_time'	=> NULL,
				'start_type'	=> 'natural',
				'add_style'		=> 1,
				'debug'			=> 1
			);
			$cal = new calendar( $args );
			$cal->output_month();
			// print_r($cal);
			unset($cal);
			?>
			
			<section class="entry-content">
				<?php the_content(); ?>
			</section>

		</article>

		<?php endwhile; endif; ?>

	</div>

</div>

<?php get_footer(); ?>
