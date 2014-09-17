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
function excerpt_function($content, $post, $query){
    $relevanssi_index_post_types = list_searcheable_acf();
    if(!empty($relevanssi_index_post_types)){
        $meta_values = '';
        foreach($relevanssi_index_post_types AS $custom_post_type){ 
            $meta_value = get_post_meta( $post->ID, $custom_post_type, true);
            // CreativeSlice Custom: the returned content only includes fields where the search term exists (includes post_content)
            if(!empty($meta_value) && strpos($meta_value, $query) ){
                $meta_values .= $meta_value.' ';
            }
        }
    }
    if(!empty($meta_values)){
        $content .= preg_replace("/\n\r|\r\n|\n|\r/", " ", $meta_values);
    }
    return $content;
}


/**
 * [list_searcheable_acf generates array of all custom fields]
 * @return [array] [list of custom fields]
 */
function list_searcheable_acf(){
	global $wpdb;
	$sql= "select distinct(meta_key) from wp_postmeta where meta_value LIKE '%field\_%'";
	$sql_out = $wpdb->get_results($sql);
	foreach($sql_out as $key=>$arr){
		$ptn = "/^_/";
		$field_names[] = preg_replace($ptn, '',$arr->meta_key );
	}
  return $field_names;
}
?>