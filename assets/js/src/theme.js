/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y }
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;

/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {

	if( $('#popup-message').length ){
		$('a').not( '.external' ).on('click', function(e){
			var target = $(this).attr('href');
			if( !target.match(/^#/) ){
				e.preventDefault();
				$(window).unbind('beforeunload', closeHandler );
				var modal = $("<div>", {class: "colorboxModal"}).text( $('#popup-message').html() );			
				var cancelBtn = $('<a/>').attr({ class: 'button', name:'closeColorbox'}).on("click", function(){ $.colorbox.close(); }).html('Cancel');
				var continueBtn = $('<a/>').attr({ class: 'button', name:'closeColorbox'}).on("click", function(){ window.location = target; }).html('Continue');	
				modal.append( cancelBtn, continueBtn );	
			   	$.colorbox( {html: modal , width:"400px", height:"400px"});			   	
			 }
		});
		$('a.external').on('click', function(e){
			$(window).unbind('beforeunload', closeHandler );
		})

		// fallback for closing or reloading tab
		var closeHandler = function() {
			return $('#popup-message').html();
		}
		$(window).bind('beforeunload', closeHandler );
	}
	$('#mobilemenu').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('span', this).toggleClass('icon-menu').toggleClass('icon-close');
		$('.top-nav').slideToggle(200);
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