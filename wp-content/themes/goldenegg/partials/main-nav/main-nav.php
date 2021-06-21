<button id="menuToggle">
	<span class="label">MENU</span>
	<svg class="open">
		<title>Open Menu</title>
		<use xlink:href="<?php echo get_svg('menu'); ?>"></use>
	</svg>
	<svg class="close">
		<title>Close Menu</title>
		<use xlink:href="<?php echo get_svg('close'); ?>"></use>
	</svg>
</button>

<nav class="menuFull">
	<?php wp_nav_menu(array(
		'container' => false,
		'menu_class' => 'mainNav',
		'theme_location' => 'mainNav',
		'depth' => 2
	)); ?>
</nav>