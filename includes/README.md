#Egg-Calendar#

**Calendar** returns a nested array of timestamp keys across a defined range of time units, such as 2 Months of weeks, or 2 weeks of days.

For example, a request for '2014-08' returns the following:
```
  		[WEEK] => Array														// 'WEEK' is an array of the month's (5) weeks
  			(
  				[1406419200] => Array										// a WPLOCAL timestamp of 12:00 AM of the first Sunday of Week 1 (WPLOCAL defined below)
  					(
  						[DAY] => Array										// 'DAY' is an array of the week's (7) days
  							(
  								[1406419200] => Jul 27 Sun 2014 00:00		// a WPLOCAL timestamp of 12:00 AM of the day
  								[1406505600] => Jul 28 Mon 2014 00:00		// The Value of the lowest level pair is a Date String but can be modified by developer.
  								[1406659200] => Jul 29 Tue 2014 00:00
  								[1406678400] => Jul 30 Wed 2014 00:00
  								[1406764800] => Jul 31 Thu 2014 00:00
  								[1406851200] => Aug 01 Fri 2014 00:00
  								[1406937600] => Aug 02 Sat 2014 00:00
  							)
  					)
  				[1407024000] => Array										// a WPLOCAL timestamp of 12:00 AM of the first Sunday of Week 2 
  					(
  						[DAY] => Array
  							(
  								[1407024000] => Aug 03 Sun 2014 00:00
  									•••
  							)
  					)
  					•••
  			)
```

##Calling the Calendar##
```php
<?php $cal = new calendar(); $cal->init(); ?>
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
**@range**                Natural language range, i.e. '2 Weeks' or '7 Days'

**@selected_time**        Options: 'selected' starts on selected time; 'natural' starts at beginning of range;

**@start_type**           Sets range of time shown in range units (i.e., 1 WEEK)

**@increment_array**      Units to display (less than the Range; i.e., 'DAY','WEEK' )

**@debug**                Set debug to '1' for error messages; 0 for production

**@add_style**            Set add_style to '1' for styles in development; 0 for prodcution;

##Notes##
**Calendar** uses the Wordpress General Settings for Timezone and returns timestamps (called here WPLOCAL) that are UnixTime offset by the Wordpress timezone_offset. If a Wordpress Timezone is not set, **Calendar** outputs true UnixTime referenced to UTC. 

WPLOCAL timestamps are: *the number of seconds that have elapsed since 00:00:00 Wordpress Local TimeZone, Thursday, 1 January 1970.*


