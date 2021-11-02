<?php // Gutenberg Functions

/**
 * Limit Default Gutenberg Block Types
 * ONLY allow the blocks specified below
 */
/*
add_filter( 'allowed_block_types', 'egg_allowed_block_types' );
function egg_allowed_block_types( $allowed_blocks ) {
	return array(
		'core/heading',
		'core/paragraph',
		'core/image',
		'core/freeform', // Classic Editor Block
		'core/list',
		'core/file',
		'core/code',
		//'core/blockquote',
		'core/pullquote',
		'core/table',
		'core/cover',
		//'core/video',
		'core/buttons',
		'core/button',
		'core/columns',
		'core/group',
		'core/media-text',
		//'core/spacer',
		'core/separator',
		'core/embed',
		'core/gallery',
		//'core/query-loop',
		'core/block', // reusable blocks
		'core/template', // templates

		'gravityforms/form', // PLUGIN: Gravity Forms
		//'ht/block-toc', // PLUGIN: Heroic Table of Contents

		'acf/icon-block', // START ACF blocks 
		'acf/half-block',
		'acf/cards',
		'acf/expanding-text',
		'acf/hero'
	);
}
*/


/**
 * Remove Embed Scripts & Gutenberg Styles
 */
/*
add_action( 'wp_enqueue_scripts', 'egg_wp_enqueue_scripts' );
function egg_wp_enqueue_scripts() {
	wp_deregister_script( 'wp-embed' ); // embed scripts
	//wp_dequeue_style( 'wp-block-library' ); // gutenberg block styles
}
*/


/**
 * Disabling the default block patterns
 */
//remove_theme_support( 'core-block-patterns' );


/**
 * Show Reusable Blocks UI in WordPress admin
 * @link https://www.billerickson.net/reusable-blocks-accessible-in-wordpress-admin-area
 */
add_action( 'admin_menu', 'wd_reusable_blocks_admin_menu' );
function wd_reusable_blocks_admin_menu() {
	add_menu_page( 'Reusable Blocks', 'Reusable Blocks', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 32 );
}
