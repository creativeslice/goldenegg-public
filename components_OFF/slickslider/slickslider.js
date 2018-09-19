jQuery(document).ready(function($) {
	
	/**
	* Slick Slider
	*/
	var $slickslider = $('.slickSlider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		draggable: true,
		dots: true,
		fade: false,
		arrows: false,
		lazyLoad: 'progressive',
		//centerMode: true,
		//centerPadding: '20px',
		//variableWidth:true,
		//initialSlide: 1,
		focusOnSelect: true,
		adaptiveHeight: true,
		infinite: false,
		mobileFirst: true,
		responsive: [ 
			{ breakpoint: 1200,
				settings: {
					slidesToShow: 1,
				}
			}
		]
	});
	
	// Click image to progress slideshow	
	/*$slickslider.each(function() {
	    var $this = $(this);
	    $this.find(".slick-slide .boxImage").on("click", function(){
	        $this.slick("slickNext");
	    });
	});*/
		
});