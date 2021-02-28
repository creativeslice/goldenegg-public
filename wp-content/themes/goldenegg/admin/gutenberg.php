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
	add_theme_support( 'align-wide' ); // adds full and wide options
	
	// Custom Font Sizes
	add_theme_support( 'disable-custom-font-sizes' ); // disallow user to set any size
	add_theme_support( 'editor-font-sizes', array(
		array(
            'name'      => __( 'Small', 'egg' ),
            'shortName' => __( 'S', 'egg' ),
            'size'      => 12,
            'slug'      => 'small'
        ),
        array(
            'name'      => __( 'Medium', 'egg' ),
            'shortName' => __( 'M', 'egg' ),
            'size'      => 20,
            'slug'      => 'medium'
        ),
        array(
            'name'      => __( 'Large', 'egg' ),
            'shortName' => __( 'L', 'egg' ),
            'size'      => 28,
            'slug'      => 'large'
        )
    ) );
  
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
 * Remove Drop cap
 wp.data.dispatch('core/edit-post').removeEditorPanel('discussion-panel');
 */
add_filter('block_editor_settings', function ($editor_settings) {
	$editor_settings['__experimentalFeatures']['global']['typography']['dropCap'] = false;
	return $editor_settings;
});



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
			//'supports' 			=> array( 'mode' => false ), // turn off main panel editing
			'category'			=> 'layout',
			'icon'				=> 'excerpt-view',
			'keywords'			=> array( 'portfolio' ),
		));
	}
}



/**
 * Enqueue block JavaScript and CSS for Gutenberg Editor
 */
add_action( 'enqueue_block_editor_assets', 'egg_block_editor_scripts' );
function egg_block_editor_scripts() {
	
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/editor.css' );

/*
	// Enqueue block editor JS
    wp_enqueue_script(
        'my-block-editor-js',
        plugins_url( '/blocks/portfolio-item/portfolio-item.js', __FILE__ ),
        [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/portfolio-item/portfolio-item.js' )	
    );
*/

    // Enqueue block editor styles
    wp_register_style( 'egg-block-editor-css', 
    	get_stylesheet_directory_uri() . '/assets/css/editor.css?v=' . $csschanged, 
    	[ 'wp-edit-blocks' ], 
    	'', 
    	'all' 
    );

}


/**
 * Enqueue frontend and editor JavaScript and CSS
 */
add_action( 'enqueue_block_assets', 'egg_block_scripts' );
function egg_block_scripts() {
	
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/style.css' );
	
    // Enqueue block editor styles
    wp_enqueue_style( 'egg-block-css', 
    	get_stylesheet_directory_uri() . '/assets/css/editor.css?v=' . $csschanged, 
    	[ 'wp-edit-blocks' ], 
    	'', 
    	'all' 
    );

}

