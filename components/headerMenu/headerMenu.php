<button id="searchToggle">
	<svg title="Search" class="open">
		<title>Show Search</title>
		<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#search"></use>
	</svg>
	<svg title="Close" class="close">
		<title>Close Search</title>
		<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#close"></use>
	</svg>
</button>

<button id="menuToggle">
	<span class="menuText">MENU</span>
	<svg title="Open Menu" class="open">
		<title>Open Menu</title>
		<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#menu"></use>
	</svg>
	<svg title="Close" class="close">
		<title>Close Menu</title>
		<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#close"></use>
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
