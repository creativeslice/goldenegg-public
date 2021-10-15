<?php
/**
 * Default posts block pattern
 */
return array(
	'title'      => __( 'Default posts', 'twentytwentytwo' ),
	'categories' => array( 'twentytwentytwo-query' ),
	'blockTypes' => array( 'core/query' ),
	'content'    => '<!-- wp:query {
		"query":{
			"offset":0,
			"postType":"post",
			"categoryIds":[1],
			"tagIds":[],
			"order":"desc",
			"orderBy":"date",
			"author":"",
			"search":"",
			"sticky":"",
			"perPage":3},
			"displayLayout":{
				"type":"flex",
				"columns":3
			},
			"align":"wide",
			"layout":{
				"inherit":true
			}
		} -->
		
		<div class="wp-block-query alignwide">
		<!-- wp:post-template {"align":"wide"} -->
		
			<!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"300px"} /-->

			<!-- wp:post-title {"isLink":true,"fontSize":"large"} /-->

			<!-- wp:post-excerpt /-->

		<!-- /wp:post-template -->

		<!-- wp:separator {"align":"wide"} -->
		<hr class="wp-block-separator alignwide"/>
		<!-- /wp:separator -->
		
		</div>
		
	<!-- /wp:query -->',
);
