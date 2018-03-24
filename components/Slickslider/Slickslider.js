jQuery(document).ready(function($) {
	
	/**
	* Slick Slider
	*/
	$('.SlickSlider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		draggable: true,
		dots: true,
		fade: false,
		arrows: false,
		lazyLoad: 'progressive',
		centerMode: true,
		centerPadding: '20px',
		//variableWidth:true,
		focusOnSelect: true,
		adaptiveHeight: true,
		fade: false,
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
		
});