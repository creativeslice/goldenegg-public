<?php // ACF contentBlocks - Text Block
	$title = ( ! empty($settings['title']) ? $settings['title'] : '' );
	$content = ( ! empty($settings['content']) ? $settings['content'] : '' );
?>

<section class="textBlock wrap">
	
	<?php if($title) { ?>
	<h3 class="sectionTitle"><?php echo $title; ?></h3>
	<?php } ?>
	
	<?php if($content) { ?>
	<div class="entryContent">
		<?php echo $content; ?>
	</div>
	<?php } ?>

</section>