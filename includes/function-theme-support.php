<?php

/*********************
THEME SUPPORT
*********************/

function bones_support() {

  // adding sidebars to Wordpress
  add_action( 'widgets_init', 'bones_register_sidebars' );
  
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  
  // launching this stuff after theme setup
  bones_theme_support();

}

add_action( 'after_setup_theme', 'bones_support' );



/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

// Select new images sizes from media manager
add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}


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

/*********************
Adding WordPress Functions & Theme Support
*********************/
function bones_theme_support() {

	// Featured Image
	// add_theme_support( 'post-thumbnails', array( 'post', 'press', 'calendar' ) ); // Posts, Press & Calendar

	// default thumb size
	// set_post_thumbnail_size(120, 120, true);

	// This feature enables post and comment RSS feed links to head
	// add_theme_support('automatic-feed-links');
	
	// Enable support for HTML5 markup.
	add_theme_support( 'html5', 
		array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
			'caption'
		)
	);
			
	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// registering menus
	register_nav_menus(
		array(
			'main-nav' => 'The Main Menu',		// main nav in header
			'footer-links' => 'Footer Links',	// secondary nav in footer
		)
	);
}


/*********************
A BETTER TITLE (if not using ACF)
*********************/

function rw_title( $title, $sep, $seplocation ) {
	global $page, $paged;
	
	// Don't affect in feeds.
	if ( is_feed() ) return $title;
	
	// Add the blog's name
	if ( 'right' == $seplocation ) {
		$title .= get_bloginfo( 'name' );
	} else {
		$title = get_bloginfo( 'name' ) . $title;
	}
	
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " {$sep} {$site_description}";
	}
	
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
	}
	
	return $title;
}


/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'bonestheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_postdata();
	echo '</ul>';
}


/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function bones_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
}

?>