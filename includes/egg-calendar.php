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
			'range'=>'1 Month',											// Sets range of time shown in range units (i.e., 1 WEEK)
			'selected_time'=>NULL,										
			'start_type'=>'selected',									// 'selected' starts on selected time; 'natural' starts at beginning of range;
			'increment_array'=>array('WEEK','DAY'),						// Units to display (less than the Range; i.e., 'DAY','WEEK' )
			'debug'=>1,													// Set debug to '1' for error messages; change to 0 for production
			'add_style'=>1												// Set add_style to '1' for development; change to 0 for prodcution; use stylesheets for production
		);
		$args = wp_parse_args( $args, $defaults );
		foreach($args as $key=>$val_pair){
			if(!is_array($val_pair)){
				$this->$key = strtoupper($val_pair);
			}
			else{
				foreach($val_pair as $arrkey => $value){
					@$this->$key->$arrkey = strtoupper($value);
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
		$this->echo_message( 'WP Timezone: ' . $this->wp_timezone );	
		$this->get_times();
		$this->init();
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
		if($this->range_units == 'MONTHS'){
			if($this->debug == 1){
				$this->range = '1';
				$this->range_units = 'MONTH';
				$msg = "Multiple months aren't yet supported. '1 Month' is assumed.";
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
			@$this->selected->wplocalstamp = strtotime( urldecode($wp_query->query_vars['calendar_date']) );
		}
		else{
			@$this->selected->wplocalstamp = current_time('timestamp');
		}
		@$this->now->wplocalstamp = current_time('timestamp');
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
		if( !@$this->start_type || ( $this->start_type != 'NATURAL' && $this->start_type != 'SELECTED' ) ){
			$this->start_type = 'SELECTED';
		}
		$level_array = $this->level_array();
		$lowest_key = count($level_array) - 1;
		if('NATURAL' == $this->start_type){
			if($this->range_units == 'MONTH'){
				$selected_time = $this->selected->wplocalstamp = $this->selected->start_of_month;
				$this->selected = $this->get_date( $this->selected->wplocalstamp );
				if( $this->selected->day_of_week != 7){
					$start_of_month = $selected_time - ( ($this->selected->day_of_week) * self::DAY);
				}	
				else{
					$start_of_month = $selected_time;
				}			
				$start_of_increment = strtotime( 'today', $start_of_month );
				$this->start_of_range = $start_of_increment;				
			}	
			elseif($this->range_units == 'WEEKS'){
			
				$this->start_of_range = $this->get_start_of_increment( 'WEEK' , $this->selected->wplocalstamp);	
			}
		}
		if('SELECTED' == $this->start_type){
			if($this->range_units == 'MONTH'){
				$selected_time = $this->selected->wplocalstamp;
				if( $this->selected->day_of_week != 7){
					$start_of_week = $selected_time - ( ($this->selected->day_of_week)* self::DAY);
				}	
				else{
					$start_of_week = $selected_time;
				}			
				$start_of_increment = strtotime( 'today', $start_of_week );
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
		if (date_i18n('w', $start) == 0) {            // 0 = Sunday		
		   $end_week--;
		}
		if (date_i18n('w', $end) == 0) {            // 0 = Sunday		
		   $end_week++;
		}
		if ($end_week < $start_week) { 								// Month wraps
			return ((52 + $end_week) - $start_week) + 1;
		}
		$num_weeks = ($end_week - $start_week) + 1;
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
	function get_months(){
		if(@$this->outputCalendar['MONTH']){
			return $this->outputCalendar['MONTH'];
		}
		else{
			echo $this->echo_message('This calendar does not have Months. Try get_weeks().');
		}
			
	}
	function get_title_month(){
		 return date('F Y', $this->selected->start_of_month );
	}
	function get_weeks( $month = NULL ){
		if(!$month){ $month = $this->outputCalendar; }
		if($month['WEEK']){
			foreach($month['WEEK'] as $week){
				$weekObj = new calWeek($week, $this);
				$weeks[] = $weekObj; 
			}
			return $weeks;
		}
		else{
			echo $this->echo_message('This calendar does not have Weeks. Try get_days().');
		}
			
	}
	function get_days( $week = NULL ){
		if( @$week ){
			return $week['DAY'];
		}
		else{
			echo $this->echo_message('Please supply a $week as array.');
		}
			
	}
	public function get_week_header(){ ?>
	
		<div class='cal-week-header'>
			<div class='cal-day-header desktop'>Sunday</div>
			<div class='cal-day-header mobile'>Sun</div>
			<div class='cal-day-header desktop'>Monday</div>
			<div class='cal-day-header mobile'>Mon</div>
			<div class='cal-day-header desktop'>Tuesday</div>
			<div class='cal-day-header mobile'>Tue</div>
			<div class='cal-day-header desktop'>Wednesday</div>
			<div class='cal-day-header mobile'>Wed</div>
			<div class='cal-day-header desktop'>Thursday</div>
			<div class='cal-day-header mobile'>Thu</div>
			<div class='cal-day-header desktop'>Friday</div>
			<div class='cal-day-header mobile'>Fri</div>
			<div class='cal-day-header desktop'>Saturday</div>
			<div class='cal-day-header mobile'>Sat</div>
		</div>			
<?php	}

	function output_month( ){
		global $events;
		if($events){ $event_arr = $events->events; } ?>
		
		<h1 class="month-title"><?php echo $this->get_title_month(); ?></h1>
		
		<div class='cal-container'>
			
<?php	$this->get_month_link(); ?>
			<div class='cal-month'>
		
<?php	$this->get_week_header();
		$weeks = $this->get_weeks();
		foreach($weeks as $week): ?>
		
			<div class='cal-week'>
		
			<?php $days = $week->get_days();
			foreach($days as $day ): $timestamp = $day->timestamp;?>
			
				<div class='<?php echo $day->div_class; ?>' data-timestamp='<?php echo $timestamp; ?>'>
					
					<?php echo date ('M j', $timestamp); 
					
					if( @$event_arr ):
					//print_r($event_arr);
						foreach($event_arr as $event_time=>$event):
							if ($event_time <= $timestamp + 86399 && $event_time <= $this->selected->end_of_month && $event_time >= $this->selected->start_of_month):
								if( $event_time < current_time( 'timestamp' ) ){ $class = 'event past'; }else{ $class = 'event'; } ?>
						<div class='<?php echo $class; ?>' data-timestamp='<?php echo $event_time; ?>'>
						<?php 
							if(get_field('_recurring_day', $event)){
								$starts_on = strtotime( get_field('starts_on', $event) );
								$ends_on = strtotime( get_field('ends_on', $event) );
								if( $starts_on <= $timestamp && $ends_on >= $timestamp ){
									echo "<a href='". add_query_arg( 'event_time', $event_time, get_permalink( $event ) ) . "'>". get_the_title($event) . "</a>";
								}
							}
							else{ 
									echo "<a href='". get_permalink( $event ) . "'>". get_the_title($event) . "</a>";
							}
						?>
						<?php ?>
						</div>	
								<?php unset($event_arr[$event_time]); ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					
				</div>
					
			<?php endforeach; ?>
			
			</div><!--/cal-week-->
		
		<?php endforeach; ?>
		
		</div><!--/cal-month-->
	</div>
	
<?php
	}
    public function get_month_link(){
    	// gets query type from URL
	    global $cal_type;
	    global $wp_query;
		if(@$cal_type){
			$query = "/?cal_type=".$cal_type;
		}
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
		$m->prev_text = date('F', mktime(0, 0, 0, $prev_month, 10));
		if(	$cat    = get_query_var(@$wp_query->query_vars['taxonomy'])){
			$prev_url = '/event-cat/'.$cat.'/'.$m->prev_url.@$query;
			$next_url = '/event-cat/'.$cat.'/'.$m->next_url.@$query;
		}
		else{
			$prev_url = '/calendar/'.$m->prev_url.@$query;
			$next_url = '/calendar/'.$m->next_url.@$query;
		}
		?>
		
		<div class='cal-nav'>
			<div class='cal-prev'><a href='<?php echo $prev_url; ?>'><?php echo $m->prev_text; ?></a></div>
			<div class='cal-next'><a href='<?php echo $next_url; ?>'><?php echo $m->next_text; ?></a></div>
		</div>
<?php
	}
    public function add_style(){
	    echo "<style>
	    		.cal-nav{  }
	    		.cal-month { display: table; width: 100%; }
				.cal-week {  border:solid 1px grey; }
				.cal-day, .cal-emptyday {display:inline-block; vertical-align:top; width: 13%; height: 100px;}
				.cal-emptyday { color: transparent;}
				.cal-day.current { background-color:#A9A7AD;  }
				.cal-day.past, .cal-day.past a { background-color: #d7d7d8; color:grey}
				.cal-prev { display:inline-block; }
				.cal-next{ float:right; }
				.cal-error-message{ height: 50px; background-color: #d0d0d0; color: red; }
				.cal-week-header {
				    display: table-row;
				    font-size: 0.875em;
				    font-family: 'Futura W01 Bold', 'Arial Black', 'Arial Bold', sans-serif;
				    text-transform: uppercase;
				    background: #e8e5de;
				    text-align: center; }
				 .cal-day-header.desktop {
				 	vertical-align: top;
				 	width: 14%;
				    display: table-cell;
				    border-right: 1px solid white;
				    padding: 4px; }
			    .cal-day-header.mobile { display: none; }
			    .cal-month .cal-week {
			      display: table-row; }
			    .cal-month .cal-day {
			      vertical-align: top;
			      display: table-cell;
			      width: 14%;
			      border: 1px solid grey;
			      height: 8em; }
			    .cal-month .cal-emptyday {
			      vertical-align: top;
			      display: table-cell;
			      border: 1px solid white;
			      background: #f9f8f6; }
			     

			</style>";
    }
    public function echo_message( $msg ){
    	$debug_backtrace = debug_backtrace();
        echo "<div class='cal-error-message'>".$msg."<br>See line #".$debug_backtrace[0]['line']."<hr></div>";
    }
    public function __destruct(){
	    // Resets timezone to initial PHP timezone setting - just to be a good neighbor 
		date_default_timezone_set( $this->initial_timezone ); 		
    }
}
class calWeek{
	public function  __construct( $week, $cal ){
		foreach($week['DAY'] as $timestamp=>$dayText){
			$day = new calDay($timestamp);
			$day->div_class = 'cal-day ';	
			if( $timestamp < $cal->selected->start_of_month || $cal->selected->end_of_month <= $timestamp){
				$day->div_class .= 'cal-emptyday';
			}
			else{
				if( $timestamp < $cal->now->start_of_day ){ $day->div_class .= " past"; }
				if( $timestamp == $cal->now->start_of_day ){ $day->div_class .= " current"; } 
			}		
			$this->days[] = $day;				
		}
	}
	public function get_days(){
		if( $this->days ){	
			return $this->days;
		}
		else{
			echo $this->echo_message('Please supply a $week as array.');
		}
			
	}

}
class calDay{
	public function  __construct( $timestamp ){
		$this->timestamp = $timestamp;
	}
	public function the_timestamp(){
		return $this->timestamp;
	}
	public function the_class(){
		return $this->div_class;
	}
	public function get_days(){
		if( $this->days ){
			return $this->days;
		}
		else{
			echo $this->echo_message('Please supply a $week as array.');
		}
			
	}

}

function my_posts_where( $where ){
		$where = str_replace("meta_key = 'event_dates_%_event_date'", "meta_key LIKE 'event_dates_%_event_date'", $where);
		return $where;
	} 
add_filter("posts_where", "my_posts_where");

/**
  * EVENTS Class 
  *
  * Returns all events, recurring and fixed, sorted chronologically from today
  * 
  * @start_date string 	optional - this marks the beginning of the time frame of interest in the form 'YYYYMMDD'; default is current time;
  * @max_limit integer 	optional - number of days to search from $start_date
  * @event_cat string 	optional - category slug to limit search to
  * 
  * @return array of key = event's timestamp and value = event's post id; array is sorted with recurring events populated for each occurence. 
  * 			Array (
  *					[1399507200] => 209
  *					[1405555200] => 212
  *				)
  * 
  */
class eggEvents{

	function get_events( $start_date = NULL, $max_limit = 0, $event_cat = NULL){
		global $wpdb;
		if( !$start_date ){ $start_date = date('Ymd', current_time('timestamp')  ); }
		$stamp = strtotime( $start_date );
		$max_time = date( 'Ymd', ( $stamp + $max_limit * 86400 ) );

		$single_events = array();
		$recurring_events = array();
		
		$args = array(
			'numberposts' => -1,
			'post_type' => 'event',
			'meta_query' => array(
				array(
					'key' => 'event_dates_%_event_date',
					'value' => $day,
					'type' => 'NUMERIC',
					'compare'=> '>'
					
				),
				array(
					'key' => 'event_dates_%_event_date',
					'value' => $max_time,
					'type' => 'NUMERIC',
					'compare'=> '<'
					
				)
			)
		);
		if($event_cat){ 
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'event_cat',
					'field' => 'slug',
					'terms' => $event_cat
				)
			);	
			
		}
		// get results
		$the_query = new WP_Query( $args );
		//print_r($the_query);
		if( $the_query->have_posts() ){
			foreach ( $the_query->posts as $spost ) {
				$count = 0;
				if( get_field('event_dates', $spost->ID ) ){
					while ( $event_date = get_post_meta( $spost->ID , "event_dates_". $count ."_event_date", true) ){ 
						$eventstamp = strtotime( $event_date );
						$single_events[$eventstamp] = $spost->ID;
						$count++;
					}
				}
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
		$this->events = $all_events;
	}
}

/**
 * FILTERS
 **/

add_filter('rewrite_rules_array', 'add_rewrite_rules');
add_filter('query_vars', 'add_query_vars');
  
// Adds a url query to pass date requests in the URL (i.e., example.net/?var1=value1&calendar_date=2014-08
function add_query_vars($aVars) {
	$aVars[] = "calendar_date";
	$aVars[] = "custom_cat";
	return $aVars;
}

// Rewrite Rule - redirects calendar/2014-08/ to page-calendar.php?calendar_date=2014-08
// ON INSTALL SAVE Permalinks or flush_rewrite_rules();
function add_rewrite_rules($aRules) {
	$aNewRules = array('calendar/([^/]+)/?$' => 'index.php?pagename=calendar&calendar_date=$matches[1]');
	$aRules = $aNewRules + $aRules;
	$bNewRules = array('event-cat/([^/]*)/([^/]*)/?' => 'index.php?event_cat=$matches[1]&calendar_date=$matches[2]');
	$aRules = $bNewRules + $aRules;
	return $aRules;
}