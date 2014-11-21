/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {

	$('#mobilemenu').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.main-nav').slideToggle(200);
	});

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