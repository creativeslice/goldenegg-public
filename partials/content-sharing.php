<div class="share-links">
	<em>Share:</em>

	<?php // $post_id = $GLOBALS['post']->ID;
		$title     = get_the_title(); #ucfirst( strtolower(get_the_title($post_id)) );
		$permalink = get_permalink();
		$email_share_link  = 'mailto:?subject=' . urlencode($title) . '&body=' . $permalink;
		$twitter_share_link  = 'http://twitter.com/share?text=' . urlencode($title) . '&url=' . $permalink . '&hashtags=creativeslice';
		$linkedin_share_link = 'http://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&title=' . urlencode($title) . '&summary=' . urlencode(get_post_field('post_excerpt', $post_id)) . '&source=' . home_url('/');
		$facebook_share_link  = 'https://facebook.com/sharer.php?u=' . $permalink;
	?>
	
	<a target="_blank" href="<?php echo $email_share_link; ?>" title="Share via Email">
		<span class="icon-envelope" aria-hidden="true"></span>
		<span class="screen-reader-text">Share via Email: <?php echo $title; ?></span>
	</a>
	<a target="_blank" href="<?php echo $twitter_share_link; ?>" title="Share via Twitter">
		<span class="icon-twitter" aria-hidden="true"></span>
		<span class="screen-reader-text">Share via Twitter: <?php echo $title; ?></span>
	</a>
	<a target="_blank" href="<?php echo $linkedin_share_link; ?>" title="Share via Linkedin">
		<span class="icon-linkedin" aria-hidden="true"></span>
		<span class="screen-reader-text">Share via Linkedin: <?php echo $title; ?></span>
	</a>
	<a target="_blank" href="<?php echo $facebook_share_link; ?>" title="Share via Facebook">
		<span class="icon-facebook" aria-hidden="true"></span>
		<span class="screen-reader-text">Share via Facebook: <?php echo $title; ?></span>
	</a>	

</div>
