<?php // Enqueue styles and scripts

/**
 * Load Theme CSS
 */
function egg_styles() {
	
	// Register theme stylesheet.
	$themeStyle = '/assets/css/style.css';
	wp_register_style('egg-style', 
		get_stylesheet_directory_uri() . $themeStyle . '?v=' . filemtime( get_template_directory() . $themeStyle ), 
		array(), '', 'all');
	
	// Add styles inline.
	wp_add_inline_style( 'egg-style', egg_get_font_face_styles() );
		
	// Enqueue theme stylesheet.
	//wp_style_add_data( 'egg-style', 'path', get_template_directory() . '/style.css' );
	wp_enqueue_style('egg-style');
}
add_action( 'wp_enqueue_scripts', 'egg_styles', 999 );


function egg_editor_styles() {
	
	add_editor_style( array( '/assets/css/editor.css' ) );
	wp_add_inline_style( 'wp-block-library', egg_get_font_face_styles() );
}
add_action( 'admin_init', 'egg_editor_styles' );
	
	
	

/*function egg_editor_styles() {
	add_editor_style( array( 
		'/assets/css/editor.css',
		egg_get_font_face_styles()
	) );

}
add_action( 'admin_init', 'egg_editor_styles' );
*/

// Google Fonts
function egg_get_font_face_styles() {
	return "
	@font-face{
		font-family: 'Inter';
		font-weight: 400;
		font-style: normal;
		src: url('" . get_theme_file_uri( 'assets/fonts/inter/Inter-Regular.woff2' ) . "') format('woff2');
	}
	@font-face{
		font-family: 'Inter';
		font-weight: 400;
		font-style: italic;
		src: url('" . get_theme_file_uri( 'assets/fonts/inter/Inter-Italic.woff2' ) . "') format('woff2');
	}
	@font-face{
		font-family: 'Inter';
		font-weight: 600;
		font-style: normal;
		src: url('" . get_theme_file_uri( 'assets/fonts/inter/Inter-SemiBold.woff2' ) . "') format('woff2');
	}
	@font-face{
		font-family: 'Inter';
		font-weight: 700;
		font-style: normal;
		src: url('" . get_theme_file_uri( 'assets/fonts/inter/Inter-Bold.woff2' ) . "') format('woff2');
	}
	@font-face{
		font-family: 'Inter';
		font-weight: 900;
		font-style: normal;
		src: url('" . get_theme_file_uri( 'assets/fonts/inter/Inter-Black.woff2' ) . "') format('woff2');
	}
	@font-face{
		font-family: 'Source Serif Pro';
		font-weight: 200 900;
		font-style: normal;
		font-stretch: normal;
		src: url('" . get_theme_file_uri( 'assets/fonts/source-serif-pro/SourceSerif4Variable-Roman.ttf.woff2' ) . "') format('woff2');
	}
	@font-face{
		font-family: 'Source Serif Pro';
		font-weight: 200 900;
		font-style: italic;
		font-stretch: normal;
		src: url('" . get_theme_file_uri( 'assets/fonts/source-serif-pro/SourceSerif4Variable-Italic.ttf.woff2' ) . "') format('woff2');
	}
	";
}




/**
 * Load Theme JavaScript
 */
function egg_scripts() {
	$themeJS = '/assets/js/scripts.js';
	wp_register_script( 'egg-theme', 
		get_stylesheet_directory_uri() . $themeJS . '?' . filemtime( get_template_directory() . $themeJS ), 
		array( 'jquery' ), '', false ); // set to true to load scripts in footer
	wp_enqueue_script( 'egg-theme');
}
add_action( 'wp_enqueue_scripts', 'egg_scripts', 999 );


/* GUTENBERG ADMIN
--------------------------------------------- */

// Admin CSS - outside block editor
/*
add_action( 'admin_enqueue_scripts', 'egg_admin_style' );
function egg_admin_style() {
	$adminStyle = '/assets/css/admin.css';
	wp_enqueue_style( 'admin-styles', 
    	get_stylesheet_directory_uri() . $adminStyle . '?v=' . filemtime( get_template_directory() . $adminStyle ) 
    );
}
*/


// Editor & Admin CSS - admin & block editor
/*
add_action( 'enqueue_block_editor_assets', 'egg_block_editor_scripts' );
function egg_block_editor_scripts() {

    $editorStyle = '/assets/css/editor.css';
	// wp-block-editor 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n'
	wp_enqueue_style( 'editor-styles', 
		get_theme_file_uri( $editorStyle ), 
		[ 'wp-block-editor' ], 
		filemtime( get_template_directory() . $editorStyle ), 'all' 
	);
	
	// Gutenberg Customization Script	
	wp_enqueue_script('wd-editor', get_stylesheet_directory_uri() . '/includes/core-block-overrides.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_stylesheet_directory() . '/includes/core-block-overrides.js' ), true );

}
*/


// Block Editor CSS - block editor inline styles (DO NOT USE: cache clearing issues)
//add_editor_style( 'assets/css/editor.css' );
//add_theme_support( 'editor-styles' );


/**
 * Remove jQuery Migrate
 */
/*
add_filter( 'wp_default_scripts', 'egg_dequeue_jquery_migrate' );
function egg_dequeue_jquery_migrate( &$scripts ) {
	if (! is_admin() ) {
		$scripts->remove( 'jquery');
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}
*/
