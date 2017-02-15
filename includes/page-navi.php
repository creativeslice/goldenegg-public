<?php
/**
 * Adds custom page navigation
 */


/**
 * Page Navi
 *
 * Usage: do_action('egg/page_navi');
 *
 * Based on Bones by Eddie Machado
 *
 */
add_action( 'egg/page_navi', 'egg_page_navi' );
function egg_page_navi() {
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