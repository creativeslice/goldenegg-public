/*	EggLoader.js is an ajax content loader  
 *	
 * 	add spinner.gif to /img and following to css: .ajax-spinner{ background: url(../img/spinner.gif) no-repeat center center; } 
 */
;(function($){
	"use strict";
	
	// loaderMgmt: a global variable to track the target anchors from the original page load
	window.loaderMgmt = [];
	window.removeClasses = []; 
	var EggLoader = window.EggLoader || {},
		instanceUid = 0; // instanceUid: incremented id for each instance of EggLoader which is also set as the value for a "data-instanceUid" on the target element
	
	EggLoader = (function() {
		function EggLoader(element, options ) {
			if( !$.isArray(options.containers) ){
				options.containers = [options.containers];
			}
			var $egg = this,
				defaults = {
					loadContent : false,			// if true will load content on initialization 
	            	loadSpinner : false,			// if true will append a div "ajax-spinner" to body; requires styling and gif
					spinnerClass : 'ajax-spinner',
					debug : false,					// could be used as conditional for console.log error messages
					delayLoad : 0					// milliseconds for timeout function delaying ajax call
            	};
    		$egg.options = $.extend( defaults , options );
			$egg.instanceUid = instanceUid++;
			if( element ){
				$egg.target = element;
				$egg.href = element.href;
				$egg.bind();						// calls function to bind instance and clickHandler to target anchors
			}
			if( options.loadContent ){
				$egg.loadContent();					// loads content
			}
		}
		return EggLoader;
    }());
	
    EggLoader.prototype.bind = function() {
        var $egg = this;
       // pass this EggLoader instance to the clickHandler in the event object
		$($egg.target).on('click', {
            EggLoader: $egg
        }, $egg.clickHandler);
    };

	EggLoader.prototype.clickHandler = function(e) {
		e.preventDefault();

		// get this instance of the EggLoader which was bound to the element
		var $egg = e.data.EggLoader;

		// verify page has targeted container: if not bail and redirect normally
		var $containers = $egg.options.containers;
		if( $containers.length > 0 ){
			
			// change Url and send this instance's selector to history
			history.pushState( { selector: $egg.options.selector }, null, $egg.href);
			$egg.loadTarget();
		}
		else{
			window.location.href = $egg.href;
		}
	};

	// loadTarget() runs before the ajax call and prepares the page
    EggLoader.prototype.loadTarget = function() {
        var $egg = this,
        	$containers = $egg.options.containers,			// array of html elements that will have content replaced by the same
        	$classesOut = $($($egg.options.classesOut))[0];		// classes to be added to the container prior to the ajax call
        	
        // call user custom function if one is assigned and exists
        if( 'function' == typeof $egg.options.beforeOut ){				
			$egg.options.beforeOut();
		}
		
		// remove all classes on the container
		$.each( $containers, function(){
			var $container = $(this);
			if( 'object' == typeof window.removeClasses ){
				$(window.removeClasses).each( function(){
					$container.removeClass(this);
				});
			}
			
			// add classes for container's fade out
			if('undefined' != typeof $classesOut ){ 
				var $ClassOut = $($classesOut[this]);
				// add classes to the target div for fade in
				$ClassOut.each( function(){
					$container.addClass(this);
				});
			}
			
		});
		
		// add spinner div if set
		if( $egg.options.loadSpinner ){
			$egg.loadSpinner();
		}

		// if delay is set will delay ajax load; else load immediately
		if( $egg.options.delayLoad > 0 ){
			setTimeout( function(){
	            $egg.loadContent();
	        } , $egg.options.delayLoad );
	    }
	    else{
	        $egg.loadContent();    
	    }
    };
    
	// loadContent(): makes the ajax call and outputs the results on the page
    EggLoader.prototype.loadContent = function() {
        var $egg = this;
		var $href = $egg.href,
			$containers = $egg.options.containers,
			$classesIn = $($($egg.options.classesIn))[0],
			$customBeforeLoad = $egg.options.beforeLoad,
			$customAfterLoad = $egg.options.afterLoad;

		$.ajax({
            url:      $href,
            async:    true,
            cache:    true, // for testing set to: false
            dataType: 'html',
            beforeSend: function()
			{
				if (typeof $customBeforeLoad == 'function') { 
					// send this ajax object and this instance of the EggLoader to the user's custom function 
					$customBeforeLoad.call( this, $egg ); 
				}
			},
            success: function( response )
            {
	            // get the body class of the ajax response
				var matches = response.match(/<body.*class=["']([^"']*)["'].*>/),
					$classes = matches && matches[1],					
					// get title and content from ajax request
					html        	= $('<html />').html(response),
					new_title   	= html.find('title').html();

					// get post-id
					var postid, $matches = $classes.match(/(^|\s)postid-(\d+)(\s|$)/);
					if ($matches) {
					    postid = $matches[2];
					}
				
				// check if google analytics is loaded
				if (typeof ga !== 'undefined') {
					// add ajax view to the analytics
					ga('send', 'pageview', document.location.pathname);
				}
				if (typeof _gaq !== 'undefined') {
					_gaq.push(['_trackPageview', document.location.pathname]);
				}
				
				// replace the current page body class with the ajax page's body class
				$('body').attr('class' , $classes );				
				
				// replace the current page title with the ajax page's title
				$('head').find('title').text( new_title );
		
				$($containers).each( function(){
					
					var $container = this;
					var new_content = html.find( $container  ).html();
          			
          			// remove all classes on the container
          			if( 'object' == typeof window.removeClasses ){
						$(window.removeClasses).each( function(){
							$($container).removeClass(this);
						});		
					}

					if( 'undefined' != typeof $classesIn ){
						var $ClassIn = $($classesIn[$container]);
						// add classes to the target div for fade in
						$ClassIn.each( function(){
							$($container).addClass(this);
						});				
					}
					// add new content to the target container
					$($container).html( new_content );
			
				});
                // remove the loading spinner
                if( $egg.options.loadSpinner ){
                    $egg.unloadSpinner();
				}

				// call to cleanup the loader instances
				$egg.refresh();

				if (typeof $customAfterLoad == 'function') {
					// send this ajax object and this instance of the EggLoader to the user's custom function 
					$customAfterLoad.call( this, $egg , postid, new_title , $href ); 
				}
            },
            error: function( xhr )
            {
                console.log(xhr.responseText);
            }
        });
    };

    EggLoader.prototype.loadSpinner = function() {
        var $egg = this,
       		$container = $egg.options.containers[0],	
        	$spinnerUrl = $egg.options.spinnerUrl,
        	$spinnerDiv = $("<div class='" + $egg.options.spinnerClass +"'>");
     
		if( $spinnerUrl ){				
			// add image to spinner div?			
	    }

		// if the target container has a parent, the spinner is added to that, else it's added to body
		if( $( $container ).parent().length ){
			$( $container ).parent().append($spinnerDiv);
		}
		else{
			$( 'body' ).append($spinnerDiv);
		}
    };

    EggLoader.prototype.unloadSpinner = function() {
        $('.ajax-spinner').remove();
    };

	// refresh(): iterates over the global loaderMgmt to find the originally bound selectors in the newly ajax-generated document
    EggLoader.prototype.refresh = function( ) {
		instanceUid = 0;		// resets the instanceUid counter

		// iterates over the EggLoaders in loaderMgmt; removes the old loader; adds the new loader;
		$( window.loaderMgmt ).each( function(index, loaderObj ){
			var $selector = loaderObj.options.selector,
				$options = loaderObj.options;
			var $elements = $($selector);
			$elements.removeData('EggLoader'); 			// is this working??????
			$elements.EggLoader( $options , true);		// second param ("true") signifies this is a reload and refreshed instance isn't added to loaderMgmt
		});		
	};

	// Initial Function: reload variable is default false; true is used for refreshing on an ajax call	 
	$.fn.EggLoader = function( options , reload ) {
	    if ( typeof history.pushState !== "undefined" ){   		// only instantiates an EggLoader if pushState is defined (does not work in IE8 or <)
	        var $elements = this;
			// bail early if no options defined
	        if (typeof options === 'undefined') {
				return false;
			}
			// get origin url for same-origin check
			var origin = window.location,
				oProtocol = origin.protocol,
				oHost = origin.hostname,
				oPort = origin.port;
				
			// allows for EggLoader to be called with ONLY the container selector as a string
			if(typeof options === 'string'){
				var containers = options;
				options = {};
				options.containers = containers;
			}
			
			// collect all classes for removal
			var cIn = options.classesIn;
			if( typeof options.classesIn == 'object' ){
				$.each( cIn , function( $container ){
					var $classArray = cIn[$container];
					if( typeof $classArray == 'object' ){
						$( $classArray ).each( function(){
							if( -1 == $.inArray( this, window.removeClasses ) ){
								window.removeClasses.push(this);
							}					
						});
					}									
				});
			}
			var cOut = options.classesOut;
			if( typeof options.classesOut == 'object' ){
				$.each( cOut , function( $container ){
					var $classArray = cOut[$container];
					if( typeof $classArray == 'object' ){
						$( $classArray ).each( function(){
							if( -1 == $.inArray( this, window.removeClasses ) ){
								window.removeClasses.push(this);
							}					
						});
					}									
				});
			}
			
			// assign the selector from the element to the options 
	        options.selector = $elements.selector;

	        // if no element is matched against selector initialize an empty loader to add to loaderMgmt: 
			// though it's not matched now, the target link may exist on a page generated by ajax and will be searched for after ajax calls
	        if( !$(this.selector).length ){
		        var emptyLoader = new EggLoader( '', options );
		        if( !reload ){ 
	 				window.loaderMgmt.push( emptyLoader );
	 			}
			}
			// matches all elements by selector and initializes a new instance for each matched element
			return $elements.each( function( index, element) {
				//console.log(element.href.protocol);
				var target = document.createElement('a');
					target.href = element.href;
				
				// target/origin comparison of port, protocol and host assures same-origin policy for each link
				if( 'undefined' === typeof $(element).data('instanceUid') && ( oProtocol == target.protocol && oHost == target.hostname) ){	
					var newLoader = new EggLoader(element, options ); 
					$(element).data('EggLoader' , newLoader);
					// binds the EggLoader instance to the element
					$(element).data('instanceUid', newLoader.instanceUid );
					if (!reload){
						window.loaderMgmt.push( newLoader );
					}
				}
	        });
	    }
    };
    function getLoaderInstance( $selector ){
	    var $loader;
		$(window.loaderMgmt).each( function( index, loaderObj ){
			if( $selector == loaderObj.options.selector){
				$loader = loaderObj;
				return false;
			}
		});
		return $loader;
    }
    function popStateHandler(e){ 
	    if(e.state && 'object' !== typeof e.state){
		    document.location.reload();
	    }
	    else if( window.history.state !== null ){				// checks if the requested page was an ajax call 
			// gets the original selector (for example: '#pushState a' )
			// then iterates over all the original selectors stored in loaderMgmt 
			// and finds the appropriate EggLoader instance for the requested page
			// and the options from that EggLoader are used to refresh the page
			
			var $triggerSelector = window.history.state.selector,
				$href = document.location.href;					
			$(window.loaderMgmt).each( function( index, loaderObj ){
				if( $triggerSelector == loaderObj.options.selector){
					var $containers = $(loaderObj.options.containers),
						$classesOut = $($(loaderObj.options.classesOut))[0],
						emptyLoader = new EggLoader( '', loaderObj.options );
					
					// add fade out class to container
					$($containers).each( function(){
						var $container = $(this);
						// remove all classes on the container
	          			if( 'object' == typeof window.removeClasses ){
							$(window.removeClasses).each( function(){
								$($container).removeClass(this);
							});		
						}
						if('undefined' != typeof $classesOut ){ 			
							var $ClassOut = $($classesOut[this]);
							// add classes to the target div for fade in
							$ClassOut.each( function(){
								$container.addClass(this);
							});
						}
					});
					emptyLoader.refresh();
					emptyLoader.href = $href;
					emptyLoader.loadTarget();
					return false;							
				}
			});
		}
	}
    if ( typeof history.pushState !== "undefined" ){   					// history.pushState is undefined for IE8 and lower;
	    // we'll use this state on popstate to see if the pge has been ajaxed or not (if it's ajaxed the state will be an object, not a boolean);
	    history.replaceState(true, null, window.location.pathname);
		window.addEventListener('popstate', popStateHandler, false);
	}	
}( jQuery ));