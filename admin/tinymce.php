<?php
/**
 * Update TinyMCE
 *
 * @return	void
 */

// actions
add_action( 'init', 'egg_tinymce' );

// filters
add_filter( 'tiny_mce_before_init', 'egg_mce_show_buttons_2' );

function egg_tinymce()
{
	// filters
	add_filter( 'mce_buttons',                'egg_mce_buttons' );
	add_filter( 'mce_buttons_2',              'egg_mce_buttons_2' );
	add_filter( 'tiny_mce_before_init',       'egg_tiny_mce_before_init' );
}

/**
 * Customize TinyMCE buttons in row 1
 *
 * @return	array Modified buttons in row 1
 */
function egg_mce_buttons( $buttons )
{
	$remove = array('strikethrough', 'wp_more');
	return array_diff($buttons, $remove);
}

/**
 * Customize TinyMCE buttons in row 2
 *
 * @return	array Modified buttons in row 2
 */
function egg_mce_buttons_2( $buttons )
{
	// Remove items
	$remove  = array('styleselect', 'underline', 'forecolor', 'alignjustify', 'pastetext', 'removeformat', 'wp_help');
	return array_diff($buttons, $remove);
}

/**
 * Callback function to filter the MCE settings
 *
 * @return	array Modified settings
 */
function egg_tiny_mce_before_init( $settings )
{
	// Insert the array, JSON ENCODED, into 'style_formats'
	$settings['block_formats'] = "Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5";
	return $settings;
}
function egg_mce_show_buttons_2( $in ) {
	$in['wordpress_adv_hidden'] = FALSE;
	return $in;
}