<?php // FUNCTIONS

// Core WordPress Functions
include_once get_stylesheet_directory() . '/inc/admin-bar.php';
include_once get_stylesheet_directory() . '/inc/admin-dashboard.php';
include_once get_stylesheet_directory() . '/inc/admin-login.php';
include_once get_stylesheet_directory() . '/inc/admin-wp-cleanup.php';

include_once get_stylesheet_directory() . '/inc/disable-comments.php';

include_once get_stylesheet_directory() . '/inc/enqueue.php';

//include_once get_stylesheet_directory() . '/inc/gutenberg.php';
//include_once get_stylesheet_directory() . '/inc/plugins-cleanup.php';


// Theme Functions
//include_once get_stylesheet_directory() . '/inc/theme-custom-post-types.php'; // Or use CPT plugin
include_once get_stylesheet_directory() . '/inc/theme-support.php';

// Partial Functions
include_once get_stylesheet_directory() . '/partials/search/search-functions.php';

// Block Functions
//include_once get_stylesheet_directory() . '/blocks/blocks-acf.php'; // Custom ACF Gutenberg Blocks





// BLOCK TEMPLATE TEST
/*
function register_block_template() {
	$block_template = [
      [
        'core/group',
        [],
        [
          [
            'core/heading',
            [
              'level'   => 2,
              'content' => 'Example Block Template',
            ]
          ],
          [
            'core/paragraph',
            [
              'content' => 'Lorem ipsum dolor sit amet labore cras venenatis.',
            ]
          ],
          [
            'core/columns',
            [],
          ],
        ]
      ]
    ];

	$post_type_object                = get_post_type_object( 'post' );
	$post_type_object->template      = $block_template;
    $post_type_object->template_lock = 'all';
}
add_action( 'init', 'register_block_template' );
*/




/**
 * SVG Icons with version number for cache busting.
 *
 * replaces: <svg><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#close"></use></svg>
 * with: <svg><use href="<?php echo get_svg('globe'); ?>"></use></svg>
 *
 */
define( 'SVG_LAST_MTIME', filemtime( realpath( __DIR__ ) . '/assets/icons/icons.svg' ) );
function get_svg( $which ) {
	$version = SVG_LAST_MTIME;
	return get_template_directory_uri() . '/assets/icons/icons.svg?' . $version . '#' . $which;
}


/**
 * ACF options page for site-wide fields.
 * @link https://www.advancedcustomfields.com/resources/options-page/
 */
/*
if ( function_exists( 'acf_add_options_page' ) ) {

	// Theme settings
	acf_add_options_page([
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-options',
		'parent_slug' 	=> 'themes.php',
		'capability' 	=> 'add_users', // Admin only
		'icon_url'     	=> 'dashicons-image-filter',
		'redirect'		=> false
	] );

	// Used by partials/notices
	acf_add_options_page(array(
		'title'    		=> 'Notices',
		'parent_slug' 	=> 'themes.php',
		'capability' 	=> 'add_users', // Admin only
		'icon_url' 		=> 'dashicons-megaphone', // https://developer.wordpress.org/resource/dashicons/#megaphone
	));
}
*/
