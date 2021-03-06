<?php // Gutenberg Functions


/**
 * Limit Default Gutenberg Block Types
 */
add_filter( 'allowed_block_types', 'egg_allowed_block_types' );
function egg_allowed_block_types( $allowed_blocks ) {
	return array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'acf/portfolio-item'
	);
}



/**
 * Admin Gutenberg Refinements
 * https://developer.wordpress.org/block-editor/developers/themes/theme-support/
 */
add_action( 'after_setup_theme', 'egg_gutenberg_editor_setup' );
function egg_gutenberg_editor_setup() {
	
	#add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	#add_theme_support( 'disable-custom-font-sizes' );

  
	// Custom Color Palette
	add_theme_support( 'disable-custom-colors' ); // disallow user to select any color
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Gray', 'egg' ),
			'slug'  => 'gray',
			'color'	=> '#666',
		),
		array(
			'name'  => __( 'Gray Light', 'egg' ),
			'slug'  => 'gray_light',
			'color'	=> '#999',
		),
		array(
			'name'  => __( 'Blue', 'egg' ),
			'slug'  => 'blue',
			'color'	=> '#2779AE',
		),
		array(
			'name'  => __( 'Green', 'egg' ),
			'slug'  => 'green',
			'color' => '#547E2A',
		),
		array(
			'name'  => __( 'Gold', 'egg' ),
			'slug'  => 'gold',
			'color' => '#e8c200',
		),
		array(
			'name'	=> __( 'Red', 'egg' ),
			'slug'	=> 'red',
			'color'	=> '#d3033d',
		),
	) );
}




/**
 * ACF Gutenberg Blocks
 */
add_action('acf/init', 'acf_portfolio_item_block');
function acf_portfolio_item_block() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a portfolio item block
		acf_register_block(array(
			'name'				=> 'portfolio-item',
			'title'				=> __('Portfolio Item'),
			'description'		=> __('A custom block for portfolio items.'),
			'render_template'	=> 'blocks/portfolio-item/block-portfolio-item.php',
			'category'			=> 'layout',
			'icon'				=> 'excerpt-view',
			'keywords'			=> array( 'portfolio' ),
		));
	}
}


