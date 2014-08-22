<?php get_header(); ?>

<div id="content">

	<div class="wrap">

		<div id="main" role="main">
		
			<h1 class="archive-title"><span>Search Results for:</span> <?php echo get_search_query(); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php if( 'page' == get_post_type() ): // this is a page ?>
				<article <?php post_class('cf'); ?>>
					<h3><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<?php the_excerpt(); ?>
				</article>
				
				<?php elseif( 'post' == get_post_type() ): // this is a post ?>
				<article <?php post_class('cf'); ?>>
					<h3><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<span class="byline">Posted <?php the_time('F j, Y'); ?></span>
					<?php the_excerpt(); ?>
				</article>
			
				<?php else : // this is another post type ?>
				<article <?php post_class('cf'); ?>>
					<h3><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<?php the_excerpt(); ?>
				</article>
				<?php endif; ?>

			<?php endwhile; ?>
				<?php do_action('egg/page_navi'); ?>
			<?php else : ?>
				<?php get_template_part( 'partials/content', 'missing' ); ?>
			<?php endif; ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>