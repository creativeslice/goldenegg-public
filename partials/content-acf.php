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
<section class='entry-content'>
	<?php the_sub_field('content'); ?>
</section>


<?php
/**
 * LAYOUT:	Image Text Repeater Block
 *
 * layout	image_text_block
 * fields	image_text_repeater > image / left_block / right_block
 */
elseif(get_row_layout() == "image_text_block"): ?>
<section>
	<?php while(has_sub_field('image_text_repeater')): 
	$image = wp_get_attachment_image_src(get_sub_field('image'), 'thumbnail'); ?>
	<div class="entry-content">
		<div class="left-block">
		<?php if (get_sub_field('image')) { ?>
			<img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(get_sub_field('image')); ?>" />
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
 * LAYOUT:	Gallery Block (flexslider example)
 *
 * layout	gallery
 * field	gallery
 */
elseif(get_row_layout() == "gallery_block"):

$images = get_field('gallery');
 
if( $images ): ?>
    <div id="slider" class="flexslider">
        <ul class="slides">
            <?php foreach( $images as $image ): ?>
                <li>
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                    <p><?php echo $image['caption']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div id="carousel" class="flexslider">
        <ul class="slides">
            <?php foreach( $images as $image ): ?>
                <li>
                    <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<?php endif; endwhile; // end content_block loop ?>