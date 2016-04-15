<?php 
	$transient_key   = 'weather_xml';
	$content = null;
	if ( false === ($content = get_transient($transient_key)) ) :
		$file = "http://w1.weather.gov/xml/current_obs/display.php?stid=KSNA";
		$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $file );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 2 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_USERAGENT, get_option('blogname') . '/1.0' );
			curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
			$result = curl_exec( $ch );
		curl_close($ch);

		if ( 0 === strpos($result, '<?xml') ) :
			$content = $result;
			set_transient( $transient_key, $content, HOUR_IN_SECONDS );
		endif;
	endif;

    if ( $content ) :
		$data = @simplexml_load_string($content); ?>
		<span class="weather-title">CURRENT WEATHER</span>
<?php //print_r($data);
		if (! $data ) : ?>
			<span class="no-weather">&nbsp;</span>
<?php 	else:
			if (! empty($data->icon_url_name) ) : ?>
				<span class="icon icon-<?php echo ph_weather_icon($data->icon_url_name); ?>" aria-hidden="true"></span>
<?php 		endif;
			if (! empty($data->weather) ) : ?>
				<span class="screen-reader-text"><?php echo esc_html($data->weather); ?></span>
<?php 		endif;
			if (! empty($data->temp_f) ) : ?>
				<span class="temperature temperature-f"><?php echo esc_html( floor($data->temp_f) ); ?>&#186;</span>
<?php 		endif;
		endif;
?>
		</span>
<?php
	endif;
?>
