<?php
/**
 * Default posts block pattern
 */
return array(
	'title'      => __( 'Default posts', 'twentytwentytwo' ),
	'categories' => array( 'twentytwentytwo-query' ),
	'blockTypes' => array( 'core/group' ),
	'content'    => '<!-- wp:group {"templateLock":"all"} -->
	<div class="wp-block-group">
	
	<!-- wp:query {
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
			"perPage":3
		},
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

	</div>

	<!-- /wp:query -->

</div>
<!-- /wp:group -->',
);
