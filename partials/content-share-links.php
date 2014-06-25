<div class="share-links">

	<em>Share:</em>

	<?php 
		$title     = get_the_title();
		$permalink = get_permalink();
		$hastag    = strtolower( str_replace(' ', '', get_option('blogname')) );
		$image     = apply_filters( 'egg/share_image', (has_post_thumbnail() ? the_post_thumbnail() : '') );
		$links = array(
			array(
				'title' => 'Email',
				'icon'  => 'email',
				'url'   => 'mailto:?subject=' . urlencode($title) . '&body=You should read ' . urlencode($title) . ' at ' . get_option('blogname') . ': ' . $permalink,
			),
			array(
				'title' => 'Twitter',
				'icon'  => 'twitter',
				'url'   => 'http://twitter.com/share?text=' . urlencode($title) . '&url=' . $permalink . ($hastag ? '&hashtags=' . $hastag : ''),
			),
			array(
				'title' => 'Linkedin',
				'icon'  => 'linkedin',
				'url'   => 'http://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&title=' . urlencode($title) . '&summary=' . urlencode(get_the_excerpt()) . '&source=' . home_url('/'),
			),
			array(
				'title' => 'Facebook',
				'icon'  => 'facebook',
				'url'   => 'http://www.facebook.com/sharer.php?s=100&p[url]=' . $permalink . ($image ? '&p[images][0]=' . $image : '') . '&p[title]=' . urlencode($title) . '&p[summary]=' . urlencode(get_the_excerpt()),
			),
			array(
				'title' => 'Google+',
				'icon'  => 'googleplus',
				'url'   => 'https://plus.google.com/share?url=' . $permalink,
			),
			array(
				'title' => 'Pinterest',
				'icon'  => 'pinterest',
				'url'   => 'https://pinterest.com/pin/create/bookmarklet/?' . ($image ? 'media='.$image.'&' : '') . 'url=' . $permalink . (apply_filters('egg/share_is_video', false) ? '&is_video=true' : '') . '&description=' . urlencode($title),
			),
		);
	?>

	<?php foreach ( $links as $link ) : ?>
	<a class="share-<?php echo $link['icon']; ?>" href="<?php echo $link['url']; ?>" title="Share via <?php echo $link['title']; ?>" target="_blank">
		<span class="icon-<?php echo $link['icon']; ?>" aria-hidden="true"></span>
		<span class="screen-reader-text">Share via <?php echo $link['title']; ?>: <?php echo $title; ?></span>
	</a>
	<?php endforeach; ?>

	<input type="text" class="share-url" value="<?php add_query_arg( 'feature', 'share', the_permalink() ); ?>" />

</div>