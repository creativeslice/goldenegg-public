<?php // ACF Image Icon Text
	
	// ID & Classes
	$block_id = 'image-icon-text-' . $block['id'];
	$block_classes = 'image-icon-text-block';
	
	// icon
	$section_icon = ( ! empty(get_field('acf_icon') ) ? get_field('acf_icon') : '');
	$circle_image = ( ! empty(get_field('circle_image') ) ? get_field('circle_image') : '');	

    // Limit Blocks
    $inner_allowed_blocks = [
    	'core/heading',
    	'core/paragraph',
    	'core/buttons'
    ];

    // Placeholder template
    $inner_template = [
        [ 'core/paragraph',
            [
                'fontSize' => 'medium', 'placeholder' => 'Name or Title',
            ]
        ],
        [ 'core/paragraph',
            [
                'placeholder' => 'Subtitle',
            ]
        ],
    ];
?>

<div id="<?php echo $block_id; ?>" class="<?php echo $block_classes; ?>">
	
	<?php if( $circle_image ): ?>
		<figure class="sideImage"><?php echo wp_get_attachment_image( $circle_image['ID'], 'square' ); ?></figure>
	<?php elseif ($section_icon) : ?>
		<span class="sideIcon"><svg class="colorSVG"><use href="<?php echo get_svg($section_icon); ?>"></use></svg></span>
	<?php endif; ?>

	<div class="sideContent"><InnerBlocks 
		allowedBlocks="<?php echo esc_attr( wp_json_encode( $inner_allowed_blocks ) ); ?>" 
		template="<?php echo esc_attr( wp_json_encode( $inner_template ) ); ?>" />
	</div>

</div>
