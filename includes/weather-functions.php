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
	function timeFromDouble( $double ){
		$hour = floor( $double );
		$minute = round( ($double - $hour) * 60 );
		if($hour > 12 ){
			$hour = $hour - 12;
		}
		$time = $hour . ":" .$minute; 
		return $time;
	}
	function get_day_or_night(){
		// Roadmap: could pull in lat long from the timezone location 
		$offset = get_option('gmt_offset'); 
		$sunrise = date_sunrise(time(), SUNFUNCS_RET_DOUBLE , 32.13 , -110.55 ,90 , $offset );
		$sunset = date_sunset(time(), SUNFUNCS_RET_DOUBLE , 32.13 , -110.55 , 90 , $offset);
		$phase_array['sunrise'] = timeFromDouble($sunrise);
		$phase_array['sunset'] = timeFromDouble($sunset);
		
		// gets the wordpress current time
		$timestamp = current_time( 'timestamp' );
		$hour = date_i18n( 'H' , $timestamp );
		$minute_decimal = round( date_i18n( 'i' , $timestamp ) / 60 , 2);
		$time = ( $hour + $minute_decimal );
		if( $time > $sunrise && $time < $sunset ){
			$phase_array['phase'] = 'day';			
		}else{
			$phase_array['phase'] = 'night';
		}		
		return $phase_array;
	}
	// Hooks the body_class() function and adds the appropriate class if the this is enabled by the user
	function sunrise_set_class( $classes ) {
		if( is_sunrise_set_enabled() ){
			$classes[] = get_day_or_night();
		}		
		return $classes;
	}
	function egg_get_weather()
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