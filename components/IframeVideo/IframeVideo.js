jQuery(document).ready(function($) {
	
	/*
	* Show video after pressing play
	*/
	$('.videoContainer .playButton').click(function() {
		$(this).parent('.videoContainer').addClass('playing');
		var iframe = $(this).siblings('.playVideo');
		iframe.attr("src", iframe.data("src"));
	});
		
});