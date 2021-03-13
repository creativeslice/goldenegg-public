/**
 * Import all front-end JS scripts.
 * 
 * Compiles to assets/js/scripts.js
 */

 /* eslint-disable no-unused-vars */

 // Import ES6 modules (recommended)
 // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/import

 //  import '../libs/**/*.js'; Need to import individually 
 //  import "../../blocks/**/*.js";
 //  import "../../components/**/*.js";

import './global.js';

// Components
import "../../components/headerMenu/headerMenu.js";
import "../../components/searchForm/searchForm.js";

// Blocks
import "../../blocks/expandingText/expandingText.js";