<form class="searchForm" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">Search for:</span>
		<input type="search" class="searchField" placeholder="<?php echo esc_attr_x( 'Search Term&hellip;', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="searchSubmit button" value="Search" />
</form>
