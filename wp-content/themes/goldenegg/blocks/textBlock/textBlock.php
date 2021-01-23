<?php // ACF contentBlocks - Text Block
	
	$build_count = $settings['build_count'];
	$section_title = ( ! empty($settings['section_title']) ? $settings['section_title'] : '' );
	$block_style = ( ! empty($settings['block_style']) ? $settings['block_style'] : '' ); // one, two, three
	$block_color = ( ! empty($settings['block_color']) ? $settings['block_color'] : '' ); // default, white, black
	$content = ( ! empty($settings['content']) ? $settings['content'] : '' );
	$content2 = ( ! empty($settings['content2']) ? $settings['content2'] : '' );
	$content3 = ( ! empty($settings['content3']) ? $settings['content3'] : '' );
?>

<section id="block<?php echo $build_count; ?>" class="textBlock style-<?php echo $block_style; ?> color-<?php echo $block_color; ?>">
	
	<?php if($section_title) { ?>
	<h2 class="sectionTitle h5"><?php echo $section_title; ?></h2>
	<?php } ?>
	
	<?php if($content) { ?>
	<div class="entryContent">
		<?php echo $content; ?>
	</div>
	<?php } ?>
	
	<?php if ($block_style != 'one') { ?>
	<div class="entryContent">
		<?php echo $content2; ?>
	</div>
	<?php } ?>
	
	<?php if ($block_style == 'three') { ?>
	<div class="entryContent">
		<?php echo $content3; ?>
	</div>
	<?php } ?>

</section>