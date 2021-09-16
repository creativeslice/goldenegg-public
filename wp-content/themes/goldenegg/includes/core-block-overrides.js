window.addEventListener('load', function () {
	
	/* CUSTOMIZE CORE BLOCK STYLES */
	
	// BUTTONS
	wp.blocks.unregisterBlockStyle('core/button', ['default', 'squared']);
	wp.blocks.registerBlockStyle('core/button', [
		{
			name: 'fill',
			label: 'Fill',
			isDefault: true,
		},
		{
			name: 'outline',
			label: 'Outline',
		},
		{
			name: 'underline',
			label: 'Underline',
		},
	]);
	
	// COLUMNS - remove variations
	wp.blocks.unregisterBlockVariation('core/columns', [
		//'two-columns-equal' , 
		//'two-columns-one-third-two-thirds',
		'three-columns-wider-center'
	]);

	// IMAGE
	wp.blocks.unregisterBlockStyle('core/image', ['rounded']);

	// EMBED - remove variations
	wp.blocks.unregisterBlockVariation('core/embed', 'amazon-kindle');
	wp.blocks.unregisterBlockVariation('core/embed', 'animoto');
	wp.blocks.unregisterBlockVariation('core/embed', 'cloudup');
	wp.blocks.unregisterBlockVariation('core/embed', 'collegehumor');
	wp.blocks.unregisterBlockVariation('core/embed', 'crowdsignal');
	wp.blocks.unregisterBlockVariation('core/embed', 'dailymotion');
	wp.blocks.unregisterBlockVariation('core/embed', 'flickr');
	wp.blocks.unregisterBlockVariation('core/embed', 'funnyordie');
	wp.blocks.unregisterBlockVariation('core/embed', 'hulu');
	wp.blocks.unregisterBlockVariation('core/embed', 'imgur');
	wp.blocks.unregisterBlockVariation('core/embed', 'issuu');
	wp.blocks.unregisterBlockVariation('core/embed', 'kickstarter');
	wp.blocks.unregisterBlockVariation('core/embed', 'meetup-com');
	wp.blocks.unregisterBlockVariation('core/embed', 'mixcloud');
	wp.blocks.unregisterBlockVariation('core/embed', 'photobucket');
	wp.blocks.unregisterBlockVariation('core/embed', 'polldaddy');
	wp.blocks.unregisterBlockVariation('core/embed', 'reddit');
	wp.blocks.unregisterBlockVariation('core/embed', 'reverbnation');
	wp.blocks.unregisterBlockVariation('core/embed', 'screencast');
	wp.blocks.unregisterBlockVariation('core/embed', 'soundcloud');
	wp.blocks.unregisterBlockVariation('core/embed', 'scribd');
	wp.blocks.unregisterBlockVariation('core/embed', 'slideshare');
	wp.blocks.unregisterBlockVariation('core/embed', 'smugmug');
	wp.blocks.unregisterBlockVariation('core/embed', 'speaker');
	wp.blocks.unregisterBlockVariation('core/embed', 'speaker-deck');
	wp.blocks.unregisterBlockVariation('core/embed', 'spotify');
	wp.blocks.unregisterBlockVariation('core/embed', 'ted');
	wp.blocks.unregisterBlockVariation('core/embed', 'tiktok');
	wp.blocks.unregisterBlockVariation('core/embed', 'tumblr');
	wp.blocks.unregisterBlockVariation('core/embed', 'twitter');
	wp.blocks.unregisterBlockVariation('core/embed', 'videopress');
	wp.blocks.unregisterBlockVariation('core/embed', 'wordpress');
	wp.blocks.unregisterBlockVariation('core/embed', 'wordpress-tv');

} );