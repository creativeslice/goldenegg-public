<?php get_header(); // Template Name: 10UP Lazy Load ?>

<div id="content">

	<div class="wrap">

		<div id="main" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class( 'cf' ); ?>>

				<header class="article-header">
					<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
				</header>
				
								
				<section class="entry-content" itemprop="articleBody">
					<h2>Lazy Loaded Gallery Blocks - 10Up Sonar & ACF</h2>
					<h3>Required ACF Fields</h3>
					<ul>
						<li>Name: Content Blocks  |  type: flexible content</li>
						<li>Layout-> Name: gallery_block  |  display: bock  </li>
						<li>Field->  Name: gallery |  type: gallery</li>
					</ul>
					<p>View page-10up.php for javascript and php
					<?php the_content(); ?>
				</section>

			</article>
			<div style='height:1200px'></div>

			<?php endwhile; endif; ?>
<?php
/**
 * LAYOUT:	Gallery Block (flexslider example)
 *
 * layout	gallery_block
 * field	gallery
 */
while(has_sub_field("content_blocks")): 
	if(get_row_layout() == "gallery_block"):

		$images = get_sub_field('gallery');
		if( $images ): ?>

<section class='acf-gallery fade-block cf'>
	<div class="wrap">
		<div class="goldlarge last-col">
			<a class='button' id='force_lazy'>View Gallery</a>
	    <?php foreach( $images as $image ): ?>
	        <a class="colorbox" href="<?php echo $image['url']; ?>"><img data-lazy-src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
	    <?php endforeach; ?>
		</div>
		<div class="goldsmall">
			<?php if(get_sub_field('gallery_title')) { ?>
			<h3><?php the_sub_field('gallery_title'); ?></h3>
			<?php } ?>
		</div>
	</div>
</section>
	<?php endif; ?>


<?php endif; endwhile; // end content_block loop ?>
		</div>
		<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/modules/10up-lazyload/jquery.sonar.js'></script>
		<script type='text/javascript'>
			//This goes in theme.js 
			jQuery(document).ready(function($) {
				lazy_load_init();
				$( 'body' ).bind( 'post-load', lazy_load_init ); // Work with WP.com infinite scroll
				function lazy_load_init() {
					$( 'img[data-lazy-src]' ).bind( 'scrollin', { distance: 200 }, function() {
						lazy_load_image( this );
					});
			
					// We need to force load gallery images in Jetpack Carousel and give up lazy-loading otherwise images don't show up correctly
					$( '[data-carousel-extra]' ).each( function() {
						$( this ).find( 'img[data-lazy-src]' ).each( function() {
							lazy_load_image( this );
						} );		
					} );
				}
			
				function lazy_load_image( img ) {
					var $img = jQuery( img ),
						src = $img.attr( 'data-lazy-src' );
	
					$img.unbind( 'scrollin' ) // remove event binding
						.hide()
						.removeAttr( 'data-lazy-src' )
						.attr( 'data-lazy-loaded', 'true' );
			
					img.src = src;
					$img.fadeIn();
				}
			}); /* end of as page load scripts */

		</script>
	</div>

</div>

<?php get_footer(); ?>
