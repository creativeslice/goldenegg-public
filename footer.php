	<footer class="footer">

		<div class="wrap">
			
			<?php get_template_part( '/partials/svg', 'emblem' ); ?>

			<?php wp_nav_menu(array(
				'container' => false,						// remove nav container
				'menu_class' => 'footer-nav',				// custom nav class
				'theme_location' => 'footer-links',			// menu location
				'depth' => 0								// depth of the nav
			)); ?>
			
			<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. Website by <a target="_blank" href="https://creativeslice.com">Creative Slice</a></p>

		</div>

	</footer>
	
</div><?php // Closes #container from header.php ?>

<?php wp_footer(); ?>

</body>
</html>