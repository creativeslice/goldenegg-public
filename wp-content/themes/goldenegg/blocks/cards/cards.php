<?php // ACF Cards Block
	
	// ID & Classes
	$block_id = 'cards-' . $block['id'];
	$block_classes = 'acf-block cards-block';
	
	// Unique fields for this block
	$card_size = ( ! empty(get_field('card_size') ) ? get_field('card_size') : 'four'); // two, three, four
	if( $card_size ) {
		$block_classes .= ' columns-' . $card_size;
	}
?>

<section id="<?php echo $block_id; ?>" class="<?php echo $block_classes; ?>">

	<?php if (get_field('cards')) : ?>
		<div class="wrapper">
		<?php while ( have_rows( 'cards' ) ) : the_row(); 
			$card_content = ( ! empty(get_sub_field('content') ) ? get_sub_field('content') : '');
			$card_image = ( ! empty(get_sub_field('image') ) ? get_sub_field('image') : '');
			$image_alignment = ( ! empty(get_sub_field('image_alignment') ) ? get_sub_field('image_alignment') : '');
			$card_link = ( ! empty(get_sub_field('link') ) ? get_sub_field('link') : '');
			$card_icon = ( ! empty(get_sub_field('acf_icon') ) ? get_sub_field('acf_icon') : '');
			$card_color = ( ! empty(get_sub_field('block_color') ) ? get_sub_field('block_color') : '');			
			$card_classes = 'cardACF ' . $image_alignment;
			if( $card_content == '') {
				$card_classes .= ' noText';
			} elseif( $card_image == '') {
				$card_classes .= ' noImage';
			}
			if( $card_color ) {
				$card_classes .= ' is-style-block-color has-' . $card_color . '-color';
			}
		?>
		
			<?php // Card Link
			if($card_link) : ?>
				<a href="<?php echo $card_link['url']; ?>" target="<?php echo $card_link['target']; ?>" class="<?php echo $card_classes; ?>" data-aos="fade-up" data-aos-duration="1200">
					
					<?php if($card_icon) { ?>
						<svg class="cardIcon"><use href="<?php echo get_svg($card_icon); ?>"></use></svg>
					<?php } ?>
					
					<?php if ($card_image) : ?>
						<figure><?php echo wp_get_attachment_image( $card_image['ID'], "square" ); ?></figure>
					<?php endif; ?>
					
					<?php if($card_content) { ?>
						<div class="cardContent">
							<p class="has-medium-font-size"><?php echo $card_content; ?></p>
						</div>
					<?php } ?>
					
				</a>
		
			<?php // No Link
			else : ?>
				<div class="<?php echo $card_classes; ?>" data-aos="fade-up" data-aos-duration="1200">
					
					<?php if($card_icon) { ?>
						<svg class="cardIcon"><use href="<?php echo get_svg($card_icon); ?>"></use></svg>
					<?php } ?>
					
					<?php if ($card_image) : ?>
						<figure><?php echo wp_get_attachment_image( $card_image['ID'], "square" ); ?></figure>
					<?php endif; ?>
					
					<?php if($card_content) { ?>
						<div class="cardContent">
							<p class="has-medium-font-size"><?php echo $card_content; ?></p>
						</div>
					<?php } ?>
					
				</div>
			
			<?php endif; ?>
		<?php endwhile; ?>
		</div>
	
	<?php elseif( is_admin() ) : // Show admin notice ?>
		<h5 class="acf_editor_select_notice">Add cards...</h5>
	<?php endif; ?>

</section>
