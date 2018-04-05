jQuery(document).ready(function($) {
	
	/**
	* Colorbox
	*/
	var colorbox_params = {
		rel: 'gal',
		maxWidth: '80%',
		maxHeight: '80%',
		speed: 10,
		transition: "fade",
		fixed: true
	};
	
	var video_params = {
		maxWidth: '90%',
		maxHeight: '80%',
		innerWidth: 640, 
		innerHeight: 360,
		iframe: true,
		fixed: true
	};
	
	var inline_params = {
		maxWidth: '100%',
		maxHeight: '100%',
		width: 640, 
		height: 720,
		inline: true,
		speed: 10,
		transition: "fade",
		fixed: true
	};
    
    $('.colorboxVideo').colorbox(video_params);
	$('.colorboxInline').colorbox(inline_params);
	$('.colorbox').colorbox(colorbox_params);
	$('.gallery a[href$=\".jpg\"], .gallery a[href$=\".png\"]').colorbox(colorbox_params);
		
});