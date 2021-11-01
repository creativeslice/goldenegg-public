# Golden Egg WordPress Starter Theme
21/11/01 (SCD) contains changes from Sam 

A responsive WordPress starter theme created by Creative Slice that uses Gulp to compile SCSS &amp; JS.

Deploy from `develop`:
1. Pagely: [pagely.goldenegg.dev](https://goldenegg.dev)
1. WPEngine Staging: [goldeneggstag.wpengine.com](https://goldeneggstag.wpengine.com)

Deploy from `main` when a GitHub Release is made:
1. WPEngine: [goldenegg.dev](https://goldenegg.dev)


## Changelog
Updates are documented here: https://github.com/creativeslice/goldenegg/releases

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

