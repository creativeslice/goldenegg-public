/*
 * Wrap jQuery JS in ready class
*/
window.addEventListener('load', function ()  {


	/**
	* fallback for SVG icons in IE
	*/
	svg4everybody();


	/*
	 * Prevent Widows in h1 articleHeader
	 * todo(scd) show a simple vanilla javascript to show code style
	 */
	$('.articleHeader h1').each(function () {
		var string = $(this).html();
		string = string.replace(/ ([^ ]*)$/, '&nbsp;$1');
		$(this).html(string);
	});


});
