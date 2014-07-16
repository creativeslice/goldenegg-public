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
/**
	 * Initiates Headroom.js
	 * Header must have an id, the id is referenced below
	 * CSS can be defined in _headroom.scss 
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