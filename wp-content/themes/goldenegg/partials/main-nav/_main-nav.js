jQuery( document ).ready( function ( $ ) {
	/**
	 * Mobile menu toggle
	 */
	$( '#menu-toggle' ).click( function ( e ) {
		//e.preventDefault();
		const $this = $( this );
		$this.toggleClass( 'active' );
		$( '.menu-full' ).slideToggle( 300 );
		//$('.menuFull').toggleClass('active');
	} );

	// First click opens the menu on touch screens
	if ( 'ontouchstart' in window ) {
		const touched = false;
		jQuery( 'body' ).on(
			'touchstart click',
			'.main-nav > .menu-item-has-children > a',
			function ( e ) {
				e.preventDefault();
				if ( 'click' !== e.type ) {
					const el = jQuery( this ).parent();
					if ( ! el.hasClass( 'focus' ) ) {
						el.toggleClass( 'focus' );
						el.siblings( '.focus' ).removeClass( 'focus' );
					} else {
						window.location = this.href;
					}
				}
			}
		);
	} else {
		jQuery( '.main-nav' )
			.find( 'a' )
			.on( 'focus blur', function () {
				const el = jQuery( this ).closest( '.menu-item-has-children' );
				el.toggleClass( 'focus' );
			} );
	}
} );
