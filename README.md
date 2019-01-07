# Golden Egg WordPress Starter Theme

### Version 2.0.3

A responsive WordPress starter theme created by Creative Slice that uses Gulp to compile SCSS &amp; JS. This theme is component-based and organizes the SCSS, JS, &amp; PHP that define a component all in the same directory within the components directory.

More at: [https://creativeslice.com/goldenegg](https://creativeslice.com/goldenegg)

## Components

As of 2.0.3, there is some extra automation to components including a new wrapper function for including a component. SCSS files are auto discovered and compiled similar JavaScript files.

### Including a Component

```
egg_component( 'componentName', $settings );
```

1. `componentName` is the name used for directory and PHP filename (see Organization below). The component PHP file needs to match the directory name.
1. `$settings` is an array of settings that the component uses.

This wrapper function allows automation of optional variables that are available to all components, and if a change is needed that would be useful site-wide to all components, the wrapper function can be used. The wrapper is stored in: `includes/components.php`.

### Component Defaults

Default variables that are available to all components:

1. `$id`, provides a string with the `id=""` attribute. Empty unless specified in the `$settings` array. See examples.
1. `$class`, provides a string with the `class="componentName"` attribute. By default, uses the component's name. More classes can be added in the `$settings` array. See examples.
1. `$attr`, provides a string with all attributes specified including `class` and `id`. Any attribute can be added in the `$settings` array. See examples.

#### $id Examples

**Basic id**

```
$settings['id'] = 'unique-name';
```
*Output*: `id="unique-name"`

**Section id**

Can be used in a loop:
```
$count = 1;
foreach ( $content_blocks as $settings ) :

	$settings['build_count'] = $count;
	egg_component( $block, $settings );

	$count++;
endforeach;
```
*Output*: `id="section--1"`

**$class Examples**

```
$settings['class'] = [ 'slickslider', 'slickslider--sidebar' ];
```
*Output*: `class="componentName slickslider slickslider--sidebar"`

*$attr Examples*
```
$settings['attr'] = [
	'data-type' => 'gallery',
	'width'     => 128,
	'srcset'    => 'path/image-1920.jpg 1920w, path/image-1280.jpg 1280w',
];
```
Output: `id="unique-name" class="componentName slickslider slickslider--sidebar" data-type="gallery" width="128" srcset="path/image-1920.jpg 1920w, path/image-1280.jpg 1280w"`

## Organization

### /components

This directory holds the reusable components that make up the site. Components are meant to wholly contain the functionality for a piece of website functionality. A component can consist of any combination of or potentially multiple of each:

1. A PHP file, eg: `componentName.php`
1. A JavaScript file, eg: `componentName.js`
1. A CSS file, eg: `componentName.scss`

The example files above would be contained in: `/components/componentName/`.

### /components_OFF

In the repo, this is used to hold non-default components that can be used in your project. In the final project, this can be deleted to avoid confusion.

### /acf-json

Will hold JSON definitions of any ACF groups created. Allows them to be version controlled.

### /admin

Admin customizations such as TinyMCE updates.

### /assets

Global assets for the site. Can contain JS and SCSS that are used globally. Also contains theme images and icons.

### /includes

A PHP library of global functionality.


## Requirements

1. **Node** and its package manager **NPM** need to be installed on your computer
1. The [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/) plugin to add custom fields and use the page builder


## Install &amp; Set Up

1. Copy this directory into a WordPress site theme directory
1. Open Terminal or your CLI of choice
1. Navigate to the theme directory (eg: `cd ~/Sites/site_name/app/public/wp-content/themes/goldenegg/`)
1. Run `npm install` to install the necessary packages


## Creative Slice Specific Set Up

1. Change the theme name to follow this format: `[sitename]-[year]`, eg: `creativeslice-2018`
1. Update style.css with: "Site Name - 2018" (Use the current site and current year), the current site's URL, and a quick description, example below
1. Update screenshot.png with the comp or site logo
1. Update `assets/img/logo.png`


## Gulp to Process Scripts and Styles

Gulp can be used to create an SVG icon sprite, combine, update, and process SCSS and JavaScript. It will pull the JS from the components automatically but SCSS files need to be manually added in the `/assets/scss/style.scss` file.

**Gulp Commands**

1. `gulp styles` - Process `/assets/scss/` + `/components/*/*.scss` into `/assets/css/style.css`
1. `gulp scripts` - Process `/assets/js/` + `/components/*/*.js` into `/assets/js/scripts.js`
1. `gulp icons` - Process `/assets/icons/` into `/assets/icons/icons.svg`
1. `gulp watch` - Rebuilds the SCSS/JS when any file is updated within the SCSS/JS files: `/assets/js/src/`, `/assets/scss/src/`, `/components/*/`

## Changelog

**2.0.2 - 2018-09-07**

1. Added package.json
1. Updated README


