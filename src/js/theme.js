/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	
	
	/**
	* fallback for SVG icons in IE
	*/
	svg4everybody();
	
	
	/*
	 * Prevent Widows in h1 articleHeader
	 */
	$('.articleHeader h1').each(function () {
		var string = $(this).html();
		string = string.replace(/ ([^ ]*)$/, '&nbsp;$1');
		$(this).html(string);
	});


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
