<?php 
/**
  * Returns a calendar as a nested array of timestamp keys across a defined range of time units (i.e., 2 Months of weeks; 2 weeks of days).
  *
  * The class is intended to be flexible enough for a broad range of calendar demands within CreativeSlice.
  * The output, for example, from a request of 2014-08 returns the following array:
  *		[WEEK] => Array														// 'WEEK' is an array of the month's (5) weeks
  *			(
  *				[1406419200] => Array										// a WPLOCAL timestamp of 12:00 AM of the first Sunday of Week 1 (WPLOCAL defined below)
  *					(
  *						[DAY] => Array										// 'DAY' is an array of the week's (7) days
  *							(
  *								[1406419200] => Jul 27 Sun 2014 00:00		// a WPLOCAL timestamp of 12:00 AM of the day
  *								[1406505600] => Jul 28 Mon 2014 00:00		// The Value of the lowest level pair is a Date String but can be modified by developer.
  *								[1406659200] => Jul 29 Tue 2014 00:00
  *								[1406678400] => Jul 30 Wed 2014 00:00
  *								[1406764800] => Jul 31 Thu 2014 00:00
  *								[1406851200] => Aug 01 Fri 2014 00:00
  *								[1406937600] => Aug 02 Sat 2014 00:00
  *							)
  *					)
  *				[1407024000] => Array										// a WPLOCAL timestamp of 12:00 AM of the first Sunday of Week 2 
  *					(
  *						[DAY] => Array
  *							(
  *								[1407024000] => Aug 03 Sun 2014 00:00
  *									•••
  *							)
  *					)
  *					•••
  *			)
  *
  * To protect against timezone conflicts, this Calendar Class sets the PHP timezone to UTC-0. The Class uses the Wordpress General Settings for a Wordpress Timezone. If a 
  * The Class then returns timestamps that are UnixTime offset by the Wordpress timezone_offset. This timestamp will be called here WPLOCAL. (If a Timezone is not set, the 
  * Calendar outputs true UnixTime referenced to UTC.) 
  * 
  * WPLOCAL timestamps will look like Unix Timestamp, but technically are not, and thus might be confusing. WPLOCAL can be defined as:
  * the number of seconds that have elapsed since 00:00:00 Wordpress Local TimeZone, Thursday, 1 January 1970.
  */

class calendar{
	 
	/** 
	 * VARIABLES
	 **/
 	//const DEFAULT_START_TYPE = 'selected';								
 	//const DEFAULT_RANGE_UNITS = 'MONTH';								
 	//const DEFAULT_RANGE = '1';											
	//const DEFAULT_INCREMENT = 'DAY';									
	
 	/**
 	 * CONSTANTS
 	 **/
 	const MINUTE = 60;
 	const FIFTEEN_MINUTE = 900;
 	const HALF_HOUR = 1800;
 	const HOUR = 3600;
 	const DAY = 86400;
 	const WEEK = 604800;
	const WEEKS = 2419200; 												// 28 days - range is redefined later 
	const MONTH = 2419200; 												// 28 days - range is redefined later for specific month 
	const YEAR = 31536000;		
	
	/**
	  * __construct ...
	  *
	  * Description. 
	  *
	  * @param array $args [selected_time=>$selected_time, start_type=>string, range_units=>str, range=>int, increment=>$increment_array]
	  *
	  * 	@param int $selected_time time-of-interest as a unixtimestamp; a NULL value (the default) will set it to the current time.
	  *
	  * @return void
	  */
	  
	public function  __construct( $args = NULL ){
	
		$defaults = array(
			'selected_time'=>NULL,										// Options: 'selected' starts on selected time; 'natural' starts at beginning of range;
			'start_type'=>'selected',													// Sets range of time shown in range units (i.e., 1 WEEK)
			'increment_array'=>array('WEEK','DAY'),						// Units to display (less than the Range; i.e., 'DAY','WEEK' )
			'add_style'=>0												// For development only; use stylesheets for production
		);
		$args = wp_parse_args( $args, $defaults );
		foreach($args as $key=>$val_pair){
			if(!is_array($val_pair)){
				$this->$key = strtoupper($val_pair);
			}
			else{
				foreach($val_pair as $arrkey => $value){
					$this->$key->$arrkey = strtoupper($value);
				}
			}
		}
		$this->get_range();
		// Gets initial PHP timezone setting - allows timezone to be reset to this initial timezone when: unset($cal); 
		$this->initial_timezone = date_default_timezone_get(); 
		// Sets PHP timezone to a baseline of UTC
		date_default_timezone_set('UTC');
		
		// Adds Timezone of Offset to Calendar Object for Debugging/Reference
		if( ! $this->wp_timezone = get_option('timezone_string') ){
			$this->wp_timezone = get_option('gmt_offset');
		}		
		$this->get_times();
	} 
	
