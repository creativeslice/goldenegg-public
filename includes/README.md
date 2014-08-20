#Egg-Calendar#



##Example with Events##
```php
<?php 
  $events = get_events();
  $args = array( 'range'=>'2 Weeks' ); 
  $cal = new calendar( $args ); 
  $cal->output_month();
?>
```  

##Calendar Arguments##

```php
<?php
// args shown below with defaults
$args = array(
  'range'           =>  '1 Month',
  'selected_time'   =>  NULL,										
  'start_type'      =>  'selected',									
  'increment_array' =>  array('WEEK','DAY'),						
  'debug'           =>  1, 
  'add_style'       =>  1											
);
$cal = new calendar( $args ); 
?>
```
* **range** - Options: use a natural language range like '2 Weeks' or '7 Days'

* **selected_time** - Option: Date String - default is current time (i.e this month, this week, this day); 

* **start_type** - Options: 'selected', 'natural' | 'selected' starts on selected time; 'natural' starts at beginning of range;

* **increment_array** - Options: 'WEEK', 'DAY , 'HOUR' | Units to display, less than the Range. i.e, array('DAY','WEEK') for a range of '1 Month'.

* **debug** - Set debug to '1' for error messages; 0 for production

* **add_style** - Set add_style to '1' for styles in development; 0 for prodcution;

##Getting Events##
```php
<?php 

  $events = get_events( $start_date , $number_of_days_to_search , $event_category );
  
  // @$start_date : string format, 20140807 for August 7 2014. (default is current time)
  // @$number_of_days_to_search : number of days beyond start_date which to search (default is 1 day)  
  // @$event_category : optional category restriction
  
  // returns chronologically ordered array of timestamped event posts. Timestamp is from ACF date field.

Array (
  [1407182400] => stdClass Object
        (
            [ID] => 14113
            [post_author] => 9
            [post_date] => 2014-07-30 15:02:42
            	•••
        )
  [1407787200] => stdClass Object
        (
            [ID] => 14113
            [post_author] => 9
            	•••
        )
)
?>
```

##Outputting to the Page##
###Output Option 1:###

```php
<?php $cal->output_month(); $cal->output_week(); ?>
```
###Output Option 2:###
Copy the $cal->output_month() function to the template-page.php:
```php

```

##Notes##

**Calendar** returns a nested array of timestamp keys across a defined range of time units, such as 2 Months of weeks, or 2 weeks of days.

For example, a request for '1 Month' for '2014-08' returns the following:
```
  		[WEEK] => Array
  			(
  				[1406419200] => Array
  					(
  						[DAY] => Array
  							(
  								[1406419200] => Jul 27 Sun 2014 00:00
  								[1406505600] => Jul 28 Mon 2014 00:00
  								[1406659200] => Jul 29 Tue 2014 00:00
  								[1406678400] => Jul 30 Wed 2014 00:00
  								[1406764800] => Jul 31 Thu 2014 00:00
  								[1406851200] => Aug 01 Fri 2014 00:00
  								[1406937600] => Aug 02 Sat 2014 00:00
  							)
  					)
  				[1407024000] => Array
  					(
  						[DAY] => Array
  							(
  								[1407024000] => Aug 03 Sun 2014 00:00
  									•••
  							)
  					)
  					•••
  			)
  			
  // [WEEK] is an array of the month's (5) weeks
  // [1406419200] is a WPLOCAL timestamp of 12:00 AM of the first Sunday of Week 1 (WPLOCAL defined below)
  // [DAY] is an array of the week's (7) days
  // [1406419200] => Jul 27 Sun 2014 00:00	The key is a WPLOCAL timestamp of 12:00 AM of the day
  // [1406505600] => Jul 28 Mon 2014 00:00	The value is a Date String for reference (modifiable by developer).
  // [1407024000] is a WPLOCAL timestamp of 12:00 AM of the first Sunday of Week 2 
  //    ••• are arrays omitted for space
```

**Calendar** uses the Wordpress General Settings for Timezone and returns timestamps (called here WPLOCAL) that are UnixTime offset by the Wordpress timezone_offset. If a Wordpress Timezone is not set, **Calendar** outputs true UnixTime referenced to UTC. 

WPLOCAL timestamps are: *the number of seconds that have elapsed since 00:00:00 Wordpress Local TimeZone, Thursday, 1 January 1970.*


