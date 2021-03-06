<?php // TinyMCE Editor Panel

/**
 * Simple ACF WYSIWYG bar
 */
//add_filter( 'acf/fields/wysiwyg/toolbars', 'my_toolbars' );
function my_toolbars( $toolbars ) {
	$toolbars['Very Simple' ] = array();
	$toolbars['Very Simple' ][1] = array('bold', 'italic' );
	return $toolbars;
}


/**
 * Disables tinyMCE security feature for external links
 * rel = "noopener"
 */
//add_filter( 'tiny_mce_before_init', 'tinymce_allow_unsafe_link_target');
function tinymce_allow_unsafe_link_target( $mceInit ) {
	$mceInit['allow_unsafe_link_target']=true;
	return $mceInit;
}


/**
 * Remove Editor Styles
 */
//add_filter( 'tiny_mce_before_init', 'egg_mce_hide_styles' );
function egg_mce_hide_styles( $settings ) {
    unset($settings['preview_styles']);
    return $settings;
}


/**
 * Add Custom Editor Styles
 */
add_action( 'admin_init', 'egg_editor_styles' );
function egg_editor_styles() {
	add_editor_style( get_template_directory_uri() . '/assets/css/editor.css?20210227' );
}


/*
 * Modify TinyMCE editor to remove H1.
 */
add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
function tiny_mce_remove_unused_formats($init) {
	// Add block format elements you want to show in dropdown
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Blockquote=blockquote;Superscript=superscript;Subscript=subscript;';
	return $init;
}


/**
 * Customize TinyMCE buttons in row 1
 */
add_filter( 'mce_buttons', 'egg_mce_buttons' );
function egg_mce_buttons( $buttons ) {
	$remove = array('blockquote', 'wp_more'); // formatselect
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
            'title' => 'small',
            'selector' => 'p',
            'classes' => 'small'
        )
    );
    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
}
