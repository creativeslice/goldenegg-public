<span id="menuToggle">
	<span class="menuText">MENU</span>
	<svg class="open" title="menu"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#menu"></use></svg>
	<svg class="close"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/icons/icons.svg#close"></use></svg>
</span>

<nav class="menuFull">
<?php wp_nav_menu(array(
	'container' => false,
	'menu_class' => 'mainNav',
	'theme_location' => 'mainNav',
	'depth' => 2
)); ?>
</nav>