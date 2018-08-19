<?php // TinyMCE Editor Panel


/**
 * Disables tinyMCE security feature for external links
 * rel = "noopener"
 */
//add_filter( 'tiny_mce_before_init',	'tinymce_allow_unsafe_link_target');
function tinymce_allow_unsafe_link_target( $mceInit ) {
	$mceInit['allow_unsafe_link_target']=true;
	return $mceInit;
}


/**
 * Remove Editor Styles
 */
add_filter( 'tiny_mce_before_init', 'egg_mce_hide_styles' );
function egg_mce_hide_styles( $settings ) {
    unset($settings['preview_styles']);
    return $settings;
}


/**
 * Add Custom Editor Styles
 */
add_action( 'admin_init', 'egg_editor_styles' );
function egg_editor_styles() {
	add_editor_style( get_template_directory_uri() . '/assets/css/editor.css' );
}


/**
 * Customize TinyMCE buttons in row 1
 */
add_filter( 'mce_buttons', 'egg_mce_buttons' );
function egg_mce_buttons( $buttons ) {
	$remove = array('formatselect', 'blockquote', 'wp_more');
	return array_diff($buttons, $remove);
}


/**
 * Customize TinyMCE buttons in row 2
 */
add_filter( 'mce_buttons_2', 'egg_mce_buttons_2' );
function egg_mce_buttons_2( $buttons2 ) {
	$remove  = array('strikethrough', 'underline', 'forecolor', 'alignjustify', 'wp_help');
	return array_diff($buttons2, $remove);
}


/**
 * Show Format dropdown
 */
add_filter( 'mce_buttons', 'egg_mce_editor_buttons' );
function egg_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}


/**
 * Add items to Format dropdown
 */
add_filter( 'tiny_mce_before_init', 'egg_mce_formats' );
function egg_mce_formats( $settings ) {
    $settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
	$style_formats = array(
		array(
            'title' => 'Paragraph',
            'format' => 'p'
        ),
        array(
            'title' => 'Headers',
                'items' => array(
                array(
                    'title' => 'Header 1',
                    'format' => 'h1'
                ),
                array(
                    'title' => 'Header 2',
                    'format' => 'h2'
                ),
                array(
                    'title' => 'Header 3',
                    'format' => 'h3'
                ),
                array(
                    'title' => 'Header 4',
                    'format' => 'h4'
                ),
                array(
                    'title' => 'Header 5',
                    'format' => 'h5'
                ),
                array(
                    'title' => 'Header 6',
                    'format' => 'h6'
                )
            )
        ),
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button'
        ),
        array(
            'title' => 'No Wrap',
            'selector' => 'span',
            'classes' => 'nowrap'
        ),
        array(
            'title' => 'Blockquote',
            'format' => 'blockquote'
        ),
        array(
            'title' => 'small',
            'selector' => 'p',
            'classes' => 'small'
        )
    );
    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
}
