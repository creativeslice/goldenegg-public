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
	function goTo(href) {
	    $('#main').fadeTo('fast', 0.5);
	    $.ajax({
	        url: href,
	        success: function(data) {
	            $('#main').fadeOut('fast', function(){
	                $(this).html(data).fadeTo('fast', 1);
	            });
	            // update the page title
	            var title = $('#main').find('h1').text();
	            $('head').find('title').text(title);
	        }
	    });
	}
	if (typeof history.pushState !== "undefined") {
	    var historyCount = 0;
	
	    $('a[href*="goldenegg.dev"]').on('click',function(){
//alert('clicked');
	        var href = $(this).attr('href');
	        goTo(href);
	        history.pushState(null, null, href);
	        return false;
	    });
	
	    window.onpopstate = function(){
	        if(historyCount) {
	            goTo(document.location);
	        }
	        historyCount = historyCount+1;
	    };
	}
}); /* end of as page load scripts */