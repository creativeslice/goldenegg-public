<?php
	/*
	Plugin Name: eggWeather
	Description: CreativeSlice's Custom Weather Integration using Yahoo yql
	Version: 0.1
	Author: Trip Grass
	*
	* To allow the modifying of the body class, ensure the body tag is like so: <body <?php body_class(); ?>>
	*
	* To add the enable/disable button: <?php add_weather_button(); ?>				
	* To customize the button, use the $defaults array 
	*
	* To get a weather option: <?php echo get_weather_option('sunrise'); ?>
	* Options include: 'sunrise', 'sunset' and 'temp_f'
	*
	* 	Following is example code that could be included in the footer.php:
	*
	*		<a class="emblem <?php echo get_weather('class'); ?>" href="/contact/">
	*		    <?php get_template_part( '/partials/logo', 'emblem' ); ?>
	*		</a>
	*		
	*		<?php echo get_weather_option('temp_f'); ?>&deg;F and <em><?php echo custom_weather(); ?></em> in Tucson<br />
	*		Sunrise <?php echo get_weather_option('sunrise'); ?> / Sunset <?php echo get_weather_option('sunset'); ?>
	*/

	class eggWeather{
		
		public function __construct( $options = null ) {
			
			$defaults = array(
				"enableCookie" => false,											// boolean
				"buttonClass" => "button",											// string
				"buttonId" => "sunrise-sunset-toggle",								// string
				"disableText" => "Turn off the sunrise/sunset.",					// string
				"enableText" => "Turn the sunrise/sunset back on, please."			// string
	        );
	        $this->options = wp_parse_args( $options , $defaults );	

			// adds page to admin menu in order to set the local city
			add_action('admin_menu', array($this, 'create_theme_options_page') );
		
			// load admin functions on admin page only
			add_action( 'admin_menu', array( $this, 'weather_admin_functions') );
			
			// gets the weather station from transient
			$this->weather_station = get_option('weather_station');		
	
			// sets up an JSON object of the weather
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
			// gets the wordpress current time
			$timestamp = current_time( 'timestamp' );
			$hour = date_i18n( 'H' , $timestamp );
			$minute_decimal = round( date_i18n( 'i' , $timestamp ) / 60 , 2);
			$time = ( $hour + $minute_decimal );
			$sunrise = 	floatval( date('H', strtotime( $this->sunrise )) + "." + date('i', strtotime( $this->sunrise ))/60 );
			$sunset = 	floatval( date('H', strtotime( $this->sunset )) + "." + date('i', strtotime( $this->sunset ))/60 );
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
			if ( 1==1 || false === ($weather_json = get_transient('weather_json')) ){

				$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
				$yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$this->weather_station .'")';
				$yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json&diagnostics=true";
				$session = curl_init($yql_query_url);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
				$weather_json = curl_exec($session);
				curl_close($session);
				if( $weather_json != 'false' ){
					set_transient( 'weather_json', $weather_json, 30 * MINUTE_IN_SECONDS );
				}
			}
			$yql_results = json_decode($weather_json);
			$this->weather = new stdClass();
			if( is_object($yql_results->query->results ) ){
				$w = $yql_results->query->results->channel;
				$this->weather->temp_f = $w->item->condition->temp;
				$this->weather->yql_code = $w->item->condition->code;
				$this->sunrise = $w->astronomy->sunrise;
				$this->sunset = $w->astronomy->sunset;
			}
			else{			
				$this->sunrise = "";
				$this->sunset = "";
				$this->weather->temp_f = "";
			}
		}
		
		// Add Custom Admin Menu
		public function create_theme_options_page() {
			add_options_page( 'Weather Settings ' , 'Weather' , 'manage_options','weather-settings.php', array($this,'weather_settings'));
		}
	
		public function weather_settings(){ ?>
	
			<form  name='weather_station_form' action='' method='POST'>
				<h2>Weather Settings</h2>
				<table class='form-table'>
					<tbody>
						<?php if(@$this->station_message) :?>
						<tr>
							<th><?php echo @$this->station_title; ?></th>
							<td><?php echo $this->station_message; ?></td>
						</tr>

						<?php endif; ?> 
						
						<tr>
							<th>City, State
							</th>
							<td>
								<input type='text' name='weather_station' value='<?php echo $this->weather_station; ?>'>
							</td>
						</tr>
						<?php if( get_option('timezone_string') ) : ?>
							<tr>
								<th>Your Wordpress Timezone is:</th>
								<td><a href='/wp-admin/options-general.php'><?php echo get_option('timezone_string'); ?></a></td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
				<button type='submit' class='button button-primary' style=''>Save Settings</button>
				
				<?php if( 'object' == gettype($this->weather) ) : $weather = get_weather('class'); ?>
						
						<div>
							<h2>Current Settings for <?php echo strtoupper( $this->weather_station ); ?></h2>
							Custom Description: <em><?php echo custom_weather(); ?></em><br />
							<?php echo get_weather_option('temp_f'); ?>&deg;F and <?php echo strtok($weather, '.'); ?> in Tucson<br />
							Sunrise <?php echo get_weather_option('sunrise'); ?> / Sunset <?php echo get_weather_option('sunset'); ?>
						</div>
						
					<?php endif; ?>
			</form>

		<?php }
		
		// adds the weather options to the transient on the admin page
		public function weather_admin_functions(){
			if(isset( $_POST['weather_station'] )){
				$this->weather_station	= $_POST['weather_station'];
				$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
				$yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$this->weather_station .'")';
				$yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json&diagnostics=true";

				$session = curl_init($yql_query_url);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
				$weather_json = curl_exec($session);
				curl_close($session);
				$yql_results = json_decode($weather_json);
				if( is_object($yql_results->query->results ) ){
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
		// https://developer.yahoo.com/weather/documentation.html#codes
		function get_weather( $type = null ){
			if( property_exists( $this->weather, 'yql_code') && $this->weather && $code = $this->weather->yql_code ){
			        
				if( in_array( $code , array( 0,1, 2 ))){
					return "tropical-storm"; 
				}
				elseif( in_array( $code , array( 37, 38, 39,45, 47))){
		            if( $type == 'class' ){
			            return 'lightning';
		            }
			        else{
				        return 'stormy';
			        }
				}
				elseif( in_array( $code , array(32, 34, 36 ) )){
		            if( $type == 'class' ){
			            return 'sun';
			        }
			        else{
				        return 'sunny';
			        }
				}				
				elseif( in_array( $code , array(31,33 ) )){
		            if( $type == 'class' ){
			            return 'moon';
		            }
			        else{
				        return 'clear';
			        }

				}
				elseif( in_array( $code , array(19,20,21,22,26,28 ) )){
		            if( $type == 'class' ){
			            return 'cloud';
		            }
			        else{
				        return 'cloudy';
			        }
				}
				elseif( in_array( $code , array(27) )){
		            if( $type == 'class' ){
			            return 'cloud2';
		            }
			        else{
				        return 'cloudy';
			        }
				}
				elseif( in_array( $code , array(30,44 ) )){
		            if( $type == 'class' ){
			            return 'cloudy';
		            }
			        else{
				        return 'cloudy';
			        }
				}
				elseif( in_array( $code , array(29 ) )){
		            if( $type == 'class' ){
			            return 'cloud3';
		            }
			        else{
				        return 'cloudy';
			        }
				}
				elseif( in_array( $code , array(7,13,14,15,16,41,42,43,46 ) )){
		            if( $type == 'class' ){
			            return 'snowy2';
		            }
			        else{
				        return 'snowing';
			        }
				}		        
				elseif( in_array( $code , array(5,6,8,9,10,11,12,17,18,35,40 ) )){
		            if( $type == 'class' ){
			            return 'rainy2';
		            }
			        else{
				        return 'raining';
			        }
				}		        
				elseif( in_array( $code , array(3,4,37,38,39,45,47 ) )){
		            if( $type == 'class' ){
			            return 'lightning2';
		            }
			        else{
				        return 'stormy';
			        }
				}		            
				elseif( in_array( $code , array(23,24,25 ) )){
		            if( $type == 'class' ){
			            return 'wind';
		            }
			        else{
				        return 'windy';
			        }
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