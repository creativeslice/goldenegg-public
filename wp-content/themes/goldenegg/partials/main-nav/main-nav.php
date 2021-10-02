<button id="menu-toggle">
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

<nav class="menu-full">
	<?php wp_nav_menu(array(
		'container' => false,
		'menu_class' => 'main-nav',
		'theme_location' => 'main-nav',
		'depth' => 2
	)); ?>
</nav>
