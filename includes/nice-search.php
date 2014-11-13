<?php
/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 * 
 */
add_action( 'template_redirect', 'egg_nice_search_redirect' );
function egg_nice_search_redirect()
{
	global $wp_rewrite;
	if (! isset($wp_rewrite) || ! is_object($wp_rewrite) || ! $wp_rewrite->using_permalinks() )
	{
		return;
	}

	$search_base = $wp_rewrite->search_base;
	if ( is_search() && ! is_admin() && false === strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") )
	{
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}


/**
 * Relevanssi Search Plugin with Custom Fields
 *
 * Requires in Relevanss Settings:
 *    (1) Selecting Post Types to Index
 *    (2) Custom Fields to Index = 'visible'
 *    (3) Save and Index
 */
// add_filter('relevanssi_excerpt_content', 'excerpt_function', 10, 3);

/**
 * Modifies the Relevanssi results
 *
 * @return [string] modified content of the resulting post and its custom fields
 */

// Get Relevanssi to display excerpts from your custom fields
add_filter('relevanssi_excerpt_content', 'excerpt_function', 10, 3);

function excerpt_function($content, $post, $query) {
	global $wpdb; $fields = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM $wpdb->postmeta");

	foreach($fields as $key => $field){ 
		$field_value = get_post_meta($post->ID, $field, TRUE); $content .= ' ' . ( is_array($field_value) ? implode(' ', $field_value) : $field_value ); 
	}
	
	// Remove random terms from showing in the search. These are related to the names of the ACF field names
	$wordlist = array('acf_id_1', 'acf_id_2', 'acf_id_3', 'acf_id_4');
	foreach ($wordlist as &$word) {
	    $word = '/\b' . preg_quote($word, '/') . '\b/';
	}
	
	$content = preg_replace($wordlist, '', $content);
	
	// The excerpt ready with bits removed from it
	return $content; 
}