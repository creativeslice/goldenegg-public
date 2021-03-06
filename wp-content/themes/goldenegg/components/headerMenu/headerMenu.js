jQuery(document).ready(function($) {
		
	/**
	 * Mobile menu toggle
	 */
	$('#menuToggle').click(function() {
		//e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.menuFull').slideToggle(300);
		//$('.menuFull').toggleClass('active');
	});


});
