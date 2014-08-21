<?php // Template Name: JS TEST ?>
<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<title><?php wp_title(''); ?></title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/apple-touch-icon.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png">
	<!--[if IE]><link rel="shortcut icon" href="<?php echo bloginfo('template_directory'); ?>/assets/img/favicon.ico"><![endif]-->
	<meta name="msapplication-TileColor" content="#e7c12a">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/img/mstile-310x310.png">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="container">

		<header class="header" role="banner" id='header'>

			<div id="inner-header" class="wrap cf">

				<div id="logo"><a href="<?php echo home_url(); ?>" title="Home">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php echo get_option('blogname'); ?>" />
				</a></div>

				<span id="mobilemenu">
					<span class="icon-menu" aria-hidden="true"></span>
					<span class="screen-reader-text">MENU</span>
				</span>

				<nav role="navigation">
				<?php wp_nav_menu(array(
					'container' => false,						// remove nav container
					'container_class' => 'menu',				// class of container
					'menu' => 'The Main Menu',					// nav name
					'menu_id' => 'top-nav',				        // adding custom nav id
					'menu_class' => 'nav top-nav',				// adding custom nav class
					'theme_location' => 'main-nav',				// where it's located in the theme
					'before' => '',								// before the menu
					'after' => '',								// after the menu
					'link_before' => '',						// before each link
					'link_after' => '',							// after each link
					'depth' => 2								// limit the depth of the nav
				)); ?>
				</nav>

			</div>

		</header>

<?php 
	add_action('wp_footer', 'add_scripts', 999	);
function add_scripts(){
	echo "
	<script type='text/javascript' src='".get_template_directory_uri()."/assets/js/modules/headroom.js'></script>
	<script type='text/javascript' src='".get_template_directory_uri()."/assets/js/modules/jquery.flexslider.js'></script>
	<script type='text/javascript' src='".get_template_directory_uri()."/assets/js/modules/jquery.colorbox.js'></script>
	<script type='text/javascript' src='".get_template_directory_uri()."/assets/js/modules/jquery.mixitup.js'></script>
	<script type='text/javascript' src='".get_template_directory_uri()."/assets/js/modules/jquery.lazyload.js'></script>";

	}

?>

<div id="content">

	<div class="wrap">

		<div id="main" class="goldlarge" role="main">
		<div style='height:100px'></div>
			<div>
				<h2>Headroom is Loaded</h2>
			</div>
			<div>
				<h2>MixItUp</h2>
				<button class="filter" data-filter="all" type='button'>Show All</button>
				<button class="filter" data-filter=".category-1">Category 1</button>
				<button class="filter" data-filter=".category-2">Category 2</button>
				
				<div id="Container">
					<div class="mix category-1" data-myorder="2">2</div>
					<div class="mix category-2" data-myorder="4">4</div>
					<div class="mix category-1" data-myorder="1">1</div>
					<div class="mix category-2" data-myorder="8">8</div>
				</div>
			</div>
			<hr>
			<div>
				<h2>Flexslider</h2>
				<div class="flexslider">
				  <ul class='slides' >
				    <li>
				      <img src="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/ohoopee1.jpg"; ?>" />
				    </li>
				    <li>
				      <img src="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/ohoopee2.jpg"; ?>" />
				    </li>
				    <li>
				      <img src="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/ohoopee3.jpg"; ?>" />
				    </li>
				  </ul>
				 </div>
			</div>
			<hr>
			<div>
				<h2>Colorbox</h2>
				<div class="gallery">
				      <a class='gal' id='gaClose_1' href="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/ohoopee1.jpg"; ?>" title='Captions are placed in the anchor element that wraps the img. It is a title attribute.'>
					      <img src="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/ohoopee1.jpg"; ?>" />
				      </a>
				      <a class='gal' href="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/ohoopee2.jpg"; ?>" title='Captions are placed in the anchor element that wraps the img. It is a title attribute.'>     
				      	<img src="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/ohoopee2.jpg"; ?>" />
				      </a>
				 </div>
			</div>
			<h2> Fade-in</h2>
			<div class='fade-block' style='background-color: grey; height:50px; width:80%;  '> This will fade in </div>
			<hr>
			<div style='height:600px'></div>
			<h2>LazyLoader (images)</h2>
		      <img class="lazy" data-original="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/lazy1.jpg"; ?>" />
		      <img class="lazy" data-original="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/lazy2.jpg"; ?>" />
		      <img class="lazy" data-original="<?php echo get_template_directory_uri()."/assets/js/modules/test-img/lazy3.jpg"; ?>" />
			<hr>

			<?php if(get_field('popup_message')) : ?>
			<div style='display:none' id='popup_message'>
				<?php  echo get_field('popup_message'); ?>
			</div>
			<?php endif; ?>

			
		</div>
	</div>
	<script type='text/javascript'>

	
