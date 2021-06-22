<?php // Gutenberg Functions


/**
 * Limit Default Gutenberg Block Types
 * managed through assets/js/editor.js
 */
/*
add_filter( 'allowed_block_types', 'egg_allowed_block_types' );
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
*/


/**
 * Disable Specific Block Editor Styles
 */
add_filter( 'block_editor_settings' , 'remove_guten_wrapper_styles', 99 );
function remove_guten_wrapper_styles( $settings ) {
    unset($settings['styles'][0]);
    return $settings;
}


/**
 * Remove Embed Scripts & Gutenberg Styles
 */
add_action( 'wp_enqueue_scripts', 'egg_wp_enqueue_scripts' );
function egg_wp_enqueue_scripts() {
	wp_deregister_script( 'wp-embed' );
	//wp_dequeue_style( 'wp-block-library' );
}


/**
 * Admin Gutenberg Refinements
 * https://developer.wordpress.org/block-editor/developers/themes/theme-support/
 */
add_action( 'after_setup_theme', 'egg_gutenberg_editor_setup' );
function egg_gutenberg_editor_setup() {
	
	// load core block styles (like for columns)
	#add_theme_support( 'wp-block-styles' );

	// Disabling the default block patterns
	remove_theme_support( 'core-block-patterns' );
	
	// add full and wide options to blocks
	add_theme_support( 'align-wide' ); 
	
	// disallow user to set any border radius
	add_theme_support( 'disable-border-settings' ); 
	
	// Custom Font Sizes
	add_theme_support( 'disable-custom-font-sizes' ); // disallow user to set any size
	add_theme_support( 'editor-font-sizes', array(
        array(
            'name'      => __( 'Tiny', 'goldenegg' ),
            'shortName' => __( 'XS', 'goldenegg' ),
            'size'      => 12,
            'slug'      => 'tiny'
        ),
        array(
            'name'      => __( 'Small', 'goldenegg' ),
            'shortName' => __( 'S', 'goldenegg' ),
            'size'      => 16,
            'slug'      => 'small'
        ),
        array(
            'name'      => __( 'Medium', 'goldenegg' ),
            'shortName' => __( 'M', 'goldenegg' ),
            'size'      => 18,
            'slug'      => 'medium'
        ),
        array(
            'name'      => __( 'Large', 'goldenegg' ),
            'shortName' => __( 'L', 'goldenegg' ),
            'size'      => 36,
            'slug'      => 'large'
        ),
        array(
            'name'      => __( 'XLarge', 'goldenegg' ),
            'shortName' => __( 'XL', 'goldenegg' ),
            'size'      => 48,
            'slug'      => 'xlarge'
        )
    ));
    
	// Custom Color Palette
	add_theme_support( 'disable-custom-colors' ); // disallow user to select any color
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'White', 'goldenegg' ),
			'slug'  => 'white',
			'color'	=> '#fff',
		),
		array(
			'name'  => __( 'Black', 'goldenegg' ),
			'slug'  => 'black',
			'color'	=> '#000',
		),
		array(
			'name'  => __( 'Gray', 'goldenegg' ),
			'slug'  => 'gray',
			'color'	=> '#333',
		),
		array(
			'name'  => __( 'Gray Light', 'goldenegg' ),
			'slug'  => 'gray-light',
			'color'	=> '#eee',
		),
		array(
			'name'  => __( 'Blue', 'goldenegg' ),
			'slug'  => 'blue',
			'color'	=> '#2779AE',
		),
		array(
			'name'  => __( 'Green', 'goldenegg' ),
			'slug'  => 'green',
			'color' => '#547E2A',
		),
		array(
			'name'	=> __( 'Yellow', 'goldenegg' ),
			'slug'	=> 'yellow',
			'color'	=> '#e8c200',
		),
	) );
	
	// Custom Color Gradients
	// disallow user to create new gradients
	add_theme_support( 'disable-custom-gradients' ); 
	add_theme_support( 'editor-gradient-presets', array() );
	
}


/**
 * ACF Radio Color Palette
 *
 * @link https://whiteleydesigns.com/create-a-gutenberg-like-color-picker-with-advanced-custom-fields
 * Dynamically populates 'acf_color' fields with custom color palette
 *
*/
add_filter('acf/load_field/name=acf_color', 'acf_dynamic_colors_load');
function acf_dynamic_colors_load( $field ) {
	
     // get array of colors created from color palette above
     $colors = get_theme_support( 'editor-color-palette' );
     if( ! empty( $colors ) ) {
	     
          // loop over each color and create option
          foreach( $colors[0] as $color ) {
               $field['choices'][ $color['slug'] ] = $color['name'];
          }
     }
     return $field;
}


/**
 * ACF Dynamic Icons
 *
 * Dynamically populates 'acf_icon' fields with SVG icons
 *
*/
add_filter('acf/load_field/name=acf_icon', 'acf_block_icons_load');
function acf_block_icons_load( $field ) {
    $icons = preg_grep('~\.(svg)$~', scandir( get_stylesheet_directory() . '/src/icons' ) );
	
	$icons = array_diff( $icons, array( '..', '.' ) );
	$icons = array_values( $icons );
	if( empty( $icons ) )
		return $icons;
		
	// remove '.svg' from title
	foreach( $icons as $i => $icon ) {
		$icons[ $i ] = substr( $icon, 0, -4 );
	}

    $svg_markup = '<img width="14" height="14" style="margin: 4px 4px 0px 0; float: left;" src="' . get_template_directory_uri() . '/src/icons/';
    //$svg_markup = '<img width="14" height="14" style="margin: 4px 4px 0px 0; float: left;" src="/wp-content/themes/goldenegg/src/icons/';
	if( ! empty( $icons ) ) {
		foreach( $icons as $icon ) {
			// Exclude these icons
			if($icon == "close" or $icon == "menu"):
				continue;
			else:
				$field['choices'][ $icon ] = $svg_markup . $icon . '.svg"> ' . $icon;
			endif;
		}
	}
    return $field;
}


/**
 * Show Reusable Blocks UI in WordPress admin
 * @link https://www.billerickson.net/reusable-blocks-accessible-in-wordpress-admin-area
 */
add_action( 'admin_menu', 'wd_reusable_blocks_admin_menu' );
function wd_reusable_blocks_admin_menu() {
	add_menu_page( 'Reusable Blocks', 'Reusable Blocks', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 32 );
}

