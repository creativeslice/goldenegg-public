#Egg-Calendar#



##Calling the Calendar##
```php
<?php $cal = new calendar(); $cal->init(); ?>
```  
  or with arguments:
```php
<?php $args = array( 'range'=>'2 Weeks' ); $cal = new calendar( $args ); $cal->init(); ?>
```  

##Arguments & Defaults##

```php
<?php
$defaults = array(
  'range'           =>  '1 Month',
  'selected_time'   =>  NULL,										
  'start_type'      =>  'selected',									
  'increment_array' =>  array('WEEK','DAY'),						
  'debug'           =>  1, 
  'add_style'       =>  1											
);
?>
```
* **range**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Natural language range, i.e. '2 Weeks' or '7 Days'

* **selected_time**&nbsp;&nbsp;&nbsp;&nbsp;- Options: 'selected' starts on selected time; 'natural' starts at beginning of range;

* **start_type**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Sets range of time shown in range units (i.e., 1 WEEK)

* **increment_array**&nbsp;- Units to display, less than the Range. i.e, array('DAY','WEEK') for a range of '1 Month'.

* **debug**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Set debug to '1' for error messages; 0 for production

* **add_style**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Set add_style to '1' for styles in development; 0 for prodcution;

##Outputting to the Page##
###Output Option 1:###

```php
<?php $cal->output_month(); ?> 
```
Or:
```php
<?php $cal->output_week(); ?>
```
###Output Option 2 (Recommended):###
Copy the $cal->output_month() function to the page
```php

```

##Notes##

**Calendar** returns a nested array of timestamp keys across a defined range of time units, such as 2 Months of weeks, or 2 weeks of days.

For example, a request for '2014-08' returns the following:
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


