<?php
/**
 * Custom Post Types
 */

/**
 * Flush rewrite rules for custom post types
 *
 * @return	void
 */
add_action( 'after_switch_theme', 'egg_flush_rewrite_rules' );
function egg_flush_rewrite_rules()
{
	flush_rewrite_rules();
}

/**
 * Examples
 *
 * @return	void
 */
add_action( 'init', 'custom_register_post_type');
function custom_register_post_type()
{ 
	register_post_type( 'custom_type',
		array( 'labels' => 
			array(
				'name'               => 'Custom Types',
				'singular_name'      => 'Custom Post',
				'all_items'          => 'All Custom Posts',
				'add_new'            => 'Add New',
				'add_new_item'       => 'Add New Custom Type',
				'edit'               => 'Edit',
				'edit_item'          => 'Edit Post Types',
				'new_item'           => 'New Post Type',
				'view_item'          => 'View Post Type',
				'search_items'       => 'Search Post Type',
				'not_found'          => 'Nothing found in the Database.',
				'not_found_in_trash' => 'Nothing found in Trash',
				'parent_item_colon'  => ''
			),
			'description'         => 'This is the example custom post type',
			'public'              => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'query_var'           => true,
			'menu_position'       => 8,
			'menu_icon'           => get_stylesheet_directory_uri() . '/assets/img/custom-post-icon.png',
			'rewrite'	          => array( 'slug' => 'custom_type', 'with_front' => false ),
			'has_archive'         => 'custom_type',
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'revisions')
		)
	);

	/* this adds your post categories to your custom post type */
	register_taxonomy_for_object_type( 'category', 'custom_type' );
	/* this adds your post tags to your custom post type */
	register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
}

	/* Custom Taxonomy (Category) */
	register_taxonomy( 'custom_cat',
		array('custom_type'), // if you change the name of register_post_type( 'custom_type', then you have to change this
		array('hierarchical' => true, // if this is true, it acts like categories
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

	/* Custom Taxonomy (Tag) */
	register_taxonomy( 'custom_tag',
		array('custom_type'), // if you change the name of register_post_type( 'custom_type', then you have to change this
		array('hierarchical' => false, // if this is false, it acts like tags
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
	
	// let's create the function for Events
add_action( 'init', 'event_post_type');
function event_post_type() { 
	register_post_type( 'event',
		array( 'labels' => 
			array(
				'name' => 'Events',
				'singular_name' => 'Event',
				'all_items' => 'All Events',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Event',
				'edit' => 'Edit',
				'edit_item' => 'Edit Event',
				'new_item' => 'New Event',
				'view_item' => 'View Event',
				'search_items' => 'Search Event',
				'not_found' => 'Nothing found in the Database.',
				'not_found_in_trash' => 'Nothing found in Trash',
				'parent_item_colon' => ''
			),
			'description' => 'Events custom post type',
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 3,
			'menu_icon' => get_stylesheet_directory_uri() . '/assets/img/event-icon.png',
			'rewrite'	=> array( 'slug' => 'event', 'with_front' => false ),
			// 'has_archive' => 'events',
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')
		)
	);
}


// custom category for events
register_taxonomy( 'event_cat', 
	array('event'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	array('hierarchical' => true, /* if this is true, it acts like categories */
		'labels' => array(
			'name' => 'Event Categories',
			'singular_name' => 'Event Category',
			'search_items' =>  'Search Event Categories',
			'all_items' => 'All Event Categories',
			'parent_item' => 'Parent Event Category',
			'parent_item_colon' => 'Parent Event Category:',
			'edit_item' => 'Edit Event Category',
			'update_item' => 'Update Event Category',
			'add_new_item' => 'Add New Event Category',
			'new_item_name' => 'New Event Category Name',
		),
		'show_admin_column' => true, 
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'event-cat' ),
	)
);
