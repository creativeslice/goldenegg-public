/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	
	/**
    * fallback for SVG icons in IE
    */
    svg4everybody();
    
    
    /**
	* Responsive image loading
	*
	* <img class="lazy" data-small-src="SRC" data-large-src="SRC" alt=""/>
	*/
	var mobileBreakpoint = 500,
	//size = window.innerWidth < mobileBreakpoint ? 'mobile' : 'desktop',
	$images = $('.lazy');

	$images.each(function() {
	    //var url = $(this).attr('data-' + size + '-src');
	    var url = $(this).attr('data-lazy-src');
	    $(this).attr('src', url);
	});
	
	
	/**
     * Expandable Blocks FAQ
     */
    $('.faq-block .question').click(function(e) {
        e.preventDefault();
		var hasOpen = $(this).hasClass('open');
		var answer = $(this).next('.answer');
        // close all the others
        $('.faq-block .question.open').removeClass('open');
        $('.answer.shown').slideUp();
        if (!hasOpen) {
            $(this).addClass('open');
            answer.slideDown().addClass('shown');
        }
    });
    
    
	/**
	 * Share links
	 */
	$('.share-links').each(function() {
	    // Select the text area on click
	    $(this).on('click', '.share-url', function() {
	        $(this).select();
	    });
	
	    // Open share links in new window
	    $('a', this).click(function(e) {
	        e.preventDefault();
	        window.open($(this).attr('href'), 'Share', 'height=480, width=560, top=' + ($(window).height() / 2 - 230) + ', left=' + $(window).width() / 2 + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
	    });
	});
	
	
	/**
     * Open External Links In New Window
     */
    $('a').each(function() {
        // don't open mailto links in new window.
        if ((this.href.indexOf("mailto:") == -1) && (this.href.indexOf("netdna") == -1)) {
            //console.log("not a mailto or netdns link... proceed.");
            var a = new RegExp('/' + window.location.host + '/');
            if (!a.test(this.href)) {
                $(this).click(function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    window.open(this.href, '_blank');
                });
            }
            // open PDF in new window
    		var b = /.*.pdf/;
            if (b.test(this.href) == true) {
                $(this).click(function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    window.open(this.href, '_blank');
                });
            }
        }
    });
    
	
}); /* end of as page load scripts */