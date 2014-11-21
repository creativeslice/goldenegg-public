<?php

/*********************
YOUTUBE CUSTOMIZATION
Customize embedding youtube

CSS:
.video-container {
    position: relative;
    padding-bottom: 56.25%;
    // padding-bottom: 51.5%; for no-frame videos
    padding-top: 35px;
    height: 0;
    width: 100%;
    overflow: hidden;
    margin-bottom: 1em;
    iframe {
	    position: absolute;
	    top:0;
	    left: 0;
	    width: 100%;
	    height: 100%;
    }
}

*********************/

add_filter( 'embed_oembed_html', 'egg_set_youtube_params', 10, 4 );
function egg_set_youtube_params($html, $url, $args, $id) {
// PARAMETER OPTIONS
	$iframe_args['width'] = '100%';
	$iframe_args['height'] = '100%';
	$iframe_args['frameborder'] = '0';
	$iframe_args['allowfullscreen'] = 'allowfullscreen';
	
	$video_args['wmode'] = 'transparent';
	$video_args['show_info'] = '0';
	$video_args['color'] = 'black';
	$video_args['feature'] = 'oembed';
	// $video_args['autohide'] = '0';
	$video_args['rel'] = '0';
	$video_args['iv_load_policy'] = '3';
	$video_args['autoplay'] = '0';
	$video_args['controls'] = '2';
	
	// $video_args['modestbranding'] = '1';
	// $video_args['disablekb'] = '1';
	// $video_args['enabejsapi'] = '1';
	// $video_args['end'] = '0';
	// $video_args['fs'] = '0';
	// $video_args['list'] = '0';
	// $video_args['listType'] = '0';
	// $video_args['loop'] = '1';
	// $video_args['origin'] = '0';
	// $video_args['playerapiid'] = '0';
	// $video_args['playlist'] = '0';
	// $video_args['playsinline'] = '0';
	// $video_args['start'] = '0';
	// $video_args['theme'] = '0';
// END PARAMETER OPTIONS

	if(count(@$video_args)>0){
		$i = 0;
		$query_str = "?";
		foreach($video_args as $key=>$arg){
			if($i == 1){ $query_str .="&"; }
			$query_str .= $key."=".$arg;
			$i=1;
		}
	}
	$iframe_arr = explode ( ' ', htmlentities($html));
	foreach( $iframe_arr as $key=>$value ){
		if(preg_match('/width/',$value)){
			$original_width = preg_replace('/\D/', '', $value);
		}
		if(preg_match('/height/',$value)){
			$original_heght = preg_replace('/\D/', '', $value);
		}
	}
	if(@$iframe_args['width']==0){
		$iframe_args['width'] = $original_width;
	}
	if(@$iframe_args['height']==0){
		$iframe_args['height'] = $original_width;
	}
    $url_string = parse_url($url, PHP_URL_QUERY);
    parse_str($url_string, $id);
    if (isset($id['v'])) {
   	     return '<div class="video-container"><iframe width="'.$iframe_args['width'].'" height="'.$iframe_args['height'].'" src="//www.youtube.com/embed/'.$id['v'].@$query_str.'" frameborder="'.@$iframe_args["frameborder"].'" '.@$iframe_args["allowfullscreen"].'></iframe></div>';
    }
    return $html;
}

?>