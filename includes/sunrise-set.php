<?php
	/*
	 * Sunrise-Set checks the time and sets class on body
	 */

	add_action('wp_footer', 'toggle_sunrise_set');
	add_filter( 'body_class', 'sunrise_set_class' );
	
	function is_sunrise_set_enabled(){
		// Cookie is set with javascript in toggle_sunrise_set()
		if( 'disabled' == $_COOKIE['sunrise_set_state'] ){
			return false;
		}
		else{
			return true;
		}
	}
	function get_day_or_night(){
		// Sunrise/set in 24 hour decimal ( 7:30 pm = 19.50 )
		// Roadmap: pull in local sunrise/sunset calendar
		$sunrise = 7.5;
		$sunset = 19;
		
		// gets the wordpress current time
		$timestamp = current_time( 'timestamp' );
		$timestamp = 1418048881;
		$hour = date_i18n( 'H' , $timestamp );
		$minute_decimal = round( date_i18n( 'i' , $timestamp ) / 60 , 2);
		$time = ( $hour + $minute_decimal );
		
		$time = 20;
		if( $time > $sunrise && $time < $sunset ){
			$phase = 'day';			
		}else{
			$phase = 'night';
		}		
		return $phase;
	}
	// Hooks the body_class() function and adds the appropriate class if the this is enabled by the user
	function sunrise_set_class( $classes ) {
		if( is_sunrise_set_enabled() ){
			$classes[] = get_day_or_night();
		}		
		return $classes;
	}
	
	/*
	 * builds the toggle link in the footer
	 */
	function toggle_sunrise_set(){
		// $phase is 'day' or 'night'
		$phase = get_day_or_night(); 
		
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
		// The following is output to the footer. Css Styles are for development testing only and should be deleted
		?>
		
		<div class="weather sixcol first">
			<?php 
			$weather_xml = ph_get_weather();
			if ( $weather_xml ) : ?>
				<span class="weather-title">CURRENT WEATHER</span>
				<?php if (! $weather_xml ) : ?>
					<span class="no-weather">&nbsp; Weather not available</span>
				<?php else : ?>
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
					document.cookie = 'sunrise_set_state=disabled';
					// the data-attribute of the toggling link is changed to 'disabled'
					toggle.dataset.state = 'disabled';
					// the correct phase (day or night) is removed from the body class 
					$body.className = $body.className.replace(/\b<?php echo $phase; ?>\b/,'');
					// the toggle text is changed;
					toggle.innerHTML = "<?php echo $enableText; ?>";  
				}
				else{
					$body.className+= ' <?php echo $phase; ?>';
					document.cookie = 'sunrise_set_state=enabled';
					toggle.dataset.state = 'enabled';
					toggle.innerHTML = "<?php echo $disableText; ?>";  
				}
			}
		</script>
	
	<?php } 

	/************* WEATHER FUNCTIONS *****************/
	
	function ph_get_weather()
	{
		if ( false === ($weather_xml = get_transient('weather_xml')) )
		{
			$file            = "http://w1.weather.gov/xml/current_obs/display.php?stid=KDMA";
			$weather_content = file_get_contents($file);
			$weather_xml     = json_encode( @simplexml_load_string($weather_content) );
			set_transient( 'weather_xml', $weather_xml, 30 * MINUTE_IN_SECONDS );
		}
		return json_decode($weather_xml);
	}
?>