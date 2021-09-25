jQuery(document).ready(function($) {

	/**
	 * Open search panel and focus cursor
	 */
	$('#search-toggle').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.search-form').fadeToggle(300);
		$('.search-field')[0].focus();
	});

});
