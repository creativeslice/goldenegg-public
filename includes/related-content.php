<?php
/**
 * Associated Content and Related Posts
 */

// actions
add_action( 'egg/related_posts', 'egg_related_posts' );



/** 
 * get_associated
 *
 * This function returns $post objects that have been associated by ACF with the current post or page 
 * 
 * @param integer $post_id This is the $post->ID from the current post or page 
 * @param string $assoc_type This is the post_type of the requested associated content 
 *
 * @return array array of post objects 
 */ 
function get_associated( $main_post_id , $assoc_type ){	
	$main_type = get_post_type( $main_post_id );
	if( $assoc_type == 'location' ){ $assoc_type = 'locations'; }
	$run_query = true;
	$childrenArray = get_field( 'associated_'.$assoc_type , $main_post_id );
	if(!$childrenArray){
		$run_query = false;
	}
	else{
		$args_parent = array(
			'post_type' => array( $assoc_type ),
			'post_status'=>'publish',
			'post__in'=> $childrenArray
		);
	}
	$args_child = array(
	'post_type' => $assoc_type,
		'meta_query' => array(
			array(
				'key' => 'associated_'.$main_type,
				'value' => '"'.$main_post_id.'"',
				'compare' => 'LIKE'			
			)
		)
	);
	// if there are no children and the post_in is empty, the query returns all records - this avoids runnning the query for that condition.
	if($run_query){
		$query_parent = new WP_Query( $args_parent );
		$sort_by_children = true;
	}
	$query_child = new WP_Query( $args_child );
	$query_result = new WP_Query( $args_child );
	if(count(@$query_parent->posts)>0){ 
		if(count(@$query_child->posts)>0){
			foreach($query_child->posts as $key=>$post){
				$excludes[] = $post->ID;
			}
			foreach($query_parent->posts as $post){
				if(!in_array($post->ID, $excludes)){ 	
					$query_child->posts[] = $post;
				}
			}
			$query_result->posts = $query_child->posts; 
		}
		else{
			$query_result->posts = $query_parent->posts; 
		}
	}
	elseif( count( @$query_child->posts )>0 ){ 
		$query_result->posts = $query_child->posts;
	}
	else{
	 return false;
	}
	if(@$sort_by_children){
		$posts_sub = array();
		foreach($query_result->posts as $key=>$post){
			$id = $post->ID;
			$new_key = array_search( $id, $childrenArray );
			$posts_sub[$new_key] = $post;
		}
		$query_result->posts = $posts_sub;
		ksort($posts_sub);
	}
	$query_result->post_count = count($query_result->posts);
	return $query_result;
}


/**
 * Related Posts
 *
 * Usage:	do_action('egg/related_posts');		// Show default number of posts (3)
 *			do_action('egg/related_posts', 5);	// Show 5 posts
 *
 * @return	void
 */
function egg_related_posts( $limit )
{
	global $post;

	if (! $limit ) $limit = 3;

	echo '<ul id="related-posts">';
	$tags = wp_get_post_tags( $post->ID, 'fields=slugs' );

	if ( $tags )
	{
		$tag = implode(',', $tags);
		$args = array(
			'tag'            => $tag,
			'posts_per_page' => $limit,
			'post__not_in'   => array($post->ID),
		);
		$related_posts = new WP_Query( $args );

		if ( $related_posts->have_posts() )
		{
			while ( $related_posts->have_posts() ) : $related_posts->the_post();
				get_template_part( 'partials/related-post' );
			endwhile;
		}
		else
		{
			get_template_part( 'partials/related-post', 'missing' );
		}
		wp_reset_postdata();
	}
	else
	{
		get_template_part( 'partials/related-post', 'missing' );
	}
	echo '</ul>';
}