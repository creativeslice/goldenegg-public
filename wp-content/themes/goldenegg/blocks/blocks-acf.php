<?php
/**
 * ACF Gutenberg Blocks
 *
 * Categories: common, formatting, layout, widgets, embed
 * Modes: preview, edit, auto
 * Align: left, center, right, wide, full
 * Align Text: left, center, right
 * Align Content: top, center, bottom (top left, etc available with matrix)
 * Dashicons: https://developer.wordpress.org/resource/dashicons/
 * ACF Settings: https://www.advancedcustomfields.com/resources/acf_register_block/
 * Gutenberg Supports: https://developer.wordpress.org/block-editor/developers/block-api/block-supports/
 *
*/


// HEADER WITH Image/Icon/Text
add_action('acf/init', 'acf_image_icon_text_block');
function acf_image_icon_text_block() {
	if( function_exists('acf_register_block') ) {
		acf_register_block(array(
			'name'				=> 'image_icon_text',
			'title'				=> __('Text with Image or Icon'),
			'description'		=> __('A block for displaying text next to an image or icon.'),
			'render_template'	=> 'blocks/image-icon-text/image-icon-text.php',
            'supports'          => [
	            'align' => false,
				'jsx' => true
			],
			'category'			=> 'acf-blocks',
			'icon'				=> 'align-pull-left',
			'keywords'			=> [ 'icon', 'content' ],
		));
	}
}

// CARDS
add_action('acf/init', 'acf_cards_block');
function acf_cards_block() {
	if( function_exists('acf_register_block') ) {
		acf_register_block(array(
			'name'				=> 'cards',
			'title'				=> __('Cards'),
			'description'		=> __('A block for displaying cards.'),
			'render_template'	=> 'blocks/cards/cards.php',
            'mode'              => 'edit',
			'supports'          => [
	            'align' => '',
			],
			'category'			=> 'acf-blocks',
			'icon'				=> 'format-aside',
			'keywords'			=> array( 'cards, card' ),
		));
	}
}

// EXPANDING TEXT
add_action('acf/init', 'acf_expanding_text_block');
function acf_expanding_text_block() {
	if( function_exists('acf_register_block') ) {
		acf_register_block(array(
			'name'				=> 'expanding_text',
			'title'				=> __('Expanding Text'),
			'description'		=> __('A block for displaying text in an accordion.'),
			'render_template'	=> 'blocks/expanding-text/expanding-text.php',
            'mode'              => false,
            'supports'          => [
	            'align' => false,
			],
			'category'			=> 'acf-blocks',
			'icon'				=> 'sort',
			'keywords'			=> array( 'faq, accordion, expanding text' ),
		));
	}
}



/**
 * Simplify ACF WYSIWYG bar
 */
add_filter( 'acf/fields/wysiwyg/toolbars', 'acf_toolbars' );
function acf_toolbars( $toolbars ) {
	$toolbars['Very Simple' ] = array();
	$toolbars['Very Simple' ][1] = array('bold', 'italic' );
	return $toolbars;
}


/**
 * Only allow ACF updates on development server
 *
 * set in wp-config.php
 * define( 'WP_ENVIRONMENT_TYPE', 'development' );
 */
switch ( wp_get_environment_type() ) {
	case 'staging': case 'production':
		add_filter( 'acf/settings/show_admin', '__return_false' );
		break;
	case 'development': default:
		break;
}


// CTA Block
/*
add_action('acf/init', 'acf_cta_block');
function acf_cta_block() {
	if( function_exists('acf_register_block') ) {
		acf_register_block(array(
			'name'				=> 'cta_block',
			'title'				=> __('CTA Block'),
			'description'		=> __('A call to action block.'),
			'render_template'	=> 'blocks/cta-block/cta-block.php',
            'mode'              => 'edit',
			'category'			=> 'layout',
			'icon'				=> 'megaphone',
			'keywords'			=> array( 'call to action', 'cta' ),
			'align'           => 'wide',
			'supports'          => [
				'align'  => array( 'wide', 'full' ),
				'anchor' => true,
			],
			'example'         => array(
				'attributes' => array(
					'data' => array(
						'title'       => esc_html__( 'Call To Action Title', 'wds-acf-blocks' ),
						'text'        => esc_html__( 'Call To Action Text', 'wds-acf-blocks' ),
						'button_link' => array(
							'title' => esc_html__( 'Learn More', 'wds-acf-blocks' ),
							'url'   => '#',
						),
					),
				),
			),
		));
	}
}
*/

