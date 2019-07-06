<?php // ACF contentBlocks - Expanding Text
	$section_title = ( ! empty($settings['section_title']) ? $settings['section_title'] : '' );
?>
<section class="expandingText wrap">
	
	<?php if($section_title) { ?>
	<h2 class="sectionTitle"><?php echo $section_title; ?></h2>
	<?php } ?>
	
	<?php foreach ( $settings['blocks'] as $block ) : ?>
	<div class="expandBlock">
		
		<strong class="toggleContent">
			<?php echo $block['title']; ?>
			<svg title="Open Menu" role="presentation">
				<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#arrow-down"></use>
			</svg>
		</strong>
		
		<div class="hiddenContent entryContent">
			<?php echo $block['content']; ?>
		</div>

	</div>
	<?php endforeach; ?>
	
</section>