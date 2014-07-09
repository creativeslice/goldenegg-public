<?php 
/**
 * egg-calendar
 * time is processed as UTC - displayed in local timezone
 */

class calendar{
	/** VARIABLES **/
 	const DEFAULT_START_TYPE = 'selected';								// Options: 'selected' starts on selected time; 'natural' starts at beginning of range;
 	const DEFAULT_RANGE_UNITS = 'MONTH';									// Options use time constants defined below
 	const DEFAULT_RANGE = '1';											// Sets range of time shown in range units (i.e., 1 WEEK)
	const DEFAULT_INCREMENT = 'DAY';									// Time constant less than range
	
 	/** CONSTANTS **/
 	const MINUTE = 60;
 	const FIFTEEN_MINUTE = 900;
 	const HALF_HOUR = 1800;
 	const HOUR = 3600;
 	const DAY = 86400;
 	const WEEK = 604800;
	const MONTH = 2419200; // 28 day; range redefined for specific month
	const YEAR = 31536000;		
 	private static $days = array( 'Sunday' , 'Monday' , 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday' );
	private static $months = array( '01' => 'January' , '02' => 'February' , '03' => 'March' , '04' => 'April' , '05' => 'May' , '06' => 'June' , '07' => 'July' , '08' => 'August' , '09' => 'September' , '10' => 'October' , '11' => 'November', '12' => 'December' );

	/** CONSTRUCTOR
	 * $selected_time is time-of-interest (or today) in unixtimestamp
	 * $start sets the initial time for the range
	 */  
	public function  __construct( $selected_time = null ){ 
		if( $selected_time ){
			$this->selected->unixstamp = $selected_time;	
		}else{
			$this->selected->unixstamp = strtotime( 'today', time() ); // 12:00 am of today
		}
		$this->now->unixstamp = time();	
	} 

	/** METHODS **/
	public function init(){
		$selected_stamp =	$this->selected->unixstamp;	
		$now_stamp = $this->now->unixstamp;	
		$this->selected = $this->get_date( $selected_stamp );
		$this->now = $this->get_date( $now_stamp );
		if( !$this->range_units ){
			$this->range_units = self::DEFAULT_RANGE_UNITS;			
		}
		else{
			$this->range_units = strtoupper( $this->range_units );		
			if( !defined( 'calendar::'.$this->range_units ) ){
				$this->range_units = self::DEFAULT_RANGE_UNITS;							
			}
		}
		if( !$this->range_multiple ){
			$this->range_multiple = self::DEFAULT_RANGE;
		}
		if( 'MONTH' == $this->range_units ){
			$this->range_unit_in_seconds = $this->selected->days_in_month * self::DAY; 
		}
		elseif( 'YEAR' == $this->range_units ){
           if ($this->selected->year % 400 == 0 OR ($this->selected->year % 4 == 0 AND $this->selected->year % 100 != 0)){
       			$this->range_unit_in_seconds = constant( 'calendar::'.$this->range_units ) + constant( 'calendar::Day');
            }
			else{
	 			$this->range_unit_in_seconds = constant( 'calendar::'.$this->range_units );
			}
		}
		else{
			$this->range_unit_in_seconds = constant( 'calendar::'.$this->range_units );
		}
		$this->range_in_seconds = $this->range_unit_in_seconds * $this->range_multiple;
		$this->start_of_range = $this->get_start_of_increment( $this->range_units , $this->selected->unixstamp);
//print_r($this);
//		$this->increment_array[] = $this->range_units;
		if( count( $this->increment_array ) > 0 ){
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
				if( $key < $this->range_unit_in_seconds ){
					$sorted_increment_array[$key] = array( 'seconds'=>$key, 'name'=>$increment_name );
				}
			}
			arsort($sorted_increment_array);
			$this->increment_array = $sorted_increment_array ;
		}
		else{
			$default_incr = constant('self::'.DEFAULT_INCREMENT);
			$key = constant('self::'.$default_incr);
			$this->increment_array = array ( $key=> array( 'seconds'=>$key, 'name'=>$default_incr ) );
		}
		if( !$this->start_type || ( $this->start_type != 'natural' && $this->start_type != 'selected' ) ){
			$this->start_type = self::DEFAULT_START_TYPE;
		}
		$this->build_calendar_array();
		$this->output_calendar();
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
		$selected_time = $this->selected->unixstamp;
		foreach( $this->increment_array as $seconds=>$array){
			$this->increment_array[$seconds]['start_time_of_unit'] = $this->get_start_of_increment( $array['name'] , $selected_time );
		}		
	}
	public function level_array(){
		$leval_array = array();
		$array = $this->increment_array;
		arsort($array);
		foreach( $array as $key=>$arr){	
			$level_array[] = $arr;
		}
		return $level_array;
	}
	public function get_multiple( $major, $minor ){
		$major_seconds = constant( 'self::'.$major);
		$minor_seconds = constant( 'self::'.$minor);
		if( 'MONTH' == $major ){
			$major_seconds =  $this->selected->days_in_month * self::DAY; 			
		}
		$multiple =  floor( $major_seconds / $minor_seconds);
		return $multiple;
	}
	public function build_calendar_array( ){
		$level_array = $this->level_array();
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
			$multiple = $this->get_multiple( $major, $minor );
			$start_time = $this->start_of_range;
			$level_increment = $level_array[$i]['seconds'];
			$counter = 0;
			$unittemp = array();
			while ( $counter < $multiple  ){
				$id = $start_time + ($counter * $level_increment); 
				$unittemp[$id] = array( $temp );
				$counter++;
			}
			$array = array( $level_array[$i]['name'] => $unittemp );
			$temp = $array;
		}
		$this->calendar_array = $temp;
		return $temp;
	}
	public function get_date( $stamp ){
		$sel = new stdClass;
		$sel->unixstamp = $stamp;
		$sel->start_of_day = strtotime( 'today', $stamp );
		$sel->day = date( 'l', $stamp );
		$sel->day_of_week = date( 'N', $stamp ); 
		$sel->day_of_month = date( 'd', $stamp );
		$sel->month = date( 'm', $stamp );
		$sel->year = date( 'Y', $stamp ); 
		$sel->days_in_month = $this->get_total_days( $sel ) ;
		$sel->time = date( 'G:i e', $stamp );
		return $sel;
	}
    public function get_total_days( $time_obj ){
		$days_in_month = array('01' => 31, '02' => 28,	'03' => 31, '04' => 30,	'05' => 31, '06' => 30,	'07' => 31, '08' => 31, '09' => 30, '10' => 31, '11' => 30, '12' => 31 );
        if ($time_obj->month == 02){
            if ($time_obj->year % 400 == 0 OR ($time_obj->year % 4 == 0 AND $time_obj->year % 100 != 0)){
                return 29;
            }
        }
		return $days_in_month[$time_obj->month];
    }
	/** OUTPUT **/
	function output_calendar( ){
		$out .= "<div class='cal-".$cal->range_units."'>\n";
		foreach($this->calendar_array as $unit_name=>$unit_array){
			$counter = 0;
			$out .=" <div class='cal-WEEK'> \n";
			$first_day = date ( 'w' , $this->start_of_range);
			$empty_days = 0;
			while($empty_days < $first_day){
				$out .= " <div class='cal-EMPTYDAY'></div>\n";				
				$empty_days++;
			}
			foreach($unit_array as $timestamp=>$timestamp_array){
				$counter++;
				if( date ('w', $timestamp) < 1 ){
					$out .="<div class='cal-WEEK'> \n";
				}
				$out .=" <div class='cal-".$unit_name."' data-timestamp='".$timestamp."'>".date ('D M j Y ', $timestamp);
				if( $events = get_event( $timestamp) ){
					foreach( $events as $event_time=>$event_arr){
						$out .= "\n<div class='cal-EVENT'>".$event_arr->post_title."</div>";
					}
				}
				$out .="</div>\n";
				if(  date ( 'w' , $timestamp ) == 6 || $counter == count($unit_array)){
					$out .= "</div><!--/cal-WEEK-->\n";
				}
			}
		}
		$out .= "</MONTH>\n";
		echo $out;
	}
}