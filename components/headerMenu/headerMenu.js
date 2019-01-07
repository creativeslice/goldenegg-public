jQuery(document).ready(function($) {

	/**
	 * Mobile menu toggle
	 */
	$('#menuToggle').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.menuFull').slideToggle(300);
	});


	/**
	 * Sub menu functionality for touch screen
	 */
	$('.mainNav').find('a').on('focus blur', function() {
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

});
