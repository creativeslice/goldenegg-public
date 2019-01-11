<?php // ACF contentBlocks - Expanding Text
	$section_title = ( ! empty($settings['section_title']) ? $settings['section_title'] : '' );
?>
<section class="expandingText wrap">
	
	<?php if($section_title) { ?>
	<h3 class="sectionTitle"><?php echo $section_title; ?></h3>
	<?php } ?>
	
	<?php foreach ( $settings['blocks'] as $block ) : ?>
	<div class="expandBlock">
		
		<h4 class="toggleContent">
			<?php echo $block['title']; ?>
		</h4>
		
		<div class="hiddenContent entryContent">
			<?php echo $block['content']; ?>
		</div>

	</div>
	<?php endforeach; ?>
	
</section>