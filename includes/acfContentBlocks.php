<?php 
/**
 * Loop through a Flexible Content Field layouts
 */
$ctblocks = 0;
while(has_sub_field('content_blocks')): 
	if($block = get_row_layout()) {
		include(locate_template( 'components/'. $block .'/'. $block .'.php' ));
	};
$ctblocks++; 
endwhile;
?>