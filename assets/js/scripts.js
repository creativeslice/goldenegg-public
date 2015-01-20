(function( $, win, undefined ){

	var AI = {
		boundAttr: "data-ajax-bound",
		interactionAttr: "data-interaction",
		// request a url and trigger ajaxInclude on elements upon response
		makeReq: function( url, els, isHijax ) {
			$.get( url, function( data, status, xhr ) {
				els.trigger( "ajaxIncludeResponse", [ data, xhr ] );
			});
		},
		plugins: {}
	};
	$.fn.ajaxInclude = function( options ) {
		var urllist = [],
			elQueue = $(),
			o = {
				proxy: null
			};

		// Option extensions
		// String check: deprecated. Formerly, proxy was the single arg.
		if( typeof options === "string" ){
			o.proxy = options;
		}
		else {
			o = $.extend( o, options );
		}
		
		// if it's a proxy, que the element and its url, if not, request immediately
		function queueOrRequest( el ){
			var url = el.data( "url" );
			if( o.proxy && $.inArray( url, urllist ) === -1 ){
				urllist.push( url );
				elQueue = elQueue.add( el );
			}
			else{
				AI.makeReq( url, el );
			}
		}
		
		// if there's a url queue
		function runQueue(){
			if( urllist.length ){
				AI.makeReq( o.proxy + urllist.join( "," ), elQueue );
				elQueue = $();
				urllist = [];
			}
		}
		
		// bind a listener to a currently-inapplicable media query for potential later changes
		function bindForLater( el, media ){
			var mm = win.matchMedia( media );
			function cb(){
				queueOrRequest( el );
				runQueue();
				mm.removeListener( cb );
			}
			if( mm.addListener ){
				mm.addListener( cb );
			}
		}
		
		// loop through els, bind handlers
		this.not( "[" + AI.boundAttr + "]").not("[" + AI.interactionAttr + "]" ).each(function( k ) {
			var el = $( this ),
				media = el.attr( "data-media" ),
				methods = [ "append", "replace", "before", "after" ],
				method,
				url,
				isHijax = false,
				target = el.attr( "data-target" );

			for( var ml = methods.length, i=0; i < ml; i++ ){
				if( el.is( "[data-" + methods[ i ] + "]" ) ){
					method = methods[ i ];
					url = el.attr( "data-" + method );
				}
			}

			if( !url ) {
				// <a href> or <form action>
				url = el.attr( "href" ) || el.attr( "action" );
				isHijax = true;
			}

			if( method === "replace" ){
				method += "With";
			}

			el.data( "method", method )
				.data( "url", url )
				.data( "target", target )
				.attr( AI.boundAttr, true )
				.each( function() {
					for( var j in AI.plugins ) {
						AI.plugins[ j ].call( this, o );
					}
				})
				.bind( "ajaxIncludeResponse", function( e, data, xhr ){
					var content = data,
						targetEl = target ? $( target ) : el;

					if( o.proxy ){
						var subset = content.match( new RegExp( "<entry url=[\"']?" + el.data( "url" ) + "[\"']?>(?:(?!</entry>)(.|\n))*", "gmi" ) );
						if( subset ){
							content = subset[ 0 ];
						}
					}
					
					var filteredContent = el.triggerHandler( "ajaxIncludeFilter", [ content ] );
					
					if( filteredContent ){
						content = filteredContent;
					}

					if( method === 'replaceWith' ) {
						el.trigger( "ajaxInclude", [ content ] );
						targetEl[ el.data( "method" ) ]( content );
					} else {
						targetEl[ el.data( "method" ) ]( content );
						el.trigger( "ajaxInclude", [ content ] );
					}
				});

			// When hijax, ignores matchMedia, proxies/queueing
			if ( isHijax ) {
				AI.makeReq( url, el, true );
			}
			else if ( !media || ( win.matchMedia && win.matchMedia( media ).matches ) ) {
				queueOrRequest( el );
			}
			else if( media && win.matchMedia ){
				bindForLater( el, media );
			}
		});
		
		// empty the queue for proxied requests
		runQueue();
		
		// return elems
console.log(AI);
		return this;
	};

	win.AjaxInclude = AI;
}( jQuery, this ));
/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {

	$('#mobilemenu').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active');
		$('.main-nav').slideToggle(200);
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
	if( !$('body').hasClass('wp-admin') ){
		function goTo(href) {
	//	    $('#main').fadeTo('fast', 0.5); //original
		    $('#main').removeClass('fadeIn').addClass('fadeOut');
		      $("html, body").animate({ scrollTop:0 },"slow");
		    $.ajax({
		        url: href,
		        success: function(data) {
			        //original 
	/*           $('#main').fadeOut('fast', function(){
		                $(this).html(data).fadeTo('fast', 1);
		                setTimeout(function(){$("html, body").animate({ scrollTop:0 },"slow"); } , 50);
		            });*/
		            setTimeout(function(){
			            $('#main').html(data);
			            $('#main').removeClass('fadeOut').addClass('fadeIn');
			           
			        } , 500);
		            
		            // update the page title
		            var title = $('#main').find('h1').text();
		            $('head').find('title').text(title);
		        }
		    });
		}
		if (typeof history.pushState !== "undefined") {
		    var historyCount = 0;
		
		    $('li.pushState a').on('click',function(){
			    var pSUrl = href = $(this).attr('href');
			    var href = $(this).attr('href').replace('http://goldenegg.dev/','').replace('/','');
			    goTo('http://goldenegg.dev/ajaxRequest/'+href);
		        history.pushState(null, null, pSUrl);
		        return false;
		    });
		
		    window.onpopstate = function(){
			    if(historyCount) {
		            goTo(document.location);
		        }
		        historyCount = historyCount+1;
		    };
		}
	}
}); /* end of as page load scripts */