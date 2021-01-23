<button id="searchToggle">
	<svg class="open">
		<title>Show Search</title>
		<use xlink:href="<?php echo get_svg('search'); ?>"></use>
	</svg>
	<svg class="close">
		<title>Close Search</title>
		<use xlink:href="<?php echo get_svg('close'); ?>"></use>
	</svg>
</button>

<?php // Text Search Button ?>
<form class="searchForm" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">Search for:</span>
		<input type="search" class="searchField" placeholder="<?php echo esc_attr_x( 'Search Term&hellip;', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="searchSubmit button" value="Search" />
</form>

<!--
<?php // Icon Search Button ?>
<form class="searchForm" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" name="s" placeholder="Keyword search..." title="Search" value="<?php echo get_search_query() ?>">
    <button type="submit" title="Submit Search">
		<svg class="iconSearch">
			<title>Search</title>
			<use xlink:href="<?php echo get_svg('search'); ?>"></use>
		</svg>
    </button>
</form>
-->