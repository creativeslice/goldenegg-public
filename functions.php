<?php // include function files from assets directory

require_once( 'assets/function-admin.php' );
require_once( 'assets/function-comments.php' );
require_once( 'assets/function-cleanup.php' );
require_once( 'assets/function-enqueue.php' );
require_once( 'assets/function-post-types.php' );
require_once( 'assets/function-theme-support.php' );
require_once( 'assets/function-additional.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );

  // adding sidebars to Wordpress
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );
  
  // launching this stuff after theme setup
  bones_theme_support();

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => 'Sidebar 1',
		'description' => 'The first (primary) sidebar.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}


/* DON'T DELETE THIS CLOSING TAG */ ?>
