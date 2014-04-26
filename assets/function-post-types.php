<?php

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function custom_post_example() { 
	register_post_type( 'custom_type',
		array( 'labels' => 
			array(
				'name' => 'Custom Types',
				'singular_name' => 'Custom Post',
				'all_items' => 'All Custom Posts',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Custom Type',
				'edit' => 'Edit',
				'edit_item' => 'Edit Post Types',
				'new_item' => 'New Post Type',
				'view_item' => 'View Post Type',
				'search_items' => 'Search Post Type',
				'not_found' => 'Nothing found in the Database.',
				'not_found_in_trash' => 'Nothing found in Trash',
				'parent_item_colon' => ''
			),
			'description' => 'This is the example custom post type',
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8,
			'menu_icon' => get_stylesheet_directory_uri() . '/images/custom-post-icon.png',
			'rewrite'	=> array( 'slug' => 'custom_type', 'with_front' => false ),
			'has_archive' => 'custom_type',
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		)
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	register_taxonomy_for_object_type( 'category', 'custom_type' );
	/* this adds your post tags to your custom post type */
	register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_example');
	
	
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'custom_cat', 
		array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true, /* if this is true, it acts like categories */
			'labels' => array(
				'name' => 'Custom Categories',
				'singular_name' => 'Custom Category',
				'search_items' =>  'Search Custom Categories',
				'all_items' => 'All Custom Categories',
				'parent_item' => 'Parent Custom Category',
				'parent_item_colon' => 'Parent Custom Category:',
				'edit_item' => 'Edit Custom Category',
				'update_item' => 'Update Custom Category',
				'add_new_item' => 'Add New Custom Category',
				'new_item_name' => 'New Custom Category Name',
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'custom-slug' ),
		)
	);
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'custom_tag', 
		array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false, /* if this is false, it acts like tags */
			'labels' => array(
				'name' => 'Custom Tags',
				'singular_name' => 'Custom Tag',
				'search_items' =>  'Search Custom Tags',
				'all_items' => 'All Custom Tags',
				'parent_item' => 'Parent Custom Tag',
				'parent_item_colon' => 'Parent Custom Tag:',
				'edit_item' => 'Edit Custom Tag',
				'update_item' => 'Update Custom Tag',
				'add_new_item' => 'Add New Custom Tag',
				'new_item_name' => 'New Custom Tag Name',
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
		)
	);	

?>
