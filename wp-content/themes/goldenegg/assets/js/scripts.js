window.addEventListener( 'load', function () {} ),
	jQuery( document ).ready( function ( e ) {
		if (
			( e( '#menu-toggle' ).click( function ( n ) {
				e( this ).toggleClass( 'active' ),
					e( '.menu-full' ).slideToggle( 300 );
			} ),
			'ontouchstart' in window )
		) {
			jQuery( 'body' ).on(
				'touchstart click',
				'.main-nav > .menu-item-has-children > a',
				function ( e ) {
					if ( ( e.preventDefault(), 'click' !== e.type ) ) {
						const n = jQuery( this ).parent();
						n.hasClass( 'focus' )
							? ( window.location = this.href )
							: ( n.toggleClass( 'focus' ),
							  n.siblings( '.focus' ).removeClass( 'focus' ) );
					}
				}
			);
		} else
			jQuery( '.main-nav' )
				.find( 'a' )
				.on( 'focus blur', function () {
					jQuery( this )
						.closest( '.menu-item-has-children' )
						.toggleClass( 'focus' );
				} );
	} ),
	jQuery( document ).ready( function ( e ) {
		e( '#search-toggle' ).click( function ( n ) {
			n.preventDefault(),
				e( this ).toggleClass( 'active' ),
				e( '.search-form' ).fadeToggle( 300 ),
				e( '.search-field' )[ 0 ].focus();
		} );
	} ),
	jQuery( document ).ready( function ( e ) {
		function n( n ) {
			const o = e( n ).hasClass( 'open' ),
				t = e( n ).next( '.hiddenContent' );
			e( '.expandBlock .toggleContent.open' ).removeClass( 'open' ),
				e( '.hiddenContent.open' ).slideUp().removeClass( 'open' ),
				o ||
					( e( n ).addClass( 'open' ),
					t.slideDown().addClass( 'open' ) );
		}
		e( '.expandBlock .toggleContent' ).click( function ( e ) {
			e.preventDefault(), n( this );
		} ),
			e( '.expandBlock' ).each( function () {
				e( '.gform_wrapper .validation_error', this ).length &&
					n( e( '.toggleContent', this )[ 0 ] );
			} );
	} );
