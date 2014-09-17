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
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/


/*
 * Put all your regular jQuery in here.
*/

jQuery(document).ready(function($) {
	
	/**
	 * Initiates Colorbox
	 */
	var colorbox_params = {
			rel: 'gal',
	        maxWidth: '96%',
	        maxHeight: '90%',
	        fixed: true
	    };
	 // clean up on deployment and keep only specific selectors
	$('.colorbox').colorbox(colorbox_params);
	$('.gallery a').colorbox(colorbox_params);
	$('a[href$=\".jpg\"], a[href$=\".png\"]').colorbox(colorbox_params);
	
	
	/**
	 * Initiates Headroom.js
	 * Header must have an id, the id is referenced below
	 * CSS can be defined in _headroom.scss 
	 */
	$("#headroom").headroom({					//define header id here
		// scroll tolerance in px before state changes
		"tolerance": 0,
		// vertical offset in px before element is first unpinned
		"offset": 147, /* set this to height of your header */
		"classes": {
			// when element is initialised
			"initial": "animated",
			// when scrolling up
			"pinned": "slideDown",
			// when scrolling down
			"unpinned": "slideUp",
			// when above offset
			"top": "headroom--top",
			// when below offset
			"notTop": "headroom--not-top"
		}
	});
	
	
	/**
	 * FADE-IN
	 * Give target div class='fade-block'
	 * Class='transition-in' is added on document ready
	 * Class='transition-in' is removed when target element's pct (defined below) hits trigger point 
	 * Test: insert <div class='fade-block' style='background-color: grey; height:50px; width:80%;  '> This will fade in </div>
	**/
	var egg;
    egg = {};
    egg.fadeIn = {
	    below_fold: function(el) {
	      var el_offset, el_top, pct, scroll_bottom, scroll_top, window_height;
	      window_height = $(window).height();
	      scroll_top = $(window).scrollTop();
	      scroll_bottom = scroll_top + window_height;
	      el_offset = el.offset();
	      el_top = el_offset.top;
	      pct = ((el_top - scroll_top) / window_height).toFixed(2);
	      if (pct > .90) {
	        return true;
	      } else {
	        return false;
	      }
	    },
	    hide: function(el) {
	      if (this.below_fold(el)) {
	        return el.addClass('transition-in');
	      }
	    },
	    init: function(el) {
	      var self;
	      self = this;
	      el.each(function() {
	        return self.hide($(this));
	      });
	      return $(window).on('scroll', function() {
	        return el.each(function() {
	          if (!self.below_fold($(this))) {
	            return $(this).removeClass('transition-in');
	          }
	        });
	      });
	    }
	  };
	if (!Modernizr.touch) {
		  egg.fadeIn.init($('.fade-block'));
    }

	
	/**
	 * Initiates Flexslider; Flexslider requires a single containing element, <div>, then, a <ul class=”slides”><li><img src='this.jpg'></li></ul> 
	 * view options at: https://github.com/woothemes/FlexSlider/wiki/FlexSlider-Properties
	 *		SAMPLE HTML:
	 *		<div class="flexslider">
	 *		  <ul class="slides">
	 *		    <li>
	 *		      <img src="slide1.jpg" />
	 *		    </li>
	 *		  </ul>
	 *		</div>
	 *
	 *		LOAD CSS 
	 */ 
	var flexslider_params = {
			//slideshowSpeed:4500,
			//animation:'slide',
			//direction:'vertical'
			} 
	$('.flexslider').flexslider(flexslider_params);


	/**
	 * Initiates MixitUp
	 *		DIVS INITIATING FILTER
	 *		<div class="filter" data-filter="all">Show All</div>
	 *		<div class="filter" data-filter=".category-1">Category 1</div>
	 *		<div class="filter" data-filter=".category-2">Category 2</div>
	 *		MAIN DIV
	 *		 <div id="Container">
	 *			<div class="mix category-1" data-myorder="2"></div>
	 *			<div class="mix category-2" data-myorder="4"></div>
	 *			<div class="mix category-1" data-myorder="1"></div>
	 *			...
	 *			<div class="mix category-2" data-myorder="8"></div>
	 *		</div>
	 */
	$('#Container').mixItUp();		
	
	
	/**
	 * Mobile menu show/hide
	 */
	$('#mobilemenu').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('span', this).toggleClass('icon-menu').toggleClass('icon-close');
		$('.top-nav').slideToggle(200);
		//$('.search-field').focus();
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


	/**
	 * Expand blocks
	 */
	$('.expandblock').click(function(e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$(this).next('.expandcontent').slideToggle(200);
	});
	
	
	/**
	 * Share links
	 */
	$('.share-links').each(function() {
		// Select the text area on click
		$(this).on('click', '.share-url', function () {
			$(this).select();
		});

		// Open share links in new window
		$('a', this).click(function(e) {
			e.preventDefault();
			window.open($(this).attr('href'), 'Share', 'height=470, width=550, top='+($(window).height()/2 - 225) +', left='+$(window).width()/2 +', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
		});
	});

}); /* end of as page load scripts */