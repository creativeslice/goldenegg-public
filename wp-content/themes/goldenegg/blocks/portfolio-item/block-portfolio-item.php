 <?php // ACF Gutenberg

	$logo = get_field( 'logo' );
	$title = get_field( 'title' );
	$description = get_field( 'description' );
	$rows = get_field( 'repeater' );
	
	
	// create align class ("alignwide") from block setting ("wide")
	$align_class = $block['align'] ? 'align' . $block['align'] : '';
  
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
	
	<?php if( $rows ) :
		foreach( $rows as $row ) : 
			$card_title = $row['title'];
			$card_image = $row['image'];
		?>
			<?php if ($card_title) { ?>
				<h4><?php echo $card_title; ?></h4>
			<?php } ?>
			<?php if ($card_image) { ?>
				<img
					src="<?php echo $card_image['sizes']['hdsm']; ?>"
					alt="<?php echo $card_image['alt']; ?>"
					class="" />
			<?php } ?>
		<?php endforeach; 
	endif; ?>
</div>
