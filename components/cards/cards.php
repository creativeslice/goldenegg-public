<?php // ACF contentBlocks - Cards
	$build_count = $settings['build_count'];
	$section_title = ( ! empty($settings['section_title']) ? $settings['section_title'] : '' );
	$block_style = ( ! empty($settings['block_style']) ? $settings['block_style'] : '' ); // two, three, four
	$block_color = ( ! empty($settings['block_color']) ? $settings['block_color'] : '' ); // default, white, black
?>

<section id="block<?php echo $build_count; ?>" class="cardBlock color-<?php echo $block_color; ?>">
	
	<?php if($section_title) { ?>
	<h2 class="sectionTitle h5"><?php echo $section_title; ?></h2>
	<?php } ?>
	
	<div class="cards style-<?php echo $block_style; ?>">
	<?php foreach ( $settings['card'] as $card ) :
		$card_title = ( ! empty($card['title']) ? $card['title'] : '' );
		$card_content = ( ! empty($card['content']) ? $card['content'] : '' );
		$card_image = ( ! empty($card['image']) ? $card['image'] : '' );
		$card_link = ( ! empty($card['link']) ? $card['link'] : '' );
	?>
	
		<?php // Card Link
		if($card_link) : ?>
		<a href="<?php echo $card_link['url']; ?>" target="<?php echo $card_link['target']; ?>" class="card">
			
			<?php if ($card_image) : ?>
				<?php if ($block_style == 'two') { ?>
				<figure class="lazyhd"><img
					srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
					data-srcset="
						<?php echo $card_image['sizes']['hd']; ?> 960w,
						<?php echo $card_image['sizes']['hdsm']; ?> 480w"
					sizes="auto"
					data-src="<?php echo $card_image['sizes']['hdsm']; ?>"
					alt="<?php echo $card_image['alt']; ?>"
					class="lazyload lazypreload" />
				</figure>
				<?php } else { ?>
				<figure class="lazyhd"><img
					data-src="<?php echo $card_image['sizes']['hdsm']; ?>"
					alt="<?php echo $card_image['alt']; ?>"
					class="lazyload lazypreload" />
				</figure>
				<?php } ?>
			<?php endif; ?>
			
			<div class="cardContent">
				<?php if($card_title) { ?>
				<h3><?php echo $card_title; ?></h3>
				<?php } ?>
				
				<?php if($card_content) { ?>
				<p><?php echo $card_content; ?></p>
				<?php } ?>
			</div>
			
			<?php if ($block_style != 'four') { ?>
			<div class="bottom">
				<span class="button"><?php echo $card_link['title']; ?></span>
			</div>
			<?php } ?>
			
		</a>
		
		<?php // No Link
		else : ?>
		<div class="card">
			
			<?php if ($card_image) : ?>
				<?php if ($block_style == 'two') { ?>
				<figure class="lazyhd"><img
					srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
					data-srcset="
						<?php echo $card_image['sizes']['hd']; ?> 960w,
						<?php echo $card_image['sizes']['hdsm']; ?> 480w"
					sizes="auto"
					data-src="<?php echo $card_image['sizes']['hdsm']; ?>"
					alt="<?php echo $card_image['alt']; ?>"
					class="lazyload lazypreload" />
				</figure>
				<?php } else { ?>
				<figure class="lazyhd"><img
					data-src="<?php echo $card_image['sizes']['hdsm']; ?>"
					alt="<?php echo $card_image['alt']; ?>"
					class="lazyload lazypreload" />
				</figure>
				<?php } ?>
			<?php endif; ?>
				
			<div class="cardContent">
				<?php if($card_title) { ?>
				<h3><?php echo $card_title; ?></h3>
				<?php } ?>

				<?php if($card_content) { ?>
				<p><?php echo $card_content; ?></p>
				<?php } ?>
			</div>
			
		</div>
		
		<?php endif; ?>
	
	<?php endforeach; ?>
	</div>

</section>