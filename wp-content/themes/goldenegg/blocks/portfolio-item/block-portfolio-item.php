 <?php // ACF Gutenberg

	$logo = get_field( 'logo' );
	$title = get_field( 'title' );
	$description = get_field( 'description' );
?>

<div class="portfolio-item">
	<?php if( !empty( $logo ) )
		echo wp_get_attachment_image( $logo['ID'], 'thumbnail', null, array( 'class' => 'portfolio-logo alignleft' ) );
	?>
	<?php if( !empty( $title ) ) { ?>
		<h3 class="portfolio-title"><?php echo $title; ?></h3>
	<?php } ?>
	<?php if( !empty( $description ) ) { ?>
		<div class="portfolio-description"><?php echo $description; ?></div>
	<?php } ?>
</div>
