<?php // ACF contentBlocks - Expanding Text
	$build_count = $settings['build_count'];
	$section_title = ( ! empty($settings['section_title']) ? $settings['section_title'] : '' );
	$faq_schema = ( ! empty($settings['faq_schema']) ? $settings['faq_schema'] : '' );
?>

<section id="block<?php echo $build_count; ?>" class="expandingText" <?php if($faq_schema){ echo 'itemscope itemtype="https://schema.org/FAQPage"'; } ?>>
	
	<?php if($section_title) { ?>
	<h2 class="sectionTitle h5"><?php echo $section_title; ?></h2>
	<?php } ?>
	
	<?php foreach ( $settings['blocks'] as $block ) : ?>
	<div class="expandBlock"<?php if($faq_schema){ echo ' itemscope itemprop="mainEntity" itemtype="https://schema.org/Question"'; } ?>>
		
		<button class="toggleContent">
			<span <?php if($faq_schema){ echo 'itemprop="name"'; } ?>><?php echo $block['title']; ?></span>
			<svg title="Open Menu" role="presentation"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#arrow-down"></use></svg>
		</button>
		
		<div class="hiddenContent"<?php if($faq_schema){ echo ' itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"'; } ?>>
			<div class="entryContent"<?php if($faq_schema){ echo ' itemprop="text"'; } ?>>
				<?php echo $block['content']; ?>
			</div>
		</div>

	</div>
	<?php endforeach; ?>
	
</section>