	/**
	 * Takes natural language date range request (i.e '2 Weeks') and parses to range and range units
	 **/
	public function get_range(){
		if(!@$this->range){
			$this->range = '1 MONTH';
		}
		$range_request = $this->range;
		if ( preg_match ( '/([0-9]+)/', $range_request, $nummatches ) ){
			$this->range = $nummatches[0];
		}
		else{
			$this->range = 1;
			if($this->debug == 1){
				$msg = "Your range argument is missing a Quantity. '1' is assumed.";
				$this->echo_message( $msg );				
			}
		}
		if ( preg_match('/[a-zA-Z]*$/', $range_request, $strmatches) ){
			$this->range_units = $strmatches[0];
		}		
		else{
			$this->range_units = 'MONTH';
			if($this->debug == 1){
				$msg = "Your range argument is missing a Time Unit. 'Month' is assumed.";
				$this->echo_message( $msg );				
			}
		}
	}
	
	/**
	 * Checks if $calendar_date URL query variable has been passed (See add_rewrite_rules & add_query_vars at end)
	 * $calendar_date is a date string and is treated as WPLOCAL time. 
	 * Url format is www.example.net/calendar/2014-08 for page-calendar.php. Add Rule for other pages (??)
	 * If no URL date is passed, returns current Wordpress Local Time (WPLOCAL)
	 **/	
	public function get_times(){
		global $wp_query;
		if(isset($wp_query->query_vars['calendar_date'])) {
			$this->selected->wplocalstamp = strtotime( urldecode($wp_query->query_vars['calendar_date']) );
		}
		else{
			$this->selected->wplocalstamp = current_time('timestamp');
		}
		$this->now->wplocalstamp = current_time('timestamp');
		$this->selected = $this->get_date( $this->selected->wplocalstamp );
		$this->now = $this->get_date( $this->now->wplocalstamp );
	}
		
