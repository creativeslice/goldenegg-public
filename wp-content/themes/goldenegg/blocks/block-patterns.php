<?php
/**
 * Twenty Twenty-Two: Block Patterns
 *
 * @since 1.0
 */
if ( ! function_exists( 'twentytwentytwo_register_block_patterns' ) ) :
	function twentytwentytwo_register_block_patterns() {
		if ( function_exists( 'register_block_pattern_category' ) ) {
			register_block_pattern_category(
				'twentytwentytwo-query',
				array( 'label' => __( 'Twenty Twenty-Two Posts', 'twentytwentytwo' ) )
			);
			register_block_pattern_category(
				'twentytwentytwo-pages',
				array( 'label' => __( 'Twenty Twenty-Two Pages', 'twentytwentytwo' ) )
			);
		}
		if ( function_exists( 'register_block_pattern' ) ) {
			$block_patterns = array(
				'page-about-big-image-and-buttons',
				'page-layout-two-columns',
				'query-default',
				//'query-image-grid',
				//'query-irregular-grid',
			);
			foreach ( $block_patterns as $block_pattern ) {
				register_block_pattern(
					'twentytwentytwo/' . $block_pattern,
					require __DIR__ . '/patterns/' . $block_pattern . '.php'
				);
			}
		}
	}
endif;
add_action( 'init', 'twentytwentytwo_register_block_patterns', 9 );