<footer class="page-footer">

	<div class="wrap">

		<?php wp_nav_menu(array(
			'container' => false,
			'menu_class' => 'footer-links',
			'theme_location' => 'footer-links',
			'depth' => 1
		)); ?>

		<a class="social-icon" href="#" target="_blank" rel="noopener nofollow" aria-label="Twitter">
			<svg><use href="<?php echo get_svg('twitter'); ?>"></use></svg>
		</a>

		<p class="copyright">
			&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.
			<a rel="noopener" target="_blank" href="https://creativeslice.com">Website Crafted by Creative Slice</a>
		</p>

	</div>

</footer>

</div><?php // Closes #container from header.php ?>

<?php wp_footer(); ?>

</body>
</html>