	/** METHODS **/
	public function init(){
	
		// If set, will output development styling to deploy and debug
		if($this->add_style){
			$this->add_style();
		}
		
		// Defines the total length of the main range unit in seconds ( '2 WEEKS' will take 1 Week in seconds
		if( 'MONTH' == $this->range_units ){
			$this->range_unit_in_seconds = $this->selected->days_in_month * self::DAY; 
		}
		elseif( 'WEEKS' == $this->range_units ){
			$this->range_unit_in_seconds = self::WEEK; 
		}
		elseif( 'YEAR' == $this->range_units ){
           if ($this->selected->year % 400 == 0 OR ($this->selected->year % 4 == 0 AND $this->selected->year % 100 != 0)){
       			$this->range_unit_in_seconds = constant( 'self::'.$this->range_units ) + constant( 'self::Day');
            }
			else{
	 			$this->range_unit_in_seconds = constant( 'self::'.$this->range_units );
			}
		}
		else{
			$this->range_unit_in_seconds = constant( 'self::'.$this->range_units );
		}
		
		$this->range_in_seconds = $this->range_unit_in_seconds * $this->range;
	
		if( count( @$this->increment_array ) > 0 ){
			$sorted_increment_array = array();
			foreach( $this->increment_array as $increment_name ){
				$increment_name = strtoupper( $increment_name );
				if( 'MONTH' == $increment_name ){
					$key = $this->selected->days_in_month * self::DAY; 
				}
				else{
					if( !defined( 'self::'.$increment_name ) ){
						$increment_name = 'DAY'; //get default increment...? 
					}
					$key = constant( 'self::'.$increment_name ); 	// gets increment time in seconds to use as key 	
				}				
				$sorted_increment_array[$key] = array( 'seconds'=>$key, 'name'=>$increment_name );
			}
			arsort($sorted_increment_array);
			$this->increment_array = $sorted_increment_array ;
		}
		else{
			@$default_incr = constant('self::'.DEFAULT_INCREMENT);
			$key = constant('self::'.$default_incr);
			$this->increment_array = array ( $key=> array( 'seconds'=>$key, 'name'=>$default_incr ) );
		}
		if( !@$this->start_type || ( $this->start_type != 'natural' && $this->start_type != 'selected' ) ){
			$this->start_type = 'selected';
		}
		$level_array = $this->level_array();
		$lowest_key = count($level_array) - 1;
		if('natural' == $this->start_type){
			$this->start_of_range = $this->get_start_of_increment( $this->range_units , $this->selected->wplocalstamp);
		}
		if('selected' == $this->start_type){
			if($this->range_units == 'MONTH'){
				$selected_time = $this->selected->wplocalstamp;
				if( $this->selected->day_of_week != 7){
					$start_of_month = $selected_time - ( ($this->selected->day_of_week)* self::DAY);
				}	
				else{
					$start_of_month = $selected_time;
				}			
				$start_of_increment = strtotime( 'today', $start_of_month );
				$this->start_of_range = $start_of_increment;					
			}
			else{
				$this->start_of_range = $this->get_start_of_increment( $level_array[$lowest_key]['name'] , $this->selected->wplocalstamp);
			}
		}
		$this->build_empty_calendar_array();
		$this->build_calendar_output();
	}
	public function get_start_of_increment( $increment, $selected_time ){
		if( 'DAY' == $increment ){
			$start_of_increment = strtotime( 'today', $selected_time );
		}
		if( 'WEEK' == $increment ){
			$start_of_week = $selected_time - ( $this->selected->day_of_week * self::DAY);				
			$start_of_increment = strtotime( 'today', $start_of_week );
		}
		if( 'MONTH' == $increment ){
			$start_of_month = $selected_time - ( ($this->selected->day_of_month - 1)* self::DAY);				
			$start_of_increment = strtotime( 'today', $start_of_month );
		}
		return $start_of_increment;
	}
	public function get_start_of_increments(){
		$selected_time = $this->selected->wplocalstamp;
		foreach( $this->increment_array as $seconds=>$array){
			$this->increment_array[$seconds]['start_time_of_unit'] = $this->get_start_of_increment( $array['name'] , $selected_time );
		}		
	}
	public function level_array(){
		$level_array = array();
		$array = $this->increment_array;
		arsort($array);
		foreach( $array as $key=>$arr){	
			$level_array[] = $arr;
		}
		$this->level_array = $level_array;
		return $level_array;
	}
	public function get_multiple( $major, $minor ){
		$major_seconds = constant( 'self::'.$major);
		$minor_seconds = constant( 'self::'.$minor);
		if( 'MONTH' == $major ){
			$major_seconds =  $this->selected->weeks_in_month * self::WEEK; 			
		}
		if( 'WEEKS' == $major ){
			$major_seconds =  $this->range * self::WEEK; 			
		}
		$multiple =  ceil( $major_seconds / $minor_seconds);
		return $multiple;
	}
	public function build_empty_calendar_array( ){
		$level_array = $this->level_array;
		$x = count($level_array) - 1;
		$temp = array();
		for ($i = $x; $i>=0; $i--){
			$minor = $level_array[$i]['name'];

			if( $i >= 1){
				$major = $level_array[$i-1]['name'];
			}
			else{
				$major = $this->range_units;	
			}
			$multiple = $this->get_multiple( $major, $minor ); // number of minor units per major unit (i.e. days per 
			$start_time = $this->start_of_range;
			$level_increment = $level_array[$i]['seconds'];
			$counter = 0;
			$unittemp = array();
			while ( $counter < $multiple  ){
				$id = $start_time + ($counter * $level_increment); 
				if( $i == $x ){
					$unittemp[] = '';
				}else{
					$unittemp[] = $temp ;
				}
				$counter++;
			}
			$temp = array( $level_array[$i]['name'] => $unittemp );
	
		}
		$this->calendar_array = $temp;
		return $temp;
	}

