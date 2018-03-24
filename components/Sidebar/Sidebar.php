<?php 
	$sidebar_content = get_field('sidebar_content');
	$badge_color = get_field('side_badge_color');
	$badge_huge = get_field('side_badge_huge');
	$badge_title = get_field('side_badge_title');
	$badge_hand = get_field('side_badge_hand');
	$badge_link = get_field('side_badge_link');
?>

<?php if ($badge_color && $badge_color !== 'none' || $sidebar_content) : ?>
<aside class="sideSmall entryContent">
	
	<?php if ($badge_color !== 'none') {
		include(locate_template( 'components/CircleInk/CircleInk.php' ));
	} 
		if ($sidebar_content) { echo $sidebar_content; }
	?>

</aside>
<?php endif; ?>