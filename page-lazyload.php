<?php get_header(); // Template Name: LazyDemo ?>

<div id="content">

	<div class="wrap">

		<div id="main" class="goldlarge" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class( 'cf' ); ?>>

				<header class="article-header">
					<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
				</header>
				<section class="entry-content" itemprop="articleBody">
					<?php the_content(); ?>
				</section>

			</article>

			<?php endwhile; endif; ?>
	

<div style='height: 1000px;'></div>
		 
<?php if( have_rows('lazyload') ): ?>
 
	<div class="lazyimages">
 
	<?php while( have_rows('lazyload') ): the_row(); 
 
		// vars
		$image = get_sub_field('image');
		$text = get_sub_field('text');
 
		?> 
		<!-- LAZYLOAD TUUPOLA<img class="lazy" data-original="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />-->
		<!--<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />-->
		<img data-lazy-src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" style='min-height:100px; width:1px; display:block;'/>
				
		<?php if( $text ): ?>
		<span><?php echo $text;?></span>
		<?php endif; ?>
		
	<?php endwhile; ?>
	
	</div>
 
<?php endif; ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
