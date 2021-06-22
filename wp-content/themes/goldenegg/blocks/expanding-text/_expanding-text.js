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
		//var $expandBlock = $(this);
		if ($('.gform_wrapper .validation_error', this).length) {
			egg_openExpandBlock($('.toggleContent', this)[0]);
		}
	});

});