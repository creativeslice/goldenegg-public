<footer class="pageFooter">

	<div class="wrap">
		
		<?php wp_nav_menu(array(
			'container' => false,
			'menu_class' => 'footerLinks',
			'theme_location' => 'footerLinks',
			'depth' => 1
		)); ?>
		
		<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. <a rel="noopener" target="_blank" href="https://creativeslice.com">Crafted by Creative Slice</a></p>

	</div>

</footer>