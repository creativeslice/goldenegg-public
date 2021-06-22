<?php // ACF Expanding Text Block
	
	// ID & Classes
	$block_id = 'expanding-text-' . $block['id'];
    $block_classes = 'acf-block expanding-text-block alignfull';
	
	// Block Specific Fields
	$section_title = ( ! empty(get_field('section_title') ) ? get_field('section_title') : '');
	$section_icon = ( ! empty(get_field('acf_icon') ) ? get_field('acf_icon') : '');
    $faq_schema = ( ! empty(get_field('faq_schema') ) ? get_field('faq_schema') : '');

?>

<section id="<?php echo $block_id; ?>" class="<?php echo $block_classes; ?>"  
	<?php if($faq_schema){ echo ' itemscope itemtype="https://schema.org/FAQPage"'; } ?>>
		
	<?php if($section_title) { ?>
		<h2 class="sectionTitle wrapper has-xlarge-font-size">
			<?php if ($section_icon) { ?>
				<svg class="colorSVG"><use href="<?php echo get_svg($section_icon); ?>"></use></svg>
			<?php } ?>
			<?php echo $section_title; ?>
		</h2>
	<?php } ?>
	
	<?php if(have_rows('expanding_text')): ?>
		<?php while(have_rows('expanding_text')): the_row();
	    	$title = get_sub_field('title');
			$content = get_sub_field('content');
	    ?>
			<div class="expandBlock"<?php if($faq_schema){ echo ' itemscope itemprop="mainEntity" itemtype="https://schema.org/Question"'; } ?>>
				
				<button class="toggleContent has-medium-font-size">
					<span <?php if($faq_schema){ echo 'itemprop="name"'; } ?>>
						<?php echo $title; ?>
					</span>
					<svg><use xlink:href="<?php echo get_svg('arrow-right'); ?>"></use></svg>
				</button>
				
				<div class="hiddenContent"<?php if($faq_schema){ echo ' itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"'; } ?>>
					<div class="entryContent"<?php if($faq_schema){ echo ' itemprop="text"'; } ?>>
		                <?php echo $content; ?>
					</div>
				</div>
		
			</div>
		<?php endwhile; ?>
		
	<?php elseif( is_admin() ) : // Show admin notice ?>
		<h5 class="acf_editor_select_notice">Add expanding text...</h5>
	<?php endif; ?>
	
</section>