jQuery(document).ready(function($) {

	
	// Google Analytics Event Tracking - captures colorbox close
	var gaClosed = 0;
	$(document).bind('cbox_closed', function() {
		if ( $( $.fn.colorbox.element() ).attr('id').match('gaClose_1') && gaClosed == 0){
			_gaq.push(['_trackEvent', 'Promotion', 'Close', 'Promotion 1']);
			// function is bound multiple times; gaClosed limits firing to once per page load. 
			gaClosed = 1;
		}
	});

	$("img.lazy").lazyload();
		var colorbox_params = {
			rel: 'gal',
	        maxWidth: '96%',
	        maxHeight: '90%',
	        fixed: true
	    };
	 // clean up on deployment and keep only specific selectors
	 $('.gallery a').colorbox(colorbox_params);
	//$('a[href$=\".jpg\"], a[href$=\".png\"]').colorbox(colorbox_params);
	
	/**
	 * Initiates Headroom.js
	 * Header must have an id, the id is referenced below
	 * CSS can be defined in _headroom.scss 
	 */
	$("#header").headroom();
	
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
	//checks scripts
})
		jQuery(window).load(function() {
			
		});
	</script>
</div>
<style>
#Container .mix{
	display: none;
}
.mix{
	height: 100px;
	width: 100px;
	background-color:green;
}
.headroom {
    transition: transform 200ms linear;
}
.headroom--pinned {
    transform: translateY(0%);
}
.headroom--unpinned {
    transform: translateY(-100%);
}/*
 * jQuery FlexSlider v2.2.0
 * http://www.woothemes.com/flexslider/
 *
 * Copyright 2012 WooThemes
 * Free to use under the GPLv2 license.
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Contributing author: Tyler Smith (@mbmufffin)
 */


/* Browser Resets
*********************************/
.flex-container a:active,
.flexslider a:active,
.flex-container a:focus,
.flexslider a:focus  {outline: none;}
.slides,
.flex-control-nav,
.flex-direction-nav {margin: 0; padding: 0; list-style: none !important;} 

/* Icon Fonts
*********************************/
/* Font-face Icons */
@font-face {
	font-family: 'flexslider-icon';
	src:url('fonts/flexslider-icon.eot');
	src:url('fonts/flexslider-icon.eot?#iefix') format('embedded-opentype'),
		url('fonts/flexslider-icon.woff') format('woff'),
		url('fonts/flexslider-icon.ttf') format('truetype'),
		url('fonts/flexslider-icon.svg#flexslider-icon') format('svg');
	font-weight: normal;
	font-style: normal;
}

/* FlexSlider Necessary Styles
*********************************/
.flexslider {margin: 0; padding: 0;}
.flexslider .slides > li {display: none; -webkit-backface-visibility: hidden;} /* Hide the slides before the JS is loaded. Avoids image jumping */
.flexslider .slides img {width: 100%; display: block;}
.flex-pauseplay span {text-transform: capitalize;}

/* Clearfix for the .slides element */
.slides:after {content: "\0020"; display: block; clear: both; visibility: hidden; line-height: 0; height: 0;}
html[xmlns] .slides {display: block;}
* html .slides {height: 1%;}

