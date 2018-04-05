<div class="videoContainer">

<?php if ($video_cover) { ?>
    <iframe class="playVideo" data-src="https://player.vimeo.com/video/<?php echo $vimeo_id; ?>?autoplay=1" src="about:blank"></iframe>

	<img class="videoCover" src="<?php echo $video_cover['sizes']['large']; ?>">
	<button class="playButton">
		<svg title="Play"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#play"></use></svg>
		Watch Video
	</button>

<?php } else { ?>
	<iframe src="https://player.vimeo.com/video/<?php echo $vimeo_id; ?>"></iframe>
	
<?php } ?>
</div>
