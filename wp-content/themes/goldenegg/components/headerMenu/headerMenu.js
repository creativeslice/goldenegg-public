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


	// First click opens the menu on touch screens
    if ( 'ontouchstart' in window ) {
        var touched = false;
        jQuery('body')
            .on('touchstart click', '.mainNav > .menu-item-has-children > a', function(e) {
                e.preventDefault();
                if ('click' !== e.type) {
                    var el = jQuery(this).parent();
                    if (!el.hasClass('focus')) {
                        el.toggleClass('focus');
                        el.siblings('.focus').removeClass('focus');
                    } else {
                        window.location = this.href;
                    }
                }
            });
    } else {
        jQuery('.mainNav').find('a').on('focus blur', function() {
            var el = jQuery(this).closest('.menu-item-has-children');
            el.toggleClass('focus');
        });
    }

});