/* No JavaScript Fallback */
/* If you are not using another script, such as Modernizr, make sure you
 * include js that eliminates this class on page load */
.no-js .slides > li:first-child {display: block;}

/* FlexSlider Default Theme
*********************************/
.flexslider { margin: 0 0 60px; background: #fff; border: 4px solid #fff; position: relative; -webkit-border-radius: 4px; -moz-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: 0 1px 4px rgba(0,0,0,.2); -moz-box-shadow: 0 1px 4px rgba(0,0,0,.2); -o-box-shadow: 0 1px 4px rgba(0,0,0,.2); box-shadow: 0 1px 4px rgba(0,0,0,.2); zoom: 1; }
.flex-viewport { max-height: 2000px; -webkit-transition: all 1s ease; -moz-transition: all 1s ease; -o-transition: all 1s ease; transition: all 1s ease; }
.loading .flex-viewport { max-height: 300px; }
.flexslider .slides { zoom: 1; }
.carousel li { margin-right: 5px; }

/* Direction Nav */
.flex-direction-nav {*height: 0;}
.flex-direction-nav a  { display: block; width: 40px; height: 40px; margin: -20px 0 0; position: absolute; top: 50%; z-index: 10; overflow: hidden; opacity: 0; cursor: pointer; color: rgba(0,0,0,0.8); text-shadow: 1px 1px 0 rgba(255,255,255,0.3); -webkit-transition: all .3s ease; -moz-transition: all .3s ease; transition: all .3s ease; }
.flex-direction-nav .flex-prev { left: -50px; }
.flex-direction-nav .flex-next { right: -50px; text-align: right; }
.flexslider:hover .flex-prev { opacity: 0.7; left: 10px; }
.flexslider:hover .flex-next { opacity: 0.7; right: 10px; }
.flexslider:hover .flex-next:hover, .flexslider:hover .flex-prev:hover { opacity: 1; }
.flex-direction-nav .flex-disabled { opacity: 0!important; filter:alpha(opacity=0); cursor: default; }
.flex-direction-nav a:before  { font-family: "flexslider-icon"; font-size: 40px; display: inline-block; content: '\f001'; }
.flex-direction-nav a.flex-next:before  { content: '\f002'; }
.flex-direction-nav li  { line-height: 1 }

/* Pause/Play */
.flex-pauseplay a { display: block; width: 20px; height: 20px; position: absolute; bottom: 5px; left: 10px; opacity: 0.8; z-index: 10; overflow: hidden; cursor: pointer; color: #000; }
.flex-pauseplay a:before  { font-family: "flexslider-icon"; font-size: 20px; display: inline-block; content: '\f004'; }
.flex-pauseplay a:hover  { opacity: 1; }
.flex-pauseplay a.flex-play:before { content: '\f003'; }

/* Control Nav */
.flex-control-nav {width: 100%; position: absolute; bottom: -40px; text-align: center;}
.flex-control-nav li {margin: 0 6px; display: inline-block; zoom: 1; *display: inline;}
.flex-control-paging li a {width: 11px; height: 11px; display: block; background: #666; background: rgba(0,0,0,0.5); cursor: pointer; text-indent: -9999px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -o-border-radius: 20px; border-radius: 20px; -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3); -moz-box-shadow: inset 0 0 3px rgba(0,0,0,0.3); -o-box-shadow: inset 0 0 3px rgba(0,0,0,0.3); box-shadow: inset 0 0 3px rgba(0,0,0,0.3); }
.flex-control-paging li a:hover { background: #333; background: rgba(0,0,0,0.7); }
.flex-control-paging li a.flex-active { background: #000; background: rgba(0,0,0,0.9); cursor: default; }

.flex-control-thumbs {margin: 5px 0 0; position: static; overflow: hidden;}
.flex-control-thumbs li {width: 25%; float: left; margin: 0;}
.flex-control-thumbs img {width: 100%; display: block; opacity: .7; cursor: pointer;}
.flex-control-thumbs img:hover {opacity: 1;}
.flex-control-thumbs .flex-active {opacity: 1; cursor: default;}

@media screen and (max-width: 860px) {
  .flex-direction-nav .flex-prev { opacity: 1; left: 10px;}
  .flex-direction-nav .flex-next { opacity: 1; right: 10px;}
}
/*
    Colorbox Core Style:
    The following CSS is consistent between example themes and should not be altered.
*/
#colorbox, #cboxOverlay, #cboxWrapper{position:absolute; top:0; left:0; z-index:9999; overflow:hidden;}
#cboxWrapper {max-width:none;}
#cboxOverlay{position:fixed; width:100%; height:100%;}
#cboxMiddleLeft, #cboxBottomLeft{clear:left;}
#cboxContent{position:relative;}
#cboxLoadedContent{overflow:auto; -webkit-overflow-scrolling: touch;}
#cboxTitle{margin:0;}
#cboxLoadingOverlay, #cboxLoadingGraphic{position:absolute; top:0; left:0; width:100%; height:100%;}
#cboxPrevious, #cboxNext, #cboxClose, #cboxSlideshow{cursor:pointer;}
.cboxPhoto{float:left; margin:auto; border:0; display:block; max-width:none; -ms-interpolation-mode:bicubic;}
.cboxIframe{width:100%; height:100%; display:block; border:0; padding:0; margin:0;}
#colorbox, #cboxContent, #cboxLoadedContent{box-sizing:content-box; -moz-box-sizing:content-box; -webkit-box-sizing:content-box;}

/* 
    User Style:
    Change the following styles to modify the appearance of Colorbox.  They are
    ordered & tabbed in a way that represents the nesting of the generated HTML.
*/
#cboxOverlay{background:#fff;}
#colorbox{outline:0;}
    #cboxContent{margin-top:32px; overflow:visible; background:#000;}
        .cboxIframe{background:#fff;}
        #cboxError{padding:50px; border:1px solid #ccc;}
        #cboxLoadedContent{background:#000; padding:1px;}
        #cboxLoadingGraphic{background:url(../img/colorbox-loading.gif) no-repeat center center;}
        
        #cboxLoadingOverlay{background:#000;}
        #cboxTitle{position:absolute; top:-22px; left:0; color:#000;}
        #cboxCurrent{position:absolute; top:-22px; right:205px; text-indent:-9999px;}

        /* these elements are buttons, and may need to have additional styles reset to avoid unwanted base styles */
        #cboxPrevious, #cboxNext, #cboxSlideshow, #cboxClose {border:0; padding:0; margin:0; overflow:visible; text-indent:-9999px; width:20px; height:20px; position:absolute; top:-20px; background:url(../img/colorbox-controls.png) no-repeat 0 0;}
        
        /* avoid outlines on :active (mouseclick), but preserve outlines on :focus (tabbed navigating) */
        #cboxPrevious:active, #cboxNext:active, #cboxSlideshow:active, #cboxClose:active {outline:0;}

        #cboxPrevious{background-position:0px 0px; right:44px;}
        #cboxPrevious:hover{background-position:0px -25px;}
        #cboxNext{background-position:-25px 0px; right:22px;}
        #cboxNext:hover{background-position:-25px -25px;}
        #cboxClose{background-position:-50px 0px; right:0;}
        #cboxClose:hover{background-position:-50px -25px;}
        .cboxSlideshow_on #cboxPrevious, .cboxSlideshow_off #cboxPrevious{right:66px;}
        .cboxSlideshow_on #cboxSlideshow{background-position:-75px -25px; right:44px;}
        .cboxSlideshow_on #cboxSlideshow:hover{background-position:-100px -25px;}
        .cboxSlideshow_off #cboxSlideshow{background-position:-100px 0px; right:44px;}
        .cboxSlideshow_off #cboxSlideshow:hover{background-position:-75px -25px;}
</style>

<?php get_footer(); ?>