	public function build_calendar_output(){
		$calendar = $this->calendar_array;
		$level_array = $this->increment_array;
		ksort($level_array);
		$min_level = array_shift( $level_array );
		global $increment;
		$increment = $min_level['seconds'];
		$newTimestamp = $this->start_of_range;  // starting index.
		$newCalendar = array(); 
		function walk_calendar_array( $calendar , &$newCalendar , &$newTimestamp ){
			global $increment;
		    foreach($calendar as $sourceKey => $sourceValue) {
		        if (is_array($sourceValue)) {
		        	if( is_numeric( $sourceKey ) ){
			            $key = $newTimestamp;
			        }else{
				        $key = $sourceKey;
			        }
		            $newCalendar[ $key ] = array();
		            walk_calendar_array($sourceValue, $newCalendar[ $key ], $newTimestamp);
		        }
		        else {
		        	if( is_numeric( $sourceKey ) ){
		        		
				        $newCalendar[$newTimestamp] = date ('M d D Y H:i ',  $newTimestamp );   
				     
						$newTimestamp = $newTimestamp + $increment;
					}
		        }
		    }
		}
		walk_calendar_array( $calendar , $newCalendar , $newTimestamp ); // re-index the array 
		$this->outputCalendar = $newCalendar;
	}
	public function weeks_in_month($month, $year) {
		$start = mktime(0, 0, 0, $month, 1, $year);
		$end = mktime(0, 0, 0, $month, date_i18n('t', $start), $year);
		$start_week = date_i18n('W', $start);
		$end_week = date_i18n('W', $end);
		if (date_i18n('w', $end) == 0) {            // 0 = Sunday
		   $end_week++;
		}
		if ($end_week < $start_week) { // Month wraps
			return ((52 + $end_week) - $start_week) + 1;
		}
		return ($end_week - $start_week) + 1;
	}
	public function get_date( $wplocalstamp ){
		$sel = new stdClass;
		$sel->wplocalstamp = $wplocalstamp;
		$sel->start_of_day = strtotime( 'today', $wplocalstamp );
		$sel->day = date_i18n( 'l', $wplocalstamp );
		$sel->month = date_i18n( 'm', $wplocalstamp );
		$sel->year = date_i18n( 'Y', $wplocalstamp ); 
		$sel->day_of_week = date_i18n( 'N', $wplocalstamp ); 
		$sel->day_of_month = date_i18n( 'd', $wplocalstamp );
		$sel->days_in_month = cal_days_in_month ( CAL_GREGORIAN, $sel->month , $sel->year );
		$sel->start_of_month = mktime( 0, 0 ,0, $sel->month, 1, $sel->year);
		$sel->end_of_month = $sel->start_of_month + ($sel->days_in_month * self::DAY );
		$sel->weeks_in_month = $this->weeks_in_month($sel->month, $sel->year );
		$time = date_i18n( 'G:i ', $wplocalstamp ) . $this->wp_timezone;
		$sel->time = $time;
		return $sel;
	}
    public function week_link(){
    	$w = new stdClass();
    	
//		$w->next_url = $next_weekY. "-" . sprintf("%02s", $next_week);
//		$w->next_text = date('F', mktime(0, 0, 0, $next_week, 10)); /
//		$w->prev_url = $prev_weekY. "-" . sprintf("%02s", $prev_week);
//		$w->prev_text = date('F', mktime(0, 0, 0, $prev_week, 10)); ;
		return $w;
    }
	/** OUTPUT **/
	function output_month( ){
		global $events;
		global $cal_type;
		if(@$cal_type){
			$query = "/?cal_type=".$cal_type;
		}
		if($events){ $event_arr = $events; }
		$m = $this->month_link();
		@$out .= "
	<div class='cal-container'>
		<h2>".  date('F Y', $this->selected->start_of_month ) ."  </h2>
		<div class='cal-prev'><a href='/calendar/".$m->prev_url.$query."'>" .$m->prev_text ."</a></div>
		<div class='cal-next'><a href='/calendar/".$m->next_url.$query."'>" .$m->next_text ."</a></div>
		<div class='cal-".$this->range_units."'>\n
			<div class='cal-WEEK-header'>
				<div class='cal-DAY-header-desktop'>Sunday</div>
				<div class='cal-DAY-header-mobile'>Sun</div>
				<div class='cal-DAY-header-desktop'>Monday</div>
				<div class='cal-DAY-header-mobile'>Mon</div>
				<div class='cal-DAY-header-desktop'>Tuesday</div>
				<div class='cal-DAY-header-mobile'>Tue</div>
				<div class='cal-DAY-header-desktop'>Wednesday</div>
				<div class='cal-DAY-header-mobile'>Wed</div>
				<div class='cal-DAY-header-desktop'>Thursday</div>
				<div class='cal-DAY-header-mobile'>Thu</div>
				<div class='cal-DAY-header-desktop'>Friday</div>
				<div class='cal-DAY-header-mobile'>Fri</div>
				<div class='cal-DAY-header-desktop'>Saturday</div>
				<div class='cal-DAY-header-mobile'>Sat</div>
			</div>";
		foreach($this->outputCalendar['WEEK'] as $weekstamp => $unit_array){
			$counter = 0;
			$out .=" <div class='cal-WEEK'> \n";
			foreach($unit_array['DAY'] as $timestamp => $dayText ){
				if($timestamp < $this->selected->start_of_month || $this->selected->end_of_month <= $timestamp){
					$out .= " <div class='cal-EMPTYDAY'></div>\n";				
				}
				else{
					$counter++;
					$unit_name = 'DAY';
					$unit_class = "cal-".$unit_name;
					if( $timestamp < $this->now->start_of_day ){  $unit_class .= " cal-past-".$unit_name; }
					if( $timestamp == $this->now->start_of_day ){  $unit_class .= " cal-current-".$unit_name; }
					$out .="     <div class='". $unit_class ."' data-timestamp='".$timestamp." '>".date ('D M j', $timestamp);
					if( @$event_arr ){

						foreach($event_arr as $event_time=>$event){
							if ($event_time <= $timestamp + 86400 ){
								if( $event_time < time() ){ $class = 'filmtime-past'; }else{ $class = 'filmtime'; }
								$out .= "<div class='".$class."' data-timestamp='".$event_time." '>\n<a href='".get_permalink($event)."'>".get_the_title($event)."</a>\n</div>\n";	
								unset($event_arr[$event_time]);
							}
						}						
					}
					$out .="</div>\n";
				}
			}
			$out .= "  </div><!--/cal-WEEK-->\n";
		}
		$out .= "</div><!--/cal-".$this->range_units."-->
		</div><!--/cal-container-->\n";
		
		echo $out;
	}
    public function month_link(){
    	$m = new stdClass();
		if($this->selected->month == 12 ){
			$next_month = 01;
			$next_monthY =  $this->selected->year + 1;
		}
		else{
			$next_month = $this->selected->month + 1;
			$next_monthY =  $this->selected->year;			
		}
		if($this->selected->month == 01 ){
			$prev_month = 12;
			$prev_monthY = $this->selected->year - 1;
		}
		else{
			$prev_month = $this->selected->month - 1;
			$prev_monthY = $this->selected->year;			
		}
		$m->next_url = $next_monthY. "-" . sprintf("%02s", $next_month);
		$m->next_text = date('F', mktime(0, 0, 0, $next_month, 10)); 
		$m->prev_url = $prev_monthY. "-" . sprintf("%02s", $prev_month);
		$m->prev_text = date('F', mktime(0, 0, 0, $prev_month, 10)); ;
		return $m;
    }
    public function add_style(){
	    echo "<style>
				.cal-WEEK {  border:solid 1px grey; }
				.cal-DAY, .cal-EMPTYDAY {display:inline-block; vertical-align:top; width: 13%; height: 100px;}
				.cal-current-DAY { background-color:#A9A7AD;  }
				.cal-past-DAY, .cal-past-DAY a { background-color: #d7d7d8; color:grey}
				.cal-prev { display:inline-block; }
				.cal-next{ float:right; display:inline-block;}
				.cal-error-message{ height: 50px; background-color: #d0d0d0; color: red; }
			</style>";
    }
    public function echo_message( $msg ){
    	$debug_backtrace = debug_backtrace();
        echo "<div class='cal-error-message'>".$msg."<br>See line #".$debug_backtrace[0]['line']."</div>";
    }
    public function __destruct(){
	    // Resets timezone to initial PHP timezone setting - just to be a good neighbor 
		date_default_timezone_set( $this->initial_timezone ); 		
    }
}

/************* EVENTS **********************************/
// Returns all events, recurring and fixed, sorted chronologically from today
// Date is in Ymd format, i.e 20140702
// Default gets events for the current day
function get_events( $stamp , $max_limit = 0, $event_cat = NULL){
	global $wpdb;
	$day = date( 'Ymd', $stamp);
	$max_time = date( 'Ymd', ($stamp + $max_limit * 86400 ) );
	$single_events = array();
	$recurring_events = array();
	$sql = "SELECT DISTINCT $wpdb->posts.* 
				    FROM $wpdb->posts";
	if($event_cat){
		$sql .= " INNER JOIN
          {$wpdb->term_relationships} ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id
        INNER JOIN
          {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_taxonomy_id = {$wpdb->term_relationships}.term_taxonomy_id
        INNER JOIN
          {$wpdb->terms} ON {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id ";
	}
	$sql .="		INNER JOIN $wpdb->postmeta
					ON $wpdb->posts.ID = $wpdb->postmeta.post_id
				    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
				    AND $wpdb->postmeta.meta_key LIKE 'event_dates_%_date' 
				    AND $wpdb->postmeta.meta_value >= $day
				    AND $wpdb->postmeta.meta_value <= $max_time
				    AND $wpdb->posts.post_type = 'event'";
	if($event_cat){
		$sql .= " AND $wpdb->terms.slug = '$event_cat'";		
	}
	$sql .="	    ORDER BY $wpdb->postmeta.meta_value ASC";
    $sing_events = $wpdb->get_results($sql, OBJECT);
	foreach( $sing_events as $se_key=>$se_post ){
		$count = 0;
		while ( $event_date = get_post_meta($se_post->ID, "event_dates_". $count ."_date", true) ){
			$event_time = get_post_meta($se_post->ID, "event_dates_". $count ."_start_time", true);
			$eventstamp = strtotime($event_date) + $event_time * 3600;
			$single_events[$eventstamp] = $se_post;
			$count++;
		}
	}
	if( $max_limit > 1 ){
		$media_query = array( 'key' => 'recurring_day'); 
	}
	else{
		$media_query = array(
						'key' => 'recurring_day',
						'value' => date ( 'w' , $stamp),
						'compare' => '=',
						'type' => 'numeric',
			       );
	}		
	$recurring_query = new WP_Query( array (
					    'post_type' => 'events',
					    'meta_key' => 'recurring_day',
					    'orderby' => 'meta_value_num',
					    'order' => 'ASC',
					    'meta_query' => array( $media_query )
					));	
	if( $max_limit > 1 ){
		$recurring_count = floor($max_limit/ 7);
		foreach($recurring_query->posts as $re_key => $re_post){
			$recurring_day = get_field( 'recurring_day', $re_post->ID );
			$dif_num = $recurring_day - date('w');
			if( $dif_num < 0 ){ $dif_num = $dif_num + 7;}
			$i = 0;		
			while($i < $recurring_count){
				$recurring_timestamp = strtotime( 'today 12:00am +' . $dif_num .' day');
				$recurring_events[$recurring_timestamp] = $re_post;
				$dif_num = $dif_num +7;
				$i++;
			}			
		}

	}
	else{
		foreach($recurring_query->posts as $re_key => $re_post){
			$recurring_day = get_field( 'recurring_day', $re_post->ID );
			$recurring_events[$stamp] = $re_post;					
		}	
	}
	$all_events = $single_events + $recurring_events;
	ksort($all_events);
	return $all_events;
}

/**
 * FILTERS
 **/

add_filter('rewrite_rules_array', 'add_rewrite_rules');
add_filter('query_vars', 'add_query_vars');
  
// Adds a url query to pass date requests in the URL (i.e., example.net/?var1=value1&calendar_date=2014-08
function add_query_vars($aVars) {
	$aVars[] = "calendar_date";
	return $aVars;
}

// Rewrite Rule - redirects calendar/2014-08/ to page-calendar.php?calendar_date=2014-08
// ON INSTALL SAVE Permalinks or flush_rewrite_rules();
function add_rewrite_rules($aRules) {
	$aNewRules = array('calendar/([^/]+)/?$' => 'index.php?pagename=calendar&calendar_date=$matches[1]');
	$aRules = $aNewRules + $aRules;
	return $aRules;
}

