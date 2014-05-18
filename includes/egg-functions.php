<?php
/**
 * Adds some custom functions and actions to use those functions
 */
add_action( 'init', 'egg_functions' );
function egg_functions()
{
	// actions
	add_action( 'egg/related_posts',      'egg_related_posts' );
	add_action( 'egg/page_navi',          'egg_page_navi' );
}

/**
 * Related Posts
 *
 * Usage: do_action('egg/related_posts');
 *
 * Based on Bones by Eddie Machado
 *
 * @return	void
 */
function egg_related_posts()
{
	global $post;

	echo '<ul id="bones-related-posts">';
	$tags = wp_get_post_tags( $post->ID );
	if ( $tags )
	{
		foreach( $tags as $tag )
		{
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag'          => $tag_arr,
			'numberposts'  => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if ( $related_posts )
		{
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach;
		}
		else
		{
			echo '<li class="no_related_post">No Related Posts Yet!</li>';
		}
	}
	wp_reset_postdata();
	echo '</ul>';
}

/**
 * Page Navi
 *
 * Usage: do_action('egg/page_navi');
 *
 * Based on Bones by Eddie Machado
 *
 * @return	void
 */
function egg_page_navi()
{
	global $wp_query;

	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 ) return;

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