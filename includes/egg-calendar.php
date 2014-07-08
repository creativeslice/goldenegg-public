<?php 
/**
 * egg-calendar
 * time is processed as UTC - displayed in local timezone
 */

class calendar{
	/** VARIABLES **/
 	const DEFAULT_START_TYPE = 'natural';								// Options: 'selected' starts on selected time; 'natural' starts at beginning of range;
 	const DEFAULT_RANGE_UNITS = 'WEEK';									// Options use time constants defined below
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
		$this->get_date( 'selected' );
		$this->get_date( 'now' );
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
		$range_unit_in_seconds = constant( 'calendar::'.$this->range_units );
		$this->range_in_seconds = $range_unit_in_seconds * $this->range_multiple;
		$this->start_of_range = $this->get_start_of_increment( $this->range_units , $this->selected->unixstamp);
	//	Loop over requested increments and order array in descending order
		$this->increment_array[] = $this->range_units;
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
				$sorted_increment_array[$key] = array( 'seconds'=>$key, 'name'=>$increment_name );
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
		if( 'selected' == $this->start_type ){										
			$this->start_time = '1'; 								//round to beginning of lowest increment
		}
		else{
			$this->get_start_of_increments();
		}
//print_r($this);

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
	public function generate(){
		$increment_array = $this->increment_array;
		$this->generate_units( $increment_array );
	}
	public function generate_units( $increment_array ){
		$unit_array = array_shift( $increment_array );
		$output = array();
		$seconds = $unit_array['seconds'];
		$name = $unit_array['name'];
		$unit_count = $counter = floor( $this->range_in_seconds / $seconds);
		while($counter > 0){
			$key = $unit_count - $counter;
			$output[$name][$key] = array(); 
			$counter--;
		}	
		if( count($increment_array )> 0 ){
			$this->generate_units( $increment_array );
		}
		//print_r($output);
	}
	
	public function Oldgenerate_unit( ){
//	print_r($this);
		foreach( $this->increment_array as $seconds=>$increment_array ){
			$name = $increment_array['name'];
			$start_time_of_unit = $counter = $this->increment_array[$seconds]['start_time_of_unit'];
//return textdate based on unit get_textdate( $seconds );
			$output[$name][$start_time_of_unit] = array( 'textdate'=>date( ' F j Y', $counter));
			//echo $counter;
			
			$this->increment_array[$seconds]['number_of_units_counter'] = floor( $this->range_in_seconds / $seconds);
			while( $counter < ($this->start_of_range + $seconds) ){
echo "seconds".$seconds."<br>";
//			echo "builder";
				$output[$name][$start_time_of_unit]['DAY'][$counter] = array( 'textdate'=>date( ' F j Y', $counter) );
//				echo "Date:".date( ' F j Y', $counter)."<br>";
				$counter = $counter + self::DAY;
				
				$this->increment_array[$seconds]['number_of_units_counter']--;
			}
			
		}
		print_r($output);
	}
	public function get_date( $option ){
		$sel = $this->$option;
		$stamp = $sel->unixstamp;
		$sel->start_of_day = strtotime( 'today', $stamp );
		$sel->day = date( 'l', $stamp );
		$sel->day_of_week = date( 'N', $stamp ); 
		$sel->day_of_month = date( 'd', $stamp );
		$sel->month = date( 'm', $stamp );
		$sel->month_name = $month_name[ date( 'm', $stamp ) ];
		$this->get_total_days( $option ) ;
		$sel->year = date( 'Y', $stamp ); 
		$sel->secs_from_midnight = $stamp - $sel->start_of_day;
		$sel->time = date( 'G:i e', $stamp );
	}
	
    // Total days in a given month - checks for leap year
    public function get_total_days( $option ){
    	$sel = $this->$option;
        $days_in_month = array('01' => 31, '02' => 28,	'03' => 31, '04' => 30,	'05' => 31, '06' => 30,	'07' => 31, '08' => 31, '09' => 30, '10' => 31, '11' => 30, '12' => 31 );
        if ($sel->month == 02){
            if ($sel->year % 400 == 0 OR ($sel->year % 4 == 0 AND $sel->year % 100 != 0)){
                $sel->days_in_month = 29;
            }
        }
		$sel->days_in_month = $days_in_month[$sel->month];
    }
	public function build_unit(){
		$unit = $this->unit;
		call_user_func('calendar::build_'.$unit);
    }
    public function build_day(){
    
	    echo "day";
	}
    public function build_week(){
	    echo "week";
    }
    public function build_month(){
	    
    }
    public function prev_url()
    {
        $date = $this->_adjust_date($this->current_month - 1, $this->current_year);
        return str_replace(array('%m', '%y'), array($date['month'], $date['year']), $this->url);
    }
    
    public function next_url()
    {
        $date = $this->_adjust_date($this->current_month + 1, $this->current_year);
        return str_replace(array('%m', '%y'), array($date['month'], $date['year']), $this->url);
    }
    
    public function weeks()
    {
        return $this->weeks;
    } 
}