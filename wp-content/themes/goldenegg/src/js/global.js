/*
 * Wrap jQuery JS in ready class
*/
import svg4everybody from "../libs/svg4everybody.min.js";

jQuery(document).ready(function($) {
	
	/**
	* fallback for SVG icons in IE
	*/
	svg4everybody();
	
	/*
	 * Prevent Widows in h1 articleHeader
	 */
	$('.articleHeader h1').each(function () {
		var string = $(this).html();
		string = string.replace(/ ([^ ]*)$/, '&nbsp;$1');
		$(this).html(string);
	});
	

});
