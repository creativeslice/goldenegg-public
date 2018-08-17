<?php

/**
 * Update TinyMCE
 */
add_action( 'init', 'egg_tinymce' );
function egg_tinymce() {
	add_filter( 'mce_buttons',				'egg_mce_buttons' );
	add_filter( 'mce_buttons_2',			'egg_mce_buttons_2' );
	//add_filter( 'tiny_mce_before_init', 	'egg_mce_show_row_2' );
	//add_filter( 'tiny_mce_before_init',		'tinymce_allow_unsafe_link_target');
	add_filter( 'tiny_mce_before_init', 	'egg_mce_before_init' );
}

add_filter( 'mce_buttons', 'fb_mce_editor_buttons' );
function fb_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

/**
 * Disables a tinyMCE security feature: rel = noopener noreferrer
 */
function tinymce_allow_unsafe_link_target( $mceInit ) {
	$mceInit['allow_unsafe_link_target']=true;
	return $mceInit;
}



/**
 * Editor Styles
 */
 add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );
function fb_mce_before_init( $settings ) {
    // unset the preview styles
    unset($settings['preview_styles']);
    return $settings;
}


add_action( 'admin_init', 'egg_editor_styles' );
function egg_editor_styles() {
	add_editor_style( get_template_directory_uri() . '/assets/css/editor.css' );
}






/**
 * Customize TinyMCE buttons in row 1
 *
 * @return	array Modified buttons in row 1
 */
function egg_mce_buttons( $buttons ) {
	$remove = array('formatselect', 'blockquote', 'wp_more');
	//print_r($buttons);
	return array_diff($buttons, $remove);
}


/**
 * Customize TinyMCE buttons in row 2
 *
 * @return	array Modified buttons in row 2
 */
function egg_mce_buttons_2( $buttons2 ) {
	// Remove items
	$remove  = array('strikethrough', 'underline', 'forecolor', 'alignjustify', 'wp_help');
	return array_diff($buttons2, $remove);
}


/**
 * Sets second mce toolbar view to 'show'
 */
function egg_mce_show_row_2( $in ) {
	$in['wordpress_adv_hidden'] = FALSE;
	return $in;
}


/**
 * Callback function to filter the MCE settings
 *
 * @return    array Modified settings
 */
function egg_mce_before_init( $settings ) {
    $settings['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5; Superscript=superscript; Subscript=subscript; Quote=blockquote';
    $settings['style_formats'] = json_encode([
        [
            'title'    => 'Paragraph',
            'format' 	=> 'p',
        ], [
	        'title'    => 'Header 1',
            'format' 	=> 'h1',
        ], [
	        'title'    => 'Header 2',
            'format' 	=> 'h2',
        ], [
	        'title'    => 'Header 3',
            'format' 	=> 'h3',
        ], [
	        'title'    => 'Header 4',
            'format' 	=> 'h4',
        ], [
	        'title'    => 'Header 5',
            'format' 	=> 'h5',
        ], [
	        'title'    => 'No Wrap',
            'inline' 	=> 'span',
            'classes'  => 'nowrap',
        ], [
            'title'    => 'Button',
            'selector' => 'a',
            'classes'  => 'button',
        ], [
            'title'    => 'Big Button',
            'selector' => 'a',
            'classes'  => 'buttonBig',
        ], [
            'title'    => 'Small',
            'selector' => 'p',
            'classes'  => 'small',
        ],
    ]);
    return $settings;
}


