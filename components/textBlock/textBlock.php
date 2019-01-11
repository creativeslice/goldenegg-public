<?php // ACF contentBlocks - Text Block
	$section_title = get_sub_field('section_title');
	$content = get_sub_field('content');
?>

<section class="textBlock">
	
	<?php if($section_title) { ?>
	<h3 class="sectionTitle"><?php echo $section_title; ?></h3>
	<?php } ?>
	
	<?php if($content) { ?>
	<div class="entryContent">
		<?php echo $content; ?>
	</div>
	<?php } ?>

</section>