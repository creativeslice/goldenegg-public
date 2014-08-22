<div class="sidebar goldsmall" role="complementary">
	
	<div class="entry-content">
	
		<?php if (@$post->post_parent)	{
			$ancestors=get_post_ancestors($post->ID);
			$root=count($ancestors)-1;
			$topid = $ancestors[$root];
			$current = "";
			
		} else {
			$topid = @$post->ID;
			$current = 'current_page_item';
		} 
		?>
	
		<ul class="side-menu">
			<li class="<?php echo $current; ?>"><a href="<?php echo get_permalink($topid); ?>"><?php echo get_the_title($topid); ?></a>
				<ul>
					<?php wp_list_pages("title_li=&child_of=".$topid); ?>
				</ul>
			</li>
		</ul>

		<hr>
	
		<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar1' ); ?>
		<?php endif; ?>

	</div>

</div>
