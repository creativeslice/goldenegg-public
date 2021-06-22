# Golden Egg WordPress Starter Theme

A responsive WordPress starter theme created by Creative Slice that uses Gulp to compile SCSS &amp; JS. This theme is block-based and organizes the the SCSS, JS, &amp; PHP that define a block all in the same directory within the blocks directory.

More at: [https://goldenegg.dev](https://goldenegg.dev)

## Changelog

**3.0.0 - 2021-06-21**
1. Converted to Gutenberg!

**2.1.0 - 2021-01-23**

1. Separated out blocks from components
1. Updating lazysizes to v5.3.0
1. Time stamp SVG icons


**2.0.12 - 2020-04-29**

1. Dashboard widget framework for Care Plan links

**2.0.11 - 2020-04-06**

1. Dashboard cleanup for WordPress 5.4
1. Updating lazysizes to v5.2.0
1. Accessible expanding text trigger

**2.0.10 - 2019-11-24**

1. Update to Gulp 4
1. Simpler css reset to replace sanitize
1. Search form styling
1. Accessible color refinements

**2.0.9 - 2019-11-18**

1. Add Cards content block
1. Update package file for Gulp. Thanks Jake!

**2.0.8 - 2019-11-17**

1. Refined Content Blocks: Text Block, Expanding Text (with FAQ schema)
1. Updating lazysizes to v5.2.0-beta1
1. Simplify favicon output
1. Adding ACF notices component
1. Adding functions to cleanup Tribe Calendar output

**2.0.7 - 2019-09-08**

1. Adding title tag support
1. Updating lazysizes to 5.1.1

**2.0.6 - 2019-07-05**

1. Moving contentBlocks.php core file to includes
1. Minor tweaks and updating lazysizes to 5.1.0
1. Removed inactive components

**2.0.5 - 2019-05-15**

1. Basic GF form styles
1. page template detects if the_content exists
1. Updated images scss to media and added videoContainer styles
1. Updated lazysizes script to 5.0.0

**2.0.4 - 2019-02-22**

1. Move searchToggle to search component
1. Updated lazysizes script

**2.0.2 - 2018-09-07**

1. Added package.json
1. Updated README


## Components

As of 2.0.3, there is some extra automation to components including a new wrapper function for including a component. SCSS files are auto discovered and compiled similar to JavaScript files.

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
1. Navigate to the site directory (eg: `cd ~/Sites/site_name/app/public/wp-content/`)
1. Run `npm install` to install the necessary packages


## New Theme Set Up

1. Change the theme name to follow this format: `[sitename]-[year]`, eg: `creativeslice-2019`
1. Update style.css with: "Site Name - 2019" (Use the current site and current year), the current site's URL, and a quick description, example below
1. Update screenshot.png with the comp or site logo
1. Update `assets/img/logo.png`


## Gulp to Process Scripts and Styles

Gulp can be used to create an SVG icon sprite, combine, update, and process SCSS and JavaScript. It will pull the JS from the components automatically but SCSS files need to be manually added in the `/assets/scss/style.scss` file.

To use Gulp v3 (instead of the default Gulp 4) rename the `gulpfile_v3.js` file to `gulpfile.js`.

**Gulp Commands**

1. `gulp styles` - Process `/assets/scss/` + `/components/*/*.scss` into `/assets/css/style.css`
1. `gulp scripts` - Process `/assets/js/` + `/components/*/*.js` into `/assets/js/scripts.js`
1. `gulp icons` - Process `/assets/icons/` into `/assets/icons/icons.svg`
1. `gulp watch` - Rebuilds the SCSS/JS when any file is updated within the SCSS/JS files: `/assets/js/src/`, `/assets/scss/src/`, `/components/*/`

