<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title><?php wp_title( '/' ); ?></title>
    
    <?php wp_head(); ?>
    
    <?php //get_template_part( 'components/favicons/favicons' ); ?>

</head>

<body <?php body_class(); ?>>

<div id="container">
	
	<a class="screen-reader-text" href="#content">Skip to Content</a>
	
	<?php get_search_form(); // hidden by default ?>
	
	<?php egg_component( 'pageHeader' ); ?>
