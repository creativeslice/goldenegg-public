<?php 
/**
 * Sample Code for ADVANCED CUSTOM FIELDS 
 *
 * more examples	http://www.advancedcustomfields.com/resources/
 *
 */ 
?>


<?php 
/**
 * Loop through a Flexible Content Field layouts
 *
 * field	content_blocks
 */
while(has_sub_field("content_blocks")): ?>


<?php
/**
 * LAYOUT:	Text Block
 *
 * layout	text_block
 * field	content
 */
if(get_row_layout() == "text_block"): ?>
<section class="entry-content">
	<?php the_sub_field('content'); ?>
</section>


<?php
/**
 * LAYOUT:	Image Text Repeater Block
 *
 * layout	image_text_block
 * fields	block > image / left_block / right_block
 */
elseif(get_row_layout() == "image_text_block"): ?>
<section>
	<?php while(has_sub_field('block')) : 
		$image = get_field('image')) : 
		$url = $image['url'];
		$title = $image['title'];
		$alt = $image['alt'];
		$caption = $image['caption'];
		$size = 'medium';
		$full = $image['sizes'][ $size ];
		$width = $image['sizes'][ $size . '-width' ];
		$height = $image['sizes'][ $size . '-height' ];
	?>
	<div class="entry-content">
		<div class="left-block">
		<?php if (get_sub_field('image')) { ?>
			<figure>
				<img src="<?php echo $full; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
			<?php if ($caption) { ?>
				<figcaption class="wp-caption-text"><?php echo $caption; ?></figcaption>
			<?php } ?>
			</figure>
		<?php } else {
			the_sub_field('left_block'); 
		} ?>
		</div>
		<div class="right-block">
			<?php the_sub_field('right_block'); ?>
		</div>
	</div>
	<?php endwhile; ?>
</section>


<?php
/**
 * LAYOUT:	Flickity Slideshow w/ lazy loading
 *
 * layout	slideshow
 * field	slideshow
 */
elseif(get_row_layout() == "slideshow"):

if( $images = get_sub_field('slideshow') ): $total = count($images); ?>
<section class="slideshow-block cf">
    <p><span class="img-counter">1</span> of <?php echo $total; ?></p>
    <ul class="slideshow">
    <?php $i = 1; foreach( $images as $image ): ?>
        <li class="slideshow-cell" data-slide-count="<?php echo $i; ?>">
        	<img src="<?php echo get_template_directory_uri(); ?>/assets/img/nothing.gif" data-flickity-lazyload="<?php echo $image['sizes']['slideshow']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['sizes']['slideshow-width']; ?>" height="<?php echo $image['sizes']['slideshow-height']; ?>" />
            <p class="caption"><?php echo $image['caption']; ?></p>
        </li>
    <?php $i++; endforeach; ?>
    </ul>
</section>
<?php endif; ?>


<?php endif; endwhile; // end content_block loop ?>