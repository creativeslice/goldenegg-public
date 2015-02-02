<?php
 /*
  * From the smashingmagazine.com article: http://www.smashingmagazine.com/2014/09/08/improving-smashing-magazine-performance-case-study/
  * Javascript method for cacheing base64 encoded fonts to localStorage OR asynchronously loading
  *
  * add the following to header.php between </head> and <body>: <?php get_template_part( 'includes/function', 'font-loader' ); ?>
  *
  * base64 encoded font file should be one or a series of @font-face definitions like this:
  * 	@font-face { font-family:'Lust'; src: url("data:font/opentype;base64,AAEAAA.......o=") format('opentype'); }@font-face { font-family:'Lust'; +++++ etc...
  */
    
  // Hardcode your path to your base64 encoded fonts:
  $base64_path = get_template_directory_uri().'/assets/css/lust-base64.css';
  
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
    (function () {
      "use strict";
      // once cached, the css file is stored on the client forever unless
      // the URL below is changed. Any change will invalidate the cache
      var css_href = '<?php echo $base64_path; ?>';
      // a simple event handler wrapper
      function on(el, ev, callback) {
        if (el.addEventListener) {
          el.addEventListener(ev, callback, false);
        } else if (el.attachEvent) {
          el.attachEvent("on" + ev, callback);
        }
      }
      
      // if we have the fonts in localStorage or if we've cached them using the native batrowser cache
      if ((window.localStorage && localStorage.font_css_cache) || document.cookie.indexOf('font_css_cache') > -1){
        // just use the cached version
        injectFontsStylesheet();
      } else {
       // otherwise, don't block the loading of the page; wait until it's done.
        on(window, "load", injectFontsStylesheet);
      }
      
      // quick way to determine whether a css file has been cached locally
      function fileIsCached(href) {
        return window.localStorage && localStorage.font_css_cache && (localStorage.font_css_cache_file === href);
      }

      // time to get the actual css file
      function injectFontsStylesheet() {
       // if this is an older browser
        if (!window.localStorage || !window.XMLHttpRequest) {
          var stylesheet = document.createElement('link');
          stylesheet.href = css_href;
          stylesheet.rel = 'stylesheet';
          stylesheet.type = 'text/css';
          document.getElementsByTagName('head')[0].appendChild(stylesheet);
          // just use the native browser cache
          // this requires a good expires header on the server
          document.cookie = "font_css_cache";
        
        // if this isn't an old browser
        } else {
           // use the cached version if we already have it
          if (fileIsCached(css_href)) {
            injectRawStyle(localStorage.font_css_cache);
          // otherwise, load it with ajax
          } else {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", css_href, true);
            // cater for IE8 which does not support addEventListener or attachEvent on XMLHttpRequest
            xhr.onreadystatechange = function () {
              if (xhr.readyState === 4) {
                // once we have the content, quickly inject the css rules
                injectRawStyle(xhr.responseText);
                // and cache the text content for further use
                // notice that this overwrites anything that might have already been previously cached
                localStorage.font_css_cache = xhr.responseText;
                localStorage.font_css_cache_file = css_href;
              }
            };
            xhr.send();
          }
        }
      }

      // this is the simple utitily that injects the cached or loaded css text
      function injectRawStyle(text) {
        var style = document.createElement('style');
        // cater for IE8 which doesn't support style.innerHTML
        style.setAttribute("type", "text/css");
        if (style.styleSheet) {
            style.styleSheet.cssText = text;
        } else {
            style.innerHTML = text;
        }
        document.getElementsByTagName('head')[0].appendChild(style);
      }

    }());
 //--><!]]></script>
