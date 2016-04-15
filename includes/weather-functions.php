<?php

/************* WEATHER FUNCTIONS *****************/

function ph_get_weather()
{
	if ( false === ($weather_xml = get_transient('weather_xml')) )
	{
		$file            = "http://w1.weather.gov/xml/current_obs/display.php?stid=KSNA";
		$weather_content = file_get_contents($file);
		$weather_xml     = new SimpleXMLElement($weather_content);
		set_transient( 'weather_xml', $weather_xml, 30 * MINUTE_IN_SECONDS );
	}
	return $weather_xml;
}

function ph_weather_icon( $feed_image )
{
	switch ( $feed_image )
	{
		// Sun (sun)
		case 'few.png' : 			// Few Clouds
		case 'skc.png' : 			// Clear
			return 'sun';
			break;
		// Moon (moon)
		case 'nfew.png' : 			// Few Clouds
		case 'nskc.png' : 			// Clear
			return 'moon';
			break;

		// Cloud (cloud)
		case 'dust.png' : 			// Dust
		case 'mist.png' : 			// Mist
		case 'sn.png' : 			// Snow
		case 'smoke.png' : 			// Smoke
		case 'fg.png' : 			// Fog
		case 'ovc.png' : 			// Overcast
		case 'bkn.png' : 			// Mostly Cloudy
			return 'cloud';
			break;
		// Cloud Night (cloud2)
		case 'nsn.png' : 			// Snow
		case 'nfg.png' : 			// Fog
		case 'novc.png' : 			// Overcast
		case 'nbkn.png' : 			// Mostly Cloudy
			return 'cloud2';
			break;

		// Partial Cloud (cloudy)
		case 'sct.png' : 			// Partly Cloudy
			return 'cloudy';
			break;
		// Partial Cloud Night (cloud3)
		case 'nsct.png' : 			// Partly Cloudy
			return 'cloud3';
			break;

		// Snow (snowy2)
		case 'ip.png' :				// Ice Pellets
		case 'mix.png' :			// Freezing Rain Snow
		case 'rasn.png' :			// Rain Snow
			return 'snowy2';
			break;
		// Snow Night (snowy)
		case 'nmix.png' :			// Freezing Rain Snow
		case 'nrasn.png' :			// Rain Snow
			return 'snowy';
			break;

		// Rain (rainy2)
		case 'hi_shwrs.png' : 		// Showers
		case 'ra.png' : 			// Rain
		case 'ra1.png' : 			// Light Rain
		case 'fzra.png' : 			// Freezing rain
		case 'raip.png' :			// Rain Ice Pellets
		case 'shra.png' :			// Rain Showers
		case 'fzrara.png' :			// Freezing Rain Rain
			return 'rainy2';
			break;
		// Rain Night (rainy)
		case 'hi_nshwrs.png' : 		// Showers
		case 'nra.png' : 			// Rain
		case 'nra1.png' : 			// Light Rain
			return 'rainy';
			break;

		// Lightning (lightning2)
		case 'tsra.png' :			// Thunderstorm
		case 'hi_tsra.png' :		// Thunderstorm
			return 'lightning2';
			break;
		// Lightning Night (lightning)
		case 'ntsra.png' :			// Thunderstorm
		case 'hi_ntsra.png' :		// Thunderstorm
			return 'lightning';
			break;

		// Wind (wind)
		case 'wind.png' :			// Windy
		case 'nwind.png' :			// Windy
			return 'wind';
			break;
	}
}