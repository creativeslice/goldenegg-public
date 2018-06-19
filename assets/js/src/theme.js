/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	
	/**
    * fallback for SVG icons in IE
    */
    svg4everybody();
	
	
	/**
     * Expandable Blocks FAQ
     */
    $('.faq-block .question').click(function(e) {
        e.preventDefault();
		var hasOpen = $(this).hasClass('open');
		var answer = $(this).next('.answer');
        // close all the others
        $('.faq-block .question.open').removeClass('open');
        $('.answer.shown').slideUp();
        if (!hasOpen) {
            $(this).addClass('open');
            answer.slideDown().addClass('shown');
        }
    });
    
	
});