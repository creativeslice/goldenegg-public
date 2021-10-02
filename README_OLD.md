# Golden Egg WordPress Starter Theme

A responsive WordPress starter theme created by Creative Slice that uses Gulp to compile SCSS &amp; JS.

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


## Blocks

As of 3.0.0, there is some extra automation to blocks and partials so SCSS files are auto discovered and compiled similar to JavaScript files.


## Organization

### /blocks

This directory holds the reusable blocks that make up the site. Blocks are meant to wholly contain the functionality for a piece of website functionality. A block can consist of any combination of or potentially multiple of each:

1. A PHP file, eg: `block-name.php`
1. A JavaScript file, eg: `_block-name.js`
1. A CSS file, eg: `_block-name.scss`

The example files above would be contained in: `/blocks/block-name/`.

### /partials

This directory holds universal elements like menus and favicons. These are referenced in the same manner as /blocks.

### /acf-json

Will hold JSON definitions of any ACF groups created. Allows them to be version controlled.

### /assets

Global assets for the site. Can contain JS and SCSS that are used globally. Also contains theme images and icons.

### /includes

A PHP library of global functionality.

## Requirements

1. **Node** and its package manager **NPM** need to be installed on your computer


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

Gulp can be used to create an SVG icon sprite, combine, update, and process SCSS and JavaScript. It will pull the JS and SCSS from the blocks and partials directories automatically but SCSS modules need to be manually added in the `/assets/scss/style.scss` file.

**Gulp Commands**

1. `gulp` - Process `/assets/scss/` + `/components/*/*.scss` into `/assets/css/style.css` and Process `/assets/js/` + `/components/*/*.js` into `/assets/js/scripts.js`
1. `gulp icons` - Process `/assets/icons/` into `/assets/icons/icons.svg`
1. `gulp watch` - Rebuilds the SCSS/JS when any file is updated within the SCSS/JS files: `/assets/js/src/`, `/assets/scss/src/`, `/blocks/*/`, `/partials/*/`

