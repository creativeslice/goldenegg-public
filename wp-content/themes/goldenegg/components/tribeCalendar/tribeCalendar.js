jQuery(document).ready(function($) {
	
	
	/**
	 * Filter by Category
	 */
	var selected_category;

	// Set filter tab to active
	function filterSelect(filter, list) {
		$(list + ' li').removeClass('active');
		$(list + ' li[data-slug="' + filter + '"]').addClass('active');
	}
	
	// Filter click
    $('.catFilters li').click(function(e) {
	    e.preventDefault();
		var slug = $(this).attr('data-slug');
		selected_category = slug;
		history.pushState(null, null, '#' + slug);
		filterSelect(slug, '.catFilters');
		filter_calendar_items();
	});

	/**
	 * Parameters for filtering
	 *
	 * @param $item
	 */
	function item_is_valid_for_current_params($item) {
		if (selected_category == 'all') return true;
		return ($item.attr('data-cats').indexOf(selected_category) != -1);
	}

	/**
	 * Based on current params, iterate through each calendar item and display or hide.
	 */
	function filter_calendar_items() {
		var shown = 0;
		$('.tribe-events-loop a').each( function(index, item) {
			var $item = $(item);
			if (item_is_valid_for_current_params($item)) {
				$item.removeClass('hidden');
				shown++
			} else {
				$item.addClass('hidden');
			}
		});
		(shown) ? $('.nonefound').hide() : $('.nonefound').show();
	}


	/**
	 * Select category based on hashtag. wait a half-second to load
	 */
	setTimeout(function(){ index_position = document.URL.indexOf("#");
		if(index_position != -1) {
			var slug = document.URL.substring(index_position + 1);
			//console.log("in calendar onstart, triggering filter for", slug);
			selected_category = slug;
			filterSelect(slug, '.catFilters');
			filter_calendar_items();
		}
	}, 500);
	

});
