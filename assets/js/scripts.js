function updateViewportDimensions(){var t=window,e=document,i=e.documentElement,n=e.getElementsByTagName("body")[0],o=t.innerWidth||i.clientWidth||n.clientWidth,a=t.innerHeight||i.clientHeight||n.clientHeight;return{width:o,height:a}}var viewport=updateViewportDimensions(),waitForFinalEvent=function(){var t={};return function(e,i,n){n||(n="Don't call this twice without a uniqueId"),t[n]&&clearTimeout(t[n]),t[n]=setTimeout(e,i)}}(),timeToWaitForLast=100;jQuery(document).ready(function(t){t("#mobilemenu").click(function(e){e.preventDefault();var i=t(this);i.toggleClass("active"),t("span",this).toggleClass("icon-menu").toggleClass("icon-close"),t(".top-nav").slideToggle(200)}),t("span[aria-hidden=true]").each(function(){var e=t(this),i=e.siblings(".screen-reader-text");i.length&&e.attr("title",i.text())}),t(".expandblock").click(function(e){e.preventDefault(),t(this).toggleClass("active"),t(this).next(".expandcontent").slideToggle(200)})});