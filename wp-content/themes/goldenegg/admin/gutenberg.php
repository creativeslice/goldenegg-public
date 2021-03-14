<?php // Gutenberg Functions


/**
 * Limit Default Gutenberg Block Types
 */
//add_filter( 'allowed_block_types', 'egg_allowed_block_types' );
function egg_allowed_block_types( $allowed_blocks ) {
	return array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/buttons',
		'acf/portfolio-item'
	);
}


/**
 * Admin Gutenberg Refinements
 * https://developer.wordpress.org/block-editor/developers/themes/theme-support/
 */
add_action( 'after_setup_theme', 'egg_gutenberg_editor_setup' );
function egg_gutenberg_editor_setup() {
	
	// load core block styles (like for columns)
	#add_theme_support( 'wp-block-styles' );
	
	// add full and wide options to blocks
	add_theme_support( 'align-wide' ); 
	
	// disallow user to set any border radius
	add_theme_support( 'disable-border-settings' ); 
	
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
			'name'  => __( 'White', 'egg' ),
			'slug'  => 'white',
			'color'	=> '#fff',
		),
		array(
			'name'  => __( 'Black', 'egg' ),
			'slug'  => 'black',
			'color'	=> '#111',
		),
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
	
	// Custom Color Gradients
	add_theme_support( 'disable-custom-gradients' ); // disallow user to create new gradients
	add_theme_support( 'editor-gradient-presets', array(
		array(
            'name' => __( 'Green to blue', 'egg'),
			'gradient' => 'linear-gradient(135deg,rgb(0,250,56) 0%,rgb(0,27,255) 100%)',
			'slug' => 'green-to-blue'
        ),
        array(
            'name' => esc_html__( 'Red to yellow', 'egg'),
			'gradient' => 'linear-gradient(115deg,rgb(250,0,0) 0%,rgb(255,225,0) 100%)',
			'slug' => 'red-to-yellow'
        )
    ) );

	
}


/**
 * Disable Specific Block Editor Settings
 */
add_filter( 'block_editor_settings', 'egg_editor_settings');
function egg_editor_settings ( $editor_settings ) {
	$editor_settings['__experimentalFeatures']['global']['typography']['dropCap'] = false; // disable dropCap, no longer works
	//$editor_settings['imageEditing'] = false; // disable inline image editing
	return $editor_settings;
}




/*********************
GUTENBERG ENQUEUE
*********************/

/**
 * Enqueue block JavaScript and CSS for Gutenberg Editor
 */
add_action( 'enqueue_block_editor_assets', 'egg_block_editor_scripts' );
function egg_block_editor_scripts() {
	
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/editor.css' );

    // Enqueue block editor CSS
    wp_register_style( 'egg-block-editor-css', 
    	get_stylesheet_directory_uri() . '/assets/css/editor.css?v=' . $csschanged, 
    	[ 'wp-edit-blocks' ], '', 'all' 
    );
    
    /*
	// Enqueue block editor JS
    wp_enqueue_script(
        'my-block-editor-js',
        plugins_url( '/blocks/portfolio-item/portfolio-item.js', __FILE__ ),
        [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/portfolio-item/portfolio-item.js' )	
    );
	*/

}


/**
 * Enqueue frontend and editor CSS (JS too?)
 */
add_action( 'enqueue_block_assets', 'egg_block_scripts' );
function egg_block_scripts() {
	
	$csschanged = filemtime( realpath(__DIR__ . '/..') . '/assets/css/styles.css' );
	
    // Enqueue block editor CSS
    wp_enqueue_style( 'egg-block-css', 
    	get_stylesheet_directory_uri() . '/assets/css/editor.css?v=' . $csschanged, 
    	[ 'wp-edit-blocks' ], '', 'all' 
    );

}



/*********************
GUTENBERG TEMPLATES
*********************/

/**
 * Post Example
 */
add_action( 'init', 'egg_post_register_template' );
function egg_post_register_template() {
    $post_type_object = get_post_type_object( 'post' );
    $post_type_object->template = array(
        array( 'core/image' ),
        array( 'core/paragraph', array(
            'placeholder' => 'Add Description...',
        ) ),
    );
    $post_type_object->template_lock = 'all';
}

/**
 * Page Example
 */
add_action( 'init', 'egg_page_register_template' );
function egg_page_register_template() {
    $post_type_object = get_post_type_object( 'page' );
    $post_type_object->template = array(
        array( 'core/heading', array( 'level' => 5, 'content' => 'Role' ) ),
		array( 'core/paragraph' ),
		array( 'core/heading', array( 'level' => 5, 'content' => 'Responsibilities' ) ),
		array( 'core/paragraph' ),
		array( 'core/heading', array( 'level' => 5, 'content' => 'Qualifications' ) ),
		array( 'core/list' ),
		array( 'core/heading', array( 'level' => 5, 'content' => 'Highlights' ) ),
		array( 'core/paragraph' ),
    );
}


/*********************
GUTENBERG BLOCK PATTERNS
*********************/

/**
 * Block Pattern Example
 */
add_action( 'init', 'egg_wp_block_patterns' );
function egg_wp_block_patterns() {
    register_block_pattern(
        'page-intro-block/my-custom-pattern',
        array(
            'title'       => __( 'Page Intro Blocks', 'page-intro-block' ),
            
            'description' => _x( 'Includes a cover block, two columns with headings and text, a separator and a single-column text block.', 'Block pattern description', 'page-intro-block' ),
            
            'content'     => "<!-- wp:cover -->\n<div class=\"wp-block-cover has-background-dim\"><div class=\"wp-block-cover__inner-container\"></div></div>\n<!-- /wp:cover -->\n\n<!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2>Heading</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Content Area #1</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2>Heading</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Content Area #2</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:separator {\"className\":\"is-style-wide\"} -->\n<hr class=\"wp-block-separator is-style-wide\"/>\n<!-- /wp:separator -->\n\n<!-- wp:paragraph -->\n<p>Content Area #3</p>\n<!-- /wp:paragraph -->",
            
            'categories'  => array('header'),
        )
    );

}    



/*********************
GUTENBERG ACF BLOCKS
*********************/

/**
 * ACF Sample Block
 */
add_action('acf/init', 'acf_portfolio_item_block');
function acf_portfolio_item_block() {
	if( function_exists('acf_register_block') ) {
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

