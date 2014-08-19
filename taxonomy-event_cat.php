<?php get_header(); ?>

<div id="content">

	<div class="wrap">
	<div style='height:150px; width:1px;'></div>
	<h1><?php single_cat_title(); ?></h1>
			<?php
if(isset($wp_query->query_vars['calendar_date'])) {

//	$cat = urldecode($wp_query->query_vars['event_cat']);
	$cat    = get_query_var($wp_query->query_vars['taxonomy']);

	$selected_date = urldecode($wp_query->query_vars['calendar_date']);
	$events = new eggEvents;
	$events->get_events( $selected_date,'31', $cat );	
	$args = array(
		'range'=>'1 month',
		'selected_time'=>NULL,
		'start_type'=>'natural',
		'add_style'=>1,
		'debug'=>1
	);
	$cal = new calendar( $args );
	$cal->init();
	$cal->output_month();
	//print_r($cal);
	unset($cal);
}
else{
	$day = strtotime( 'first day of ' . date_i18n( 'F Y'));
	$selected_date = date_i18n('Ymd' , $day);	
}
?>

	</div>

</div>

<?php get_footer(); ?>
