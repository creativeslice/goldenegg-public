<?php

/**
 * Flush rewrite rules for custom post types
 */
add_action( 'after_switch_theme', 'egg_flush_rewrite_rules' );
function egg_flush_rewrite_rules() {
	flush_rewrite_rules();
}


/**
 * Custom Post Type Example
 */
add_action( 'init', 'custom_register_post_type');
function custom_register_post_type() { 
	register_post_type( 'custom_type', // use singular name here: 'custom_type' NOT 'custom_types'
		array( 'labels' => 
			array(
				'name'					=> 'Types',
				'singular_name'			=> 'Type',
				'all_items'				=> 'All Types',
				'add_new'				=> 'Add New',
				'add_new_item'			=> 'Add New Type',
				'edit'					=> 'Edit',
				'edit_item'				=> 'Edit Type',
				'new_item'				=> 'New Type',
				'view_item'				=> 'View Type',
				'search_items'			=> 'Search Type',
				'not_found'				=> 'Nothing found in the Database.',
				'not_found_in_trash'	=> 'Nothing found in Trash',
				'parent_item_colon'		=> ''
			),
			'description'        	=> 'Custom post type description',
			'public'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'query_var'				=> true,
			'menu_position'			=> 8,
			'menu_icon'				=> 'dashicons-format-aside', /* https://developer.wordpress.org/resource/dashicons/#menu */
			'rewrite'				=> array( 'slug' => 'custom_type', 'with_front' => false ),
			'has_archive'			=> 'custom_type',
			'capability_type'		=> 'post',
			'hierarchical'			=> false,
			'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes')
		)
	);

	/* Adds default post categories to custom post type */
	register_taxonomy_for_object_type( 'category', 'custom_type' );
	/* Adds default post tags to custom post type */
	register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
	
}

/* Custom Taxonomy (Category) */
register_taxonomy( 'custom_cat',
	array('custom_type'), // match name of register_post_type( 'custom_type'
	array('hierarchical' => true, // if this is true, it acts like categories
		'labels' => array(
			'name'					=> 'Categories',
			'singular_name'			=> 'Category',
			'search_items'			=> 'Search Categories',
			'all_items'				=> 'All Categories',
			'parent_item'			=> 'Parent Category',
			'parent_item_colon'		=> 'Parent Category:',
			'edit_item'				=> 'Edit Category',
			'update_item'			=> 'Update Category',
			'add_new_item'			=> 'Add New Category',
			'new_item_name'			=> 'New Category Name',
		),
		'show_admin_column' 	=> true,
		'show_ui' 				=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array( 'slug' => 'custom-slug' ),
	)
);

/* Custom Taxonomy (Tag) */
register_taxonomy( 'custom_tag',
	array('custom_type'), // match name of register_post_type( 'custom_type'
	array('hierarchical' => false, // if this is false, it acts like tags
		'labels' => array(
			'name' 					=> 'Tags',
			'singular_name'			=> 'Tag',
			'search_items'			=> 'Search Tags',
			'all_items'				=> 'All Tags',
			'parent_item'			=> 'Parent Tag',
			'parent_item_colon'		=> 'Parent Tag:',
			'edit_item'				=> 'Edit Tag',
			'update_item'			=> 'Update Tag',
			'add_new_item'			=> 'Add New Tag',
			'new_item_name'			=> 'New Tag Name',
		),
		'show_admin_column' 	=> true,
		'show_ui' 				=> true,
		'query_var' 			=> true,
	)
);
