<?php // Banner Notices
	
	$notice_active = get_field('notice_active', 'option');
	$notice_color = get_field('notice_color', 'option');
	$notice_location = get_field('notice_location', 'option');
	$notice_message = get_field('notice_message', 'option');
	$notice_link = get_field('notice_link', 'option');
	
	// Check time
	$curTime = current_time( 'timestamp' );
	$start_date = get_field( 'notice_start', 'option');
	$end_date = get_field( 'notice_end', 'option');
	$start_stamp = strtotime( $start_date ); 
	$end_stamp = strtotime( $end_date );
	
// Check if notice status is active
if($notice_active) :

// Check if time is now
if( $start_stamp <= $curTime && $curTime <= $end_stamp && ( $start_stamp < $end_stamp ) ) :
?>

	<?php // Homepage only
	if ($notice_location == 'home') {
		if ( is_front_page() ) { ?>
			<div class="notice <?php echo $notice_color; ?>Color">
				<?php echo $notice_message; ?>
				
				<?php if($notice_link) { 
					$link_url = $notice_link['url'];
					$link_title = $notice_link['title'];
					$link_target = $notice_link['target'] ? $notice_link['target'] : '_self';
				?>
				<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
				<?php } ?>
				
			</div>
		<?php } ?>
		
	<?php // Show notice everywhere
	} else { ?>
		<div class="notice <?php echo $notice_color; ?>Color">
			<?php echo $notice_message; ?>
			
			<?php if($notice_link) { 
				$link_url = $notice_link['url'];
				$link_title = $notice_link['title'];
				$link_target = $notice_link['target'] ? $notice_link['target'] : '_self';
			?>
			<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
			<?php } ?>
				
		</div>
	<?php } ?>

<?php endif; endif; ?>