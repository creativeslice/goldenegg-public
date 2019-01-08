<?php
/**
 * Loop through ACF Flexible Content Field layouts
 */
$count = 1;
$content_blocks = get_field( 'content_blocks' );
foreach ( $content_blocks as $settings ) :

	$block                   = $settings['acf_fc_layout'];
	$settings['type']        = 'contentBlocks';
	$settings['build_count'] = $count;
	egg_component( $block, $settings );

	$count++;
endforeach;