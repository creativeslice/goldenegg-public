<?php
	/*
	 * Sunrise-Set checks the time and sets class on body
	 *
	 * output the html using:      <?php get_template_part( 'partials/content', 'weather' );	?>
	 */
	 
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