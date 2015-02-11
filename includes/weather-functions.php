<?php
	/*
	Plugin Name: eggWeather
	Description: CreativeSlice's Custom Weather Integration
	Version: 1.0
	Author: Trip Grass
	*
	* To allow the modifying of the body class, ensure the body tag is like so: <body <?php body_class(); ?>>
	*
	* To add the enable/disable button: <?php add_weather_button(); ?>				
	* To customize the button, use the $defaults array 
	*
	* To get a weather option: <?php echo get_weather_option('sunrise'); ?>
	* Options include: 'sunrise', 'sunset', 'weather', 'temp_f' and more
	*
	* To view all the options on the front-end as a UL: <?php echo list_eggOptions(); ?> 
	*/

	class eggWeather{
		
		public function __construct( $options = null ) {
			
			$defaults = array(
				"enableCookie" => false,											// boolean
				"buttonClass" => "button",										// string
				"buttonId" => "sunrise-sunset-toggle",							// string
				"disableText" => "Turn off the sunrise/sunset, please.",		// string
				"enableText" => "Turn the sunrise/sunset back on. That's slick."	// string
	        );
	        $this->options = wp_parse_args( $options , $defaults );	

			// adds page to admin menu in order to define the NOAA weather station
			add_action('admin_menu', array($this, 'create_theme_options_page') );
		
			// load admin functions on admin page only
			add_action( 'admin_menu', array( $this, 'weather_admin_functions') );
			
			// gets the weather station from transient
			$this->weather_station = get_option('weather_station');		
	
			// sets up an XML object of the weather
			$this->egg_get_weather();
	
			// adds the correct class to the body tag
			add_filter( 'body_class', array( $this , 'sunrise_set_class') );
						
			$this->get_day_or_night();
		}
		function is_sunrise_set_enabled(){
			if( $this->options['enableCookie'] ){
				// Cookie is set with javascript in toggle_sunrise_set()
				if (isset($_COOKIE['sunrise_set_state'])){
					if( 'disabled' == $_COOKIE['sunrise_set_state'] ){
						return false;
					}
					else{
						return true;
					}
				}
				else{
					return false;
				}
			}
			else{
				return true;
			}
		}

		// 
		private function timeFromDouble( $double ){
			$hour = floor( $double );
			$minute = round( ($double - $hour) * 60 );
			$minute = sprintf("%02d", $minute);
			if($hour > 12 ){
				$hour = $hour - 12;
			}
			$time = $hour . ":" .$minute; 
			return $time;
		}
		private function get_day_or_night(){
			$this->lat = get_option('weather_lat');		
			$this->lon = get_option('weather_lon');		
			// Roadmap: could pull in lat long from the timezone location 
			$offset = get_option('gmt_offset'); 
			$sunrise = date_sunrise(time(), SUNFUNCS_RET_DOUBLE , $this->lat , $this->lon ,90 , $offset );
			$sunset = date_sunset(time(), SUNFUNCS_RET_DOUBLE , $this->lat , $this->lon , 90 , $offset);
			$this->sunrise = $this->timeFromDouble($sunrise);
			$this->sunset = $this->timeFromDouble($sunset);
			
			// gets the wordpress current time
			$timestamp = current_time( 'timestamp' );
			$hour = date_i18n( 'H' , $timestamp );
			$minute_decimal = round( date_i18n( 'i' , $timestamp ) / 60 , 2);
			$time = ( $hour + $minute_decimal );
			if( $time > $sunrise && $time < $sunset ){
				$this->phase = 'day';			
			}else{
				$this->phase = 'night';
			}		
		}
	
		// Hooks the body_class() function and adds the appropriate class 
		public function sunrise_set_class( $classes ) {
			if( $this->is_sunrise_set_enabled() ){
				$classes[] = $this->phase;		
			}
			return $classes;
		}
	
		public function egg_get_weather(){
			if ( false === ($weather_xml = get_transient('weather_xml')) ){
				$file            = "http://w1.weather.gov/xml/current_obs/display.php?stid=$this->weather_station";
				$weather_content = @file_get_contents($file);
				$weather_arr 	= @simplexml_load_string($weather_content);
				$weather_xml    = json_encode( $weather_arr );
				if( $weather_xml != 'false' ){
					set_transient( 'weather_xml', $weather_xml, 30 * MINUTE_IN_SECONDS );
				}
			}
			$this->weather = json_decode($weather_xml);
		}
		
		// Add Custom Admin Menu
		public function create_theme_options_page() {
			add_options_page( 'Weather Settings ' , 'Weather' , 'manage_options','weather-settings.php', array($this,'weather_settings'));
		}
	
		public function weather_settings(){ ?>
	
			<form  name='weather_station_form' action='' method='POST'>
				<table class='form-table'>
					<tbody>
						<?php if(@$this->station_message) :?>
						<tr>
							<th><?php echo @$this->station_title; ?></th>
							<td><?php echo $this->station_message; ?></td>
						</tr>

						<?php endif; ?> 
						
						<tr>
							<p>Find your local Weather Station ID from <a target="_blank" href='http://www.nws.noaa.gov/om/osd/portal.shtml'>NOAA</a> in the Automated Surface Stations and enter it below. For example, Tucson would be 'KDMA'.</p>
						</tr>
						<tr>
							<th>Weather Station ID
							</th>
							<td>
								<input type='text' name='weather_station' value='<?php echo $this->weather_station; ?>'>
							</td>
						</tr>
						<tr>
							<th>Your Wordpress Timezone is:</th>
							<td><a href='/wp-admin/options-general.php'><?php echo get_option('timezone_string'); ?></a></td>
						</tr>
					</tbody>
				</table>
				<button type='submit' class='button button-primary' style=''>Save Settings</button>
				
				<?php if( 'object' == gettype($this->weather) ) : $weather = get_weather_option('icon_url_name'); ?>
						
						<div>
							<h2>Current Settings for <?php echo strtoupper( $this->weather_station ); ?></h2>
							<span>class : <?php echo strtok($weather, '.'); ?></span>
							<br />
							<?php echo get_weather_option('temp_f'); ?>&deg;F and <?php echo get_weather_option('weather'); ?> in Tucson<br />
							Sunrise <?php echo get_weather_option('sunrise'); ?>am / Sunset <?php echo get_weather_option('sunset'); ?>pm
						</div>
						
					<?php endif; ?>
			</form>

		<?php }
	
		// adds the weather options to the transient on the admin page
		public function weather_admin_functions(){
			if(isset( $_POST['weather_station'] )){
				$this->weather_station	= $_POST['weather_station'];		
				$file            	= "http://w1.weather.gov/xml/current_obs/display.php?stid=$this->weather_station";
				$weather_content 	= @file_get_contents($file);
				$weather_arr 		= @simplexml_load_string($weather_content);
				if( 'object' == gettype($weather_arr)){
					$weather_lat 		= (string)$weather_arr->latitude;
					$weather_lon 		= (string)$weather_arr->longitude;
					update_option( 'weather_lat', $weather_lat );
					update_option( 'weather_lon', $weather_lon );
					update_option('weather_station', $_POST['weather_station'], '', '' );
					$this->station_message = "Your station has been saved.  ";	
				}
				else{
					$this->weather_station = "";
					$this->station_title = "STATION ERROR.";	
					$this->station_message = "There was a problem finding that station. Double check the spelling.  ";	
				}
			}
			
		}
		
		// just an easy way to see what options are available for output
		public function list_options(){
			if(count( $this->weather ) > 0 ){
				echo "Weather options:<ul>";
				foreach($this->weather as $key=>$val){
					if( gettype($key) == 'string' &&  gettype($val) == 'string' ){
						echo "<li>".$key." : " .$val."</li>";
					}
				}
				echo "</ul>";
			}
		}

		// 
		public function get_weather_option( $option ){
			$option = strtolower($option); 
			if( $option == 'sunrise'){
				return $this->sunrise;
			}
			if( $option == 'sunset'){
				return $this->sunset;
			}
			if( count( $this->weather ) > 0 ){
				if( isset($this->weather->$option) && gettype( $this->weather->$option ) == 'string'  ){
					if( $option == 'temp_f' ){
						$output = intval( $this->weather->$option );
					}
					else{
						$output = $this->weather->$option;
					}
					return $output;
				}
			}
		}

		// add the button to enable or disable the weather response on the front-end
		public function add_weather_button(){
			if( $this->is_sunrise_set_enabled() ){
				$state = 'enabled';
				$text = $this->options['disableText'];
			}
			else{
				$state = 'disabled'; 
				$text = $this->options['enableText'];
			}
			add_action('wp_footer',  array( $this , 'weather_script_output') );
			echo "<a class='" .$this->options['buttonClass'] ."' id='". $this->options['buttonId'] ."' onClick='toggle_sunrise_set()' style='cursor:pointer' data-state='".$state."'>".$text."</a>";
		}
		
		
		// weather script prints the necessary javascript to the footer		
		function weather_script_output(){ ?>

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
						$body.className = $body.className.replace(/\b<?php echo $this->phase; ?>\b/,'');
						// the toggle text is changed;
						toggle.innerHTML = "<?php echo $this->options['enableText']; ?>";  
					}
					else{
						$body.className += ' <?php echo $this->phase; ?>';
						document.cookie = 'sunrise_set_state=enabled; path=/';
						toggle.dataset.state = 'enabled';
						toggle.innerHTML = "<?php echo $this->options['disableText']; ?>";  
					}
				}
			</script>
	
		<?php }
		function custom_weather(){
			$weather = $this->get_weather('class');
			if($this->weather){
				$temp = $this->weather->temp_f;
				
				if( $weather == 'sun' && $temp > 99 ){
					return "blazingly hot";
				}
				if( $weather == 'sun' && $temp < 99 ){
					return "Beautiful";
				}
				return $this->get_weather();
			}
		}
		// $type is 'class' or 'text' - empty is text
		function get_weather( $type = null ){
			if( $this->weather && $icon_url = $this->weather->icon_url_name ){
				switch ( $icon_url ){
			        
			        // Sun (sun)
			        case 'few.png' 		:	// Few Clouds
			        case 'skc.png' 		:	// Clear
			            if( $type == 'class' ){
				            return 'sun';
				        }
				        else{
					        return 'sunny';
				        }
			            break;
			            
			        // Moon (moon)
			        case 'nfew.png' 	:	// Few Clouds
			        case 'nskc.png' 	:	// Clear
			            if( $type == 'class' ){
				            return 'moon';
			            }
				        else{
					        return 'clear';
				        }
			            break;
			
			        // Cloud (cloud)
			        case 'dust.png' 	:	// Dust
			        case 'mist.png' 	:	// Mist
			        case 'sn.png' 		:	// Snow
			        case 'smoke.png' 	:	// Smoke
			        case 'fg.png' 		:	// Fog
			        case 'ovc.png' 		:	// Overcast
			        case 'bkn.png' 		:	// Mostly Cloudy
			            if( $type == 'class' ){
				            return 'cloud';
			            }
				        else{
					        return 'cloudy';
				        }
			            break;
			            
			        // Cloud Night (cloud2)
			        case 'nsn.png' 		:	// Snow
			        case 'nfg.png' 		:	// Fog
			        case 'novc.png' 	:	// Overcast
			        case 'nbkn.png' 	:	// Mostly Cloudy
			            if( $type == 'class' ){
				            return 'cloud2';
			            }
				        else{
					        return 'cloudy';
				        }
			            break;
			
			        // Partial Cloud (cloudy)
			        case 'sct.png' 		:	// Partly Cloudy
			            if( $type == 'class' ){
				            return 'cloudy';
			            }
				        else{
					        return 'cloudy';
				        }
			            break;
			            
			        // Partial Cloud Night (cloud3)
			        case 'nsct.png' 	:	// Partly Cloudy
			            if( $type == 'class' ){
				            return 'cloud3';
			            }
				        else{
					        return 'cloudy';
				        }
			            break;
			
			        // Snow (snowy2)
			        case 'ip.png' 		:	// Ice Pellets
			        case 'mix.png' 		:	// Freezing Rain Snow
			        case 'rasn.png' 	:	// Rain Snow
			            if( $type == 'class' ){
				            return 'snowy2';
			            }
				        else{
					        return 'snowing';
				        }
			            break;
			        
			        // Snow Night (snowy)
			        case 'nmix.png' 	:	// Freezing Rain Snow
			        case 'nrasn.png' 	:	// Rain Snow
			            if( $type == 'class' ){
				            return 'snowing';
			            }
				        else{
					        return 'snowing';
				        }
			            break;
			
			        // Rain (rainy2)
			        case 'hi_shwrs.png' :	// Showers
			        case 'ra.png' 		:	// Rain
			        case 'ra1.png' 		:	// Light Rain
			        case 'fzra.png' 	:	// Freezing rain
			        case 'raip.png' 	:	// Rain Ice Pellets
			        case 'shra.png' 	:	// Rain Showers
			        case 'fzrara.png' 	:	// Freezing Rain Rain
			            if( $type == 'class' ){
				            return 'rainy2';
			            }
				        else{
					        return 'raining';
				        }
			            break;
			        
			        // Rain Night (rainy)
			        case 'hi_nshwrs.png':	// Showers
			        case 'nra.png' 		:	// Rain
			        case 'nra1.png' 	:	// Light Rain
			            if( $type == 'class' ){
				            return 'rainy';
			            }
				        else{
					        return 'raining';
				        }
			            break;
			
			        // Lightning (lightning2)
			        case 'tsra.png' 	:	// Thunderstorm
			        case 'hi_tsra.png' 	:	// Thunderstorm
			            if( $type == 'class' ){
				            return 'lightning2';
			            }
				        else{
					        return 'stormy';
				        }
			            break;
			            
			        // Lightning Night (lightning)
			        case 'ntsra.png' 	:	// Thunderstorm
			        case 'hi_ntsra.png'	:	// Thunderstorm
			            if( $type == 'class' ){
				            return 'lightning';
			            }
				        else{
					        return 'stormy';
				        }
			            break;
			
			        // Wind (wind)
			        case 'wind.png' 	:	// Windy
			        case 'nwind.png' 	:	// Windy
			            if( $type == 'class' ){
				            return 'wind';
			            }
				        else{
					        return 'windy';
				        }
			            break;
			    }
			}
		}
		
			
	}
	global $eggWeather;
	$eggWeather = new eggWeather();
	function add_weather_button(){
		global $eggWeather;
		$eggWeather->add_weather_button();
	}
	function list_eggOptions(){
		global $eggWeather;
		$eggWeather->list_options();
	}
	function get_weather( $type ){
		global $eggWeather;
		return $eggWeather->get_weather( $type );
	}
	function custom_weather(){
		global $eggWeather;
		return $eggWeather->custom_weather();
	}
	function get_weather_option( $option ){
		global $eggWeather;
		return $eggWeather->get_weather_option( $option );
	}
			
?>