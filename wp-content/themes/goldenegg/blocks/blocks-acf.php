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



