<?php get_header(); ?>

<div id="content">

	<div class="wrap">

		<div id="main" role="main">

			<h1><?php single_cat_title(); ?></h1>
			
			<?php // Event Calendar custom taxonomy (event_cat)
			if(isset($wp_query->query_vars['calendar_date'])) {
		
				//	$cat = urldecode($wp_query->query_vars['event_cat']);
				$cat = get_query_var($wp_query->query_vars['taxonomy']);
			
				$selected_date = urldecode($wp_query->query_vars['calendar_date']);
				$events = new eggEvents;
				$events->get_events( $selected_date,'31', $cat );	
				$args = array(
					'range'			=> '1 month',
					'selected_time'	=> NULL,
					'start_type'	=> 'natural',
					'add_style'		=> 1,
					'debug'			=> 1
				);
				$cal = new calendar( $args );
				$cal->output_month();
				unset($cal);
			} else {
				echo "Taxonomy-event.cat.php:
				<br> Get Event Category Calendar by adding date:
				<a href='".$_SERVER["REQUEST_URI"] ."/2015-01'>event-cat/category-name/2015-01</a>";
			}
			?>
			
		</div>

	</div>

</div>

<?php get_footer(); ?>
