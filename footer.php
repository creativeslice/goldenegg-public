<footer class="footer">

	<div class="wrap">
		
		<?php wp_nav_menu(array(
			'container' => false,
			'menu_class' => 'footerLinks',
			'theme_location' => 'footerLinks',
			'depth' => 1
		)); ?>
		
		<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. <a target="_blank" href="https://creativeslice.com">Crafted by Creative Slice</a></p>

	</div>

</footer>
	
</div><?php // Closes #container from header.php ?>

<?php wp_footer(); ?>

</body>
</html>