<?php

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 * 
 */
add_action( 'template_redirect', 'egg_nice_search_redirect' );
function egg_nice_search_redirect() {
	global $wp_rewrite;
	if (! isset($wp_rewrite) || ! is_object($wp_rewrite) || ! $wp_rewrite->using_permalinks() ) {
		return;
	}

	$search_base = $wp_rewrite->search_base;
	if ( is_search() && ! is_admin() && false === strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") ) {
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}