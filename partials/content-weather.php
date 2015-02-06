<?php
		// $phase is 'day' or 'night'
		$phase_array = get_day_or_night(); 
		$sunrise = $phase_array['sunrise'];
		$sunset = $phase_array['sunset'];
		$phase = $phase_array['phase'];

		// Text is text to show in the footer. Customize as necessary. Is output as javascript so avoid quotes: " 
		$disableText = "Turn off the sunrise/sunset, please.";
		$enableText = "Turn the sunrise/sunset back on. That's slick.";
		if( is_sunrise_set_enabled() ){
			$state = 'enabled';
			$text = $disableText;
		}
		else{
			$state = 'disabled'; 
			$text = $enableText;
		}
?>
<div class="weather">
	<?php 
	$weather_xml = egg_get_weather();
	if ( $weather_xml ) : ?>
		<?php if (! $weather_xml ) : ?>
			<span class="no-weather">&nbsp; Weather not available</span>
		<?php else : ?>
			<?php if( count($phase_array)>0 ) : ?><span>Sunrise: <?php echo $sunrise; ?> | Sunset: <?php echo $sunset; ?></span><?php endif; ?>
			<?php if (! empty($weather_xml->weather) ) : ?><span class=""><?php echo $weather_xml->weather; ?></span><?php endif; ?>
		<?php endif;
	endif; ?>
</div>


<style>
body.day{
	background-color:yellow !important;
}
body.night{
	background-color:black !important;
}
</style>

<a id='sunrise-sunset-toggle' onClick='toggle_sunrise_set()' style='cursor:pointer' data-state='<?php echo $state; ?>'><?php echo $text; ?></a>

<script type='text/javascript'>
	function toggle_sunrise_set(){
		var $body = document.getElementsByTagName('body')[0];
		var toggle = document.getElementById( 'sunrise-sunset-toggle' );
		var state = toggle.dataset.state;
		// if functionality is currently enabled
		if( 'enabled' == state ){
			// the cookie is set to disabled
			document.cookie = 'sunrise_set_state=disabled; path=/';
			// the data-attribute of the toggling link is changed to 'disabled'
			toggle.dataset.state = 'disabled';
			// the correct phase (day or night) is removed from the body class 
			$body.className = $body.className.replace(/\b<?php echo $phase; ?>\b/,'');
			// the toggle text is changed;
			toggle.innerHTML = "<?php echo $enableText; ?>";  
		}
		else{
			$body.className+= ' <?php echo $phase; ?>';
			document.cookie = 'sunrise_set_state=enabled; path=/';
			toggle.dataset.state = 'enabled';
			toggle.innerHTML = "<?php echo $disableText; ?>";  
		}
	}
</script>
