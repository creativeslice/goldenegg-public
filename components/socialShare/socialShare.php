<div class="shareLinks">
	
	<?php 
		$title		= get_the_title();
		$permalink	= get_permalink();
		$hastag		= strtolower( str_replace(' ', '', get_option('blogname')) );
		$twitter	= 'creativeslice';
		$thumb_url	= wp_get_attachment_image_src( get_post_thumbnail_id() );
		$image		= apply_filters( 'egg/share_image', ($thumb_url ? $thumb_url[0] : '') );
	
		$links = array(
			array(
				'title' => 'Email',
				'icon'  => 'email',
				'url'   => 'mailto:?subject=' . rawurlencode($title) . '&body=You should read ' . urlencode($title) . ' at ' . get_option('blogname') . ': ' . $permalink,
			),
			array(
				'title' => 'Twitter',
				'icon'  => 'twitter',
				'url'   => 'http://twitter.com/share?text=' . urlencode($title) . '&url=' . $permalink . ($hastag ? '&hashtags=' . $hastag : '') . ($twitter ? '&via=' . $twitter : ''),
			),
			array(
				'title' => 'Linkedin',
				'icon'  => 'linkedin',
				'url'   => 'http://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&title=' . urlencode($title) . '&summary=' . urlencode(get_the_excerpt()) . '&source=' . home_url('/'),
			),
			array(
				'title' => 'Facebook',
				'icon'  => 'facebook',
				'url'   => 'http://www.facebook.com/sharer.php?m2w&s=100&p[url]=' . $permalink . ($image ? '&p[images][0]=' . $image : '') . '&p[title]=' . urlencode($title) . '&p[summary]=' . urlencode(get_the_excerpt()),
			),
			array(
				'title' => 'Google+',
				'icon'  => 'google-plus',
				'url'   => 'https://plus.google.com/share?url=' . $permalink,
			),
		);
	?>

	<?php foreach ( $links as $link ) : ?>
	<a class="share-<?php echo $link['icon']; ?>" href="<?php echo $link['url']; ?>" title="Share via <?php echo $link['title']; ?>" target="_blank">
		<svg title="<?php echo $link['icon']; ?>">
			<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#<?php echo $link['icon']; ?>"></use>
		</svg>
		<span class="screen-reader-text">Share via <?php echo $link['title']; ?>: <?php echo $title; ?></span>
	</a>
	<?php endforeach; ?>
	
</div>