<?php get_header(); // Template Name: Calendar ?>


<div id="content">

	<div class="wrap">

		<div id="main" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class( 'cf' ); ?>>

				<header class="article-header">
					<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
				</header>
<?php
echo "<style>

.cal-WEEK {  border:solid 1px grey; }
.cal-DAY, .cal-EMPTYDAY {display:inline-block; vertical-align:top; width: 13%; height: 100px;}
.cal-current-DAY { background-color:#A9A7AD;  }
.cal-past-DAY, .cal-past-DAY a { background-color: #d7d7d8; color:grey}
.cal-prev { display:inline-block; }
.cal-next{ float:right; display:inline-block;}
</style>";

if(isset($wp_query->query_vars['calendar_date'])) {
	$cal_date = urldecode($wp_query->query_vars['calendar_date']);
	$selected_date = strtotime( $cal_date );
}
else{
	$selected_date = time();
}
$cal = new calendar( $selected_date );

// set parameters: 
$cal->range_units = 'month';
//$cal->range_multiple = '1';
$cal->increment_array = array('week','day', 'hour');


$cal->init();
$cal->build_calendar_output();
print_r($cal->outputCalendar);
$cal->output_month();
			
?>
				<section class="entry-content" itemprop="articleBody">
					<?php the_content(); ?>
				</section>

			</article>

			<?php endwhile; endif; ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
