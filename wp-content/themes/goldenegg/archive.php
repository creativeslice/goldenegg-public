<?php get_header(); ?>

<div id="content" class="wrap">

	<?php if ( is_category() ) : ?>
		<h1 class="archiveTitle">
			<span>Posts Categorized:</span> <?php single_cat_title(); ?>
		</h1>

	<?php elseif ( is_tag() ) : ?>
		<h1 class="archiveTitle">
			<span>Posts Tagged:</span> <?php single_tag_title(); ?>
		</h1>

	<?php elseif ( is_author() ) :
		global $post;
		$author_id = $post->post_author;
	?>
		<h1 class="archiveTitle">
			<span>Posts By:</span> <?php the_author_meta('display_name', $author_id); ?>
		</h1>
	<?php elseif ( is_day() ) : ?>
		<h1 class="archiveTitle">
			<span>Daily Archives:</span> <?php the_time('l, F j, Y'); ?>
		</h1>

	<?php elseif ( is_month() ) : ?>
		<h1 class="archiveTitle">
			<span>Monthly Archives:</span> <?php the_time('F Y'); ?>
		</h1>

	<?php elseif ( is_year() ) : ?>
		<h1 class="archiveTitle">
			<span>Yearly Archives:</span> <?php the_time('Y'); ?>
		</h1>
		
	<?php endif; ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class( 'cf' ); ?>>

		<header class="articleHeader">
			<a class="h3" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</header>

		<section class="entryContent">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
			<?php the_excerpt(); ?>
		</section>

	</article>

	<?php endwhile;
		get_template_part( 'components/pageNavi/pageNavi' );
	else : 
		echo '<h1>Nothing Found Here</h1>';
	endif; ?>

</div>

<?php get_footer();
