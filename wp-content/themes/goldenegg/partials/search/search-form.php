<button id="search-toggle">
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
<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">Search for:</span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Term&hellip;', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search-submit button" value="Search" />
</form>

<!--
<?php // Icon Search Button ?>
<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" name="s" placeholder="Keyword search..." title="Search" value="<?php echo get_search_query() ?>">
    <button type="submit" title="Submit Search">
		<svg class="icon-search">
			<title>Search</title>
			<use xlink:href="<?php echo get_svg('search'); ?>"></use>
		</svg>
    </button>
</form>
-->
