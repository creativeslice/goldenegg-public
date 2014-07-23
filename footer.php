			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap cf">

					<nav role="navigation">
					<?php wp_nav_menu(array(
    					'container' => false,							// remove nav container
    					'menu' => 'Footer Links',   					// nav name
    					'menu_class' => 'nav footer-nav',            	// adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
						'after' => '',                                  // after the menu
						'link_before' => '',                            // before each link
						'link_after' => '',                             // after each link
						'depth' => 0                            		// limit the depth of the nav
					)); ?>
					</nav>

					<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>

				</div>

			</footer>

		</div>
		<?php wp_footer(); ?>
	</body>
</html>
