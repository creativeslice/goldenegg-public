# Golden Egg WordPress Starter Theme

A responsive WordPress starter theme created by Creative Slice that uses Gulp to compile SCSS &amp; JS. This theme is component-based and organizes the SCSS, JS, &amp; PHP that define a component all in the same directory within the components directory.

More at: [https://goldenegg.dev](https://goldenegg.dev)

## Components

Site wide elements like the menu 


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

1. Requires [Node.js](https://nodejs.org) v10.16.x or newer.
1. The [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/) plugin to add custom fields and use the page builder


## Install &amp; Set Up

1. Copy this directory into a WordPress site theme directory
1. Open Terminal or your CLI of choice
1. Navigate to the theme directory (eg: `cd ~/Sites/site_name/app/public/wp-content/creativeslice-2021`)
1. Run `npm install` to install theme dependencies.
1. Be sure to update the `build/project.config.js` file with your local URL.


## New Theme Set Up

1. Change the theme name to follow this format: `[sitename]-[year]`, eg: `creativeslice-2021`
1. Update style.css with: "Site Name - 2019" (Use the current site and current year), the current site's URL, and a quick description, example below
1. Update screenshot.png with the comp or site logo
1. Update `assets/img/logo.png`


## Webpack to Process Scripts and Styles

## Commands
`npm run watch` - watches all JS, SCSS and image source files for changes. This runs in dev mode.

`npm run build-dev` - compiles all JS, CSS and image source files.

`npm run build-prod` - compiles and minifies all JS, CSS and image source files. 

`npm run test-a11y` - runs accessibility checks on URLs listed in `build/project.config.js`

## Scripts
This theme is setup to use Sass. There are three style entry points (styles, editor, login), each that generates its own CSS file. Styles are processed through Autoprefixer.

Note: The `postcss.config.js` file needs to stay in place for Autoprefixer to work. You can adjust supported browsers in the `package.json` file.

## Scripts
Babel is used to convert ES6 into code that will work in older browsers. Browser support can be adjusted in the `package.json` file.

## SVGs
All SVGs in the `src/icons` directory will be merged into a single SVG sprite and saved to `assets/icons/icons.svg`. This needs to be manually run by running `npm run build-dev` or `npm run build-prod`.

## Image Optimzation
Any image added to `src/img` will be optimized and moved to `assets/img`. 

## Accessibility Testing
Accessibility testing is done with [Pa11y](https://www.npmjs.com/package/pa11y) by running the `npm run test-a11y` command. You can adjust which URLs are tested in the `build/project.config.js` file - look for the `a11yTestConfig` array. 

Compliance levels can also be changed through the `standard` setting in the `build/project/config.js` file. The default is WCAG Level AA, but can be changed to anything listed in the [pa11y documentation](https://github.com/pa11y/pa11y#standard-string).






## Changelog

**2.2.0 - 2021-03-05**

1. Use webpack in place of gulp


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

