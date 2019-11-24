<?php // find top ancestor for sub menu
if ($post->post_parent)	:
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$topid = $ancestors[$root];
	$current = '';
else :
	$topid = $post->ID;
	$current = 'current_page_item';
endif;

// check for sub pages
$children = get_pages(array( 'child_of' => $topid ));
if (count($children) != 0) : ?>
<aside class="sidebar">
	<ul class="sideMenu">
		<li class="<?php echo $current; ?>">
			<a href="<?php echo get_permalink($topid); ?>"><?php echo get_the_title($topid); ?>&nbsp;&rsaquo;</a>
		</li>
		<?php wp_list_pages("title_li=&depth=1&link_after= ›&child_of=".$topid); ?>
	</ul>
</aside>
<?php endif; ?>
