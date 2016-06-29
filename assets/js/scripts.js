/*
 * Navigation Specific JavaScript
*/
jQuery(document).ready(function($) {
	
	
	/**
	 * Mobile menu toggle
	 */
	$('#mobilemenu').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.main-nav').slideToggle(300);
	});
	
	
	/**
	 * Sub menu functionality for touch screen
	 */
	$('.main-nav').find('a').on('focus blur', function() {
		$( this ).parents('.menu-item, .page_item').toggleClass('focus');
	});
	if ( 'ontouchstart' in window ) {
		$('body').on( 'touchstart', '.menu-item-has-children > a', function(e) {
			var el = $( this ).parent('li');
			if ( ! el.hasClass('focus') ) {
				e.preventDefault();
				el.toggleClass('focus');
				el.siblings('.focus').removeClass('focus');
			}
		});
	}
	
	
	/**
	 * Open search panel and focus cursor
	 */
	$('#search-toggle').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.search-form').slideToggle(300);
		$('.search-field')[0].focus();	
	});
	
	
});
/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	
	/**
	 * Adds the screen reader text to the icon's title so it will show on hover
	 */
	$('span[aria-hidden=true]').each(function() {
		var $this = $(this);
		var $screentext = $this.siblings('.screen-reader-text');
		if ( $screentext.length )
			$this.attr('title', $screentext.text());
	});
	
}); /* end of as page load scripts */