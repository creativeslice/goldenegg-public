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
				<img class=""
					src="<?php echo $card_image['sizes']['hdsm']; ?>"
					alt="<?php echo $card_image['alt']; ?>"/>
			<?php } ?>
		<?php endforeach; 
	endif; ?>
	
	<h6>Posts</h6>
	<?php $posts = get_posts(array(
		'posts_per_page'	=> 9,
		'post_type'			=> 'post',
	));
	if( $posts ): 
	global $post; // Need to make sure we overwrite the global Post Object ?>
	<?php foreach( $posts as $post ): setup_postdata( $post ); ?>
		<a href="<?php the_permalink(); ?>">
			<h4><?php the_title(); ?></h4>
			<?php the_post_thumbnail('thumbnail'); ?>
		</a>
	<?php endforeach; ?>
	<?php wp_reset_postdata(); endif; ?>
</div>
