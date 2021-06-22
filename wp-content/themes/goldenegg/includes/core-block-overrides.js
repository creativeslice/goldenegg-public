wp.domReady( () => {
	
	/* CUSTOMIZE BLOCK STYLES */
	
	// BUTTONS
	wp.blocks.unregisterBlockStyle(
		'core/button',
		[ 'default', 'outline', 'squared', 'fill' ]
	);
	wp.blocks.registerBlockStyle(
		'core/button',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true,
			},
			{
				name: 'outline',
				label: 'Outline',
			},
			{
				name: 'arrow',
				label: 'Arrow',
			}
		]
	);
	
	// image styles
	wp.blocks.unregisterBlockStyle(
		'core/image',
		[ 'rounded' ]
	);
	/*
	wp.blocks.registerBlockStyle(
		'core/image',
		[
			{
				name: 'circle',
				label: 'Circle',
				isDefault: false,
			},
		]
	);
	*/

	
	/* REMOVE CORE BLOCKS THAT AREN'T NEEDED */
	
	
	
	// design
	//wp.blocks.unregisterBlockType( 'core/columns' );
	//wp.blocks.unregisterBlockType( 'core/spacer' );
	//wp.blocks.unregisterBlockType( 'core/separator' );
	
	// formatting
	wp.blocks.unregisterBlockType( 'core/preformatted' );
	wp.blocks.unregisterBlockType( 'core/pullquote' );
	wp.blocks.unregisterBlockType( 'core/verse' );
	
	// layouts
	wp.blocks.unregisterBlockType( 'core/more' );
	wp.blocks.unregisterBlockType( 'core/nextpage' );
	
	// widgets
	wp.blocks.unregisterBlockType( 'core/archives' );
	wp.blocks.unregisterBlockType( 'core/calendar' );
	wp.blocks.unregisterBlockType( 'core/categories' );
	wp.blocks.unregisterBlockType( 'core/latest-comments' );
	wp.blocks.unregisterBlockType( 'core/latest-posts' );
	wp.blocks.unregisterBlockType( 'core/rss' );
	wp.blocks.unregisterBlockType( 'core/search' );
	wp.blocks.unregisterBlockType( 'core/tag-cloud' );
	
	// embeds
	wp.blocks.unregisterBlockVariation( 'core/embed', 'amazon-kindle' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'animoto' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'cloudup' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'collegehumor' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'crowdsignal' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'dailymotion' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'flickr' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'funnyordie' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'hulu' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'imgur' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'issuu' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'kickstarter' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'meetup-com' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'mixcloud' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'photobucket' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'polldaddy' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'reddit' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'reverbnation' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'screencast' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'scribd' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'slideshare' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'smugmug' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'speaker' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'speaker-deck' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'spotify' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'ted' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'tiktok' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'tumblr' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'videopress' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'wordpress' );
	wp.blocks.unregisterBlockVariation( 'core/embed', 'wordpress-tv' );

} );