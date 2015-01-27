			<footer class="footer" role="contentinfo">

				<div class="wrap">

					<nav role="navigation">
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

					<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>

				</div>

			</footer>
<?php get_template_part( 'partials/content', 'weather' );	?>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
