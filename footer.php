	<footer class="footer">

		<div class="wrap">
			
			<?php get_template_part( '/partials/svg', 'emblem' ); ?>

			<nav>
			<?php wp_nav_menu(array(
				'container' => false,						// remove nav container
				'menu' => 'Footer Links',					// nav name
				'menu_class' => 'footer-nav',				// adding custom nav class
				'theme_location' => 'footer-links',			// where it's located in the theme
				'before' => '',								// before the menu
				'after' => '',								// after the menu
				'link_before' => '',						// before each link
				'link_after' => '',							// after each link
				'depth' => 0								// limit the depth of the nav
			)); ?>
			</nav>
			
			<hr>
			
			<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. Website by <a target="_blank" href="https://creativeslice.com">Creative Slice</a></p>

		</div>

	</footer>
	
</div><!-- Closes #container -->

<?php wp_footer(); ?>

</body>
</html>