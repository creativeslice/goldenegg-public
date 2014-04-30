<?php // include function files from assets directory

require_once( 'includes/function-admin.php' );
require_once( 'includes/function-comments.php' );
require_once( 'includes/function-cleanup.php' );
require_once( 'includes/function-enqueue.php' );
require_once( 'includes/function-post-types.php' );
require_once( 'includes/function-theme-support.php' );
require_once( 'includes/function-additional.php' );

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

?>