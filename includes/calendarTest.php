<?php
$day = strtotime( 'August 24 2016 3:30' );
$cal = new calendar( $day );
$cal->range_units = 'month';
$cal->start_type = 'ca';
$cal->range_multiple = '1';
	$cal->increment_array = array('day');
$cal->init();

//print_r($cal);
$cal->Oldgenerate_unit();
?>	