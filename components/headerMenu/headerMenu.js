jQuery(document).ready(function($) {
	
	/**
	 * Open search panel and focus cursor
	 */
	$('#searchToggle').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.searchForm').slideToggle(300);
		$('.searchField')[0].focus();	
	});
	
	
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
	

	/**
	 * Detect scroll position and add sticky class to body
	 */
	
	// get initial offset height of #stickyTrigger
	if ( $('#logo').length ){
		elementOffset = $('#logo').offset().top;
	}
	
	// NEED TO UPDATE timeToWaitForLast based on Jake's function
	window.onscroll = function() {
		var windowTop = $(window).scrollTop();
	
		// checks for #stickyTrigger ID and will trigger "sticky"
		if ( $('#logo').length ) {
			var distance = (elementOffset - windowTop + 122); // fixed header offset
			if (distance < 0 ) {
				$('body').addClass('sticky');
			} else {
				$('body').removeClass('sticky');
			}
		}
	}
	
});