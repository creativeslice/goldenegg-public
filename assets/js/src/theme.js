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
	if( !$('body').hasClass('wp-admin') ){
		function goTo(href) {
	//	    $('#main').fadeTo('fast', 0.5); //original
		    $('#main').removeClass('fadeIn').addClass('fadeOut');
		      $("html, body").animate({ scrollTop:0 },"slow");
		    $.ajax({
		        url: href,
		        success: function(data) {
			        //original 
	/*           $('#main').fadeOut('fast', function(){
		                $(this).html(data).fadeTo('fast', 1);
		                setTimeout(function(){$("html, body").animate({ scrollTop:0 },"slow"); } , 50);
		            });*/
		            setTimeout(function(){
			            $('#main').html(data);
			            $('#main').removeClass('fadeOut').addClass('fadeIn');
			           
			        } , 500);
		            
		            // update the page title
		            var title = $('#main').find('h1').text();
		            $('head').find('title').text(title);
		        }
		    });
		}
		if (typeof history.pushState !== "undefined") {
		    var historyCount = 0;
		
		    $('li.pushState a').on('click',function(){
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
	}
}); /* end of as page load scripts */