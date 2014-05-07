(function($) {
	$.fn.extend( {
		limiter: function()
		{
			var $this      = $(this),
				limit      = $this.attr('maxlength'),
				$counter   = $('<span />', {'class' : 'counter', 'style' : 'font-weight: bold'});
				$container = $('<div />', {'class' : 'countdown', 'html' : ' characters left'});

			if ( limit )
			{
				$this
					.removeAttr('maxlength')
					.after( $container.prepend($counter) )
					.on("keyup focus", function() {
						$counter.set_counter( $this, limit );
					});
			}

			$counter.set_counter( $this, limit );
		},
		set_counter: function( $target, limit )
		{
			var $this = $(this),
				text  = $target.val(),
				chars = text.length;
			$(this).html( limit - chars );
			if ( chars > limit )
			{
				$this.css({'color' : 'red'});
			}
			else
			{
				$this.css({'color' : 'black'});
			}
		}
	});
})(jQuery);

jQuery(document).ready(function($) {

	$('#acf-field-meta_title, #acf-field-meta_description').each(function() {
		$(this).limiter();
	});

});