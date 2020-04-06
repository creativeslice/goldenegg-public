jQuery(document).ready(function($) {

	/**
	 * Expanding Text
	 */
	function egg_openExpandBlock(elem) {
		var hasOpen = $(elem).hasClass('open'),
			$hiddenContent = $(elem).next('.hiddenContent');
	
		// close all the others
		$('.expandBlock .toggleContent.open').removeClass('open');
		$('.hiddenContent.open').slideUp().removeClass('open');
		
		// open this one
		if (!hasOpen) {
			$(elem).addClass('open');
			$hiddenContent.slideDown().addClass('open');
		}
	}

	$('.expandBlock .toggleContent').click(function(e) {
		e.preventDefault();
		egg_openExpandBlock(this);
	});
	
	// Open Block if Gravity Forms error message
	$('.expandBlock').each(function() {
		var $expandBlock = $(this);
		if ($('.gform_wrapper .validation_error', this).length) {
			egg_openExpandBlock($('.toggleContent', this)[0]);
		}
	});
	
	
	// Simplified, does NOT close others
	/*
	$('.expandBlock .toggleContent').click(function(e) {
		var $this = $(this);
		$this.parent('.expandBlock').toggleClass('open');
	});
	*/
	
	// Open div with ID that matches hashlink
	/*
	var id = location.hash;
	if (jQuery(id).length) {
		jQuery(id).addClass('open');
	}
	*/

});
