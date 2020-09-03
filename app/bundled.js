/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./app/assets/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./app/assets/main.js":
/*!****************************!*\
  !*** ./app/assets/main.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _styles_style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/style.scss */ \"./app/assets/styles/style.scss\");\n/* harmony import */ var _styles_style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_styles_style_scss__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _scripts_MobileMenu__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scripts/MobileMenu */ \"./app/assets/scripts/MobileMenu.js\");\n\r\n\r\n// import ExploreCourses from './scripts/ExploreCourses';\r\n\r\nif(false) {}\r\n\r\n\r\nlet mobileMenu = new _scripts_MobileMenu__WEBPACK_IMPORTED_MODULE_1__[\"default\"]();\r\n// let exploreCourses = new ExploreCourses();\r\n\r\n/*\r\nfunction openCity(evt, cityName) {\r\n    // Declare all variables\r\n    var i, tabcontent, tablinks;\r\n  \r\n    // Get all elements with class=\"tabcontent\" and hide them\r\n    tabcontent = document.getElementsByClassName(\"tabcontent\");\r\n    for (i = 0; i < tabcontent.length; i++) {\r\n      tabcontent[i].style.display = \"none\";\r\n    }\r\n  \r\n    // Get all elements with class=\"tablinks\" and remove the class \"active\"\r\n    tablinks = document.getElementsByClassName(\"tablinks\");\r\n    for (i = 0; i < tablinks.length; i++) {\r\n      tablinks[i].className = tablinks[i].className.replace(\" active\", \"\");\r\n    }\r\n  \r\n    // Show the current tab, and add an \"active\" class to the button that opened the tab\r\n    document.getElementById(cityName).style.display = \"block\";\r\n    evt.currentTarget.className += \" active\";\r\n  }\r\n\r\n  */\n\n//# sourceURL=webpack:///./app/assets/main.js?");

/***/ }),

/***/ "./app/assets/scripts/MobileMenu.js":
/*!******************************************!*\
  !*** ./app/assets/scripts/MobileMenu.js ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nclass MobileMenu {\r\n    constructor() {\r\n        this.MenuIcon = document.querySelector(\".site-header__menu-icon\");\r\n        this.MenuContent = document.querySelector(\".site-header__menu-content\");\r\n        this.events();\r\n    }\r\n\r\n    events() {\r\n        this.MenuIcon.addEventListener(\"click\", () => this.toggleTheMenu());\r\n    }\r\n\r\n    toggleTheMenu() {\r\n        this.MenuContent.classList.toggle(\"site-header__menu-content--is-visible\");\r\n        this.MenuIcon.classList.toggle(\"site-header__menu-icon--close-x\");\r\n    }\r\n}\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (MobileMenu);\n\n//# sourceURL=webpack:///./app/assets/scripts/MobileMenu.js?");

/***/ }),

/***/ "./app/assets/styles/style.scss":
/*!**************************************!*\
  !*** ./app/assets/styles/style.scss ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var api = __webpack_require__(/*! ../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ \"./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js\");\n            var content = __webpack_require__(/*! !../../../node_modules/css-loader/dist/cjs.js!../../../node_modules/sass-loader/dist/cjs.js!./style.scss */ \"./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./app/assets/styles/style.scss\");\n\n            content = content.__esModule ? content.default : content;\n\n            if (typeof content === 'string') {\n              content = [[module.i, content, '']];\n            }\n\nvar options = {};\n\noptions.insert = \"head\";\noptions.singleton = false;\n\nvar update = api(content, options);\n\n\n\nmodule.exports = content.locals || {};\n\n//# sourceURL=webpack:///./app/assets/styles/style.scss?");

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./app/assets/styles/style.scss":
/*!*******************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./app/assets/styles/style.scss ***!
  \*******************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ \"./node_modules/css-loader/dist/runtime/api.js\");\n/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);\n// Imports\n\nvar ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(false);\n// Module\n___CSS_LOADER_EXPORT___.push([module.i, \"/**\\r\\n * 1. Correct the line height in all browsers.\\r\\n * 2. Prevent adjustments of font size after orientation changes in iOS.\\r\\n */\\nhtml {\\n  line-height: 1.15;\\n  /* 1 */\\n  -webkit-text-size-adjust: 100%;\\n  /* 2 */ }\\n\\n/* Sections\\r\\n     ========================================================================== */\\n/**\\r\\n   * Remove the margin in all browsers.\\r\\n   */\\nbody {\\n  margin: 0; }\\n\\n/**\\r\\n   * Render the `main` element consistently in IE.\\r\\n   */\\nmain {\\n  display: block; }\\n\\n/**\\r\\n   * Correct the font size and margin on `h1` elements within `section` and\\r\\n   * `article` contexts in Chrome, Firefox, and Safari.\\r\\n   */\\nh1 {\\n  font-size: 2em;\\n  margin: 0.67em 0; }\\n\\n/* Grouping content\\r\\n     ========================================================================== */\\n/**\\r\\n   * 1. Add the correct box sizing in Firefox.\\r\\n   * 2. Show the overflow in Edge and IE.\\r\\n   */\\nhr {\\n  box-sizing: content-box;\\n  /* 1 */\\n  height: 0;\\n  /* 1 */\\n  overflow: visible;\\n  /* 2 */ }\\n\\n/**\\r\\n   * 1. Correct the inheritance and scaling of font size in all browsers.\\r\\n   * 2. Correct the odd `em` font sizing in all browsers.\\r\\n   */\\npre {\\n  font-family: monospace, monospace;\\n  /* 1 */\\n  font-size: 1em;\\n  /* 2 */ }\\n\\n/* Text-level semantics\\r\\n     ========================================================================== */\\n/**\\r\\n   * Remove the gray background on active links in IE 10.\\r\\n   */\\na {\\n  background-color: transparent; }\\n\\n/**\\r\\n   * 1. Remove the bottom border in Chrome 57-\\r\\n   * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.\\r\\n   */\\nabbr[title] {\\n  border-bottom: none;\\n  /* 1 */\\n  text-decoration: underline;\\n  /* 2 */\\n  text-decoration: underline dotted;\\n  /* 2 */ }\\n\\n/**\\r\\n   * Add the correct font weight in Chrome, Edge, and Safari.\\r\\n   */\\nb,\\nstrong {\\n  font-weight: bolder; }\\n\\n/**\\r\\n   * 1. Correct the inheritance and scaling of font size in all browsers.\\r\\n   * 2. Correct the odd `em` font sizing in all browsers.\\r\\n   */\\ncode,\\nkbd,\\nsamp {\\n  font-family: monospace, monospace;\\n  /* 1 */\\n  font-size: 1em;\\n  /* 2 */ }\\n\\n/**\\r\\n   * Add the correct font size in all browsers.\\r\\n   */\\nsmall {\\n  font-size: 80%; }\\n\\n/**\\r\\n   * Prevent `sub` and `sup` elements from affecting the line height in\\r\\n   * all browsers.\\r\\n   */\\nsub,\\nsup {\\n  font-size: 75%;\\n  line-height: 0;\\n  position: relative;\\n  vertical-align: baseline; }\\n\\nsub {\\n  bottom: -0.25em; }\\n\\nsup {\\n  top: -0.5em; }\\n\\n/* Embedded content\\r\\n     ========================================================================== */\\n/**\\r\\n   * Remove the border on images inside links in IE 10.\\r\\n   */\\nimg {\\n  border-style: none; }\\n\\n/* Forms\\r\\n     ========================================================================== */\\n/**\\r\\n   * 1. Change the font styles in all browsers.\\r\\n   * 2. Remove the margin in Firefox and Safari.\\r\\n   */\\nbutton,\\ninput,\\noptgroup,\\nselect,\\ntextarea {\\n  font-family: inherit;\\n  /* 1 */\\n  font-size: 100%;\\n  /* 1 */\\n  line-height: 1.15;\\n  /* 1 */\\n  margin: 0;\\n  /* 2 */ }\\n\\n/**\\r\\n   * Show the overflow in IE.\\r\\n   * 1. Show the overflow in Edge.\\r\\n   */\\nbutton,\\ninput {\\n  /* 1 */\\n  overflow: visible; }\\n\\n/**\\r\\n   * Remove the inheritance of text transform in Edge, Firefox, and IE.\\r\\n   * 1. Remove the inheritance of text transform in Firefox.\\r\\n   */\\nbutton,\\nselect {\\n  /* 1 */\\n  text-transform: none; }\\n\\n/**\\r\\n   * Correct the inability to style clickable types in iOS and Safari.\\r\\n   */\\nbutton,\\n[type=\\\"button\\\"],\\n[type=\\\"reset\\\"],\\n[type=\\\"submit\\\"] {\\n  -webkit-appearance: button; }\\n\\n/**\\r\\n   * Remove the inner border and padding in Firefox.\\r\\n   */\\nbutton::-moz-focus-inner,\\n[type=\\\"button\\\"]::-moz-focus-inner,\\n[type=\\\"reset\\\"]::-moz-focus-inner,\\n[type=\\\"submit\\\"]::-moz-focus-inner {\\n  border-style: none;\\n  padding: 0; }\\n\\n/**\\r\\n   * Restore the focus styles unset by the previous rule.\\r\\n   */\\nbutton:-moz-focusring,\\n[type=\\\"button\\\"]:-moz-focusring,\\n[type=\\\"reset\\\"]:-moz-focusring,\\n[type=\\\"submit\\\"]:-moz-focusring {\\n  outline: 1px dotted ButtonText; }\\n\\n/**\\r\\n   * Correct the padding in Firefox.\\r\\n   */\\nfieldset {\\n  padding: 0.35em 0.75em 0.625em; }\\n\\n/**\\r\\n   * 1. Correct the text wrapping in Edge and IE.\\r\\n   * 2. Correct the color inheritance from `fieldset` elements in IE.\\r\\n   * 3. Remove the padding so developers are not caught out when they zero out\\r\\n   *    `fieldset` elements in all browsers.\\r\\n   */\\nlegend {\\n  box-sizing: border-box;\\n  /* 1 */\\n  color: inherit;\\n  /* 2 */\\n  display: table;\\n  /* 1 */\\n  max-width: 100%;\\n  /* 1 */\\n  padding: 0;\\n  /* 3 */\\n  white-space: normal;\\n  /* 1 */ }\\n\\n/**\\r\\n   * Add the correct vertical alignment in Chrome, Firefox, and Opera.\\r\\n   */\\nprogress {\\n  vertical-align: baseline; }\\n\\n/**\\r\\n   * Remove the default vertical scrollbar in IE 10+.\\r\\n   */\\ntextarea {\\n  overflow: auto; }\\n\\n/**\\r\\n   * 1. Add the correct box sizing in IE 10.\\r\\n   * 2. Remove the padding in IE 10.\\r\\n   */\\n[type=\\\"checkbox\\\"],\\n[type=\\\"radio\\\"] {\\n  box-sizing: border-box;\\n  /* 1 */\\n  padding: 0;\\n  /* 2 */ }\\n\\n/**\\r\\n   * Correct the cursor style of increment and decrement buttons in Chrome.\\r\\n   */\\n[type=\\\"number\\\"]::-webkit-inner-spin-button,\\n[type=\\\"number\\\"]::-webkit-outer-spin-button {\\n  height: auto; }\\n\\n/**\\r\\n   * 1. Correct the odd appearance in Chrome and Safari.\\r\\n   * 2. Correct the outline style in Safari.\\r\\n   */\\n[type=\\\"search\\\"] {\\n  -webkit-appearance: textfield;\\n  /* 1 */\\n  outline-offset: -2px;\\n  /* 2 */ }\\n\\n/**\\r\\n   * Remove the inner padding in Chrome and Safari on macOS.\\r\\n   */\\n[type=\\\"search\\\"]::-webkit-search-decoration {\\n  -webkit-appearance: none; }\\n\\n/**\\r\\n   * 1. Correct the inability to style clickable types in iOS and Safari.\\r\\n   * 2. Change font properties to `inherit` in Safari.\\r\\n   */\\n::-webkit-file-upload-button {\\n  -webkit-appearance: button;\\n  /* 1 */\\n  font: inherit;\\n  /* 2 */ }\\n\\n/* Interactive\\r\\n     ========================================================================== */\\n/*\\r\\n   * Add the correct display in Edge, IE 10+, and Firefox.\\r\\n   */\\ndetails {\\n  display: block; }\\n\\n/*\\r\\n   * Add the correct display in all browsers.\\r\\n   */\\nsummary {\\n  display: list-item; }\\n\\n/* Misc\\r\\n     ========================================================================== */\\n/**\\r\\n   * Add the correct display in IE 10+.\\r\\n   */\\ntemplate {\\n  display: none; }\\n\\n/**\\r\\n   * Add the correct display in IE 10.\\r\\n   */\\n[hidden] {\\n  display: none; }\\n\\nbody {\\n  background-color: #eff1fe;\\n  font-family: Lato, sans-serif;\\n  color: #303030; }\\n\\n.arrow {\\n  border: solid black;\\n  border-width: 0 2px 2px 0;\\n  display: inline-block;\\n  padding: 3px; }\\n  .arrow--right {\\n    transform: rotate(-45deg); }\\n  .arrow--left {\\n    transform: rotate(135deg); }\\n  .arrow--up {\\n    transform: rotate(-135deg); }\\n  .arrow--down {\\n    transform: rotate(45deg); }\\n  .arrow--white {\\n    border-color: #fff; }\\n\\n.wrapper {\\n  padding: 0 12px;\\n  box-sizing: border-box;\\n  max-width: 1440px;\\n  margin: 0 auto; }\\n  @media (min-width: 1100px) {\\n    .wrapper {\\n      padding: 0 4rem; } }\\n\\n.site-header {\\n  background-color: #fff; }\\n  .site-header .wrapper {\\n    display: flex;\\n    height: 3.94rem;\\n    align-items: center;\\n    position: relative; }\\n    @media (min-width: 850px) {\\n      .site-header .wrapper {\\n        height: 6.125rem; } }\\n  .site-header__logo {\\n    width: 95px;\\n    margin-right: 1.375rem; }\\n    .site-header__logo img {\\n      width: 100%;\\n      display: inline-block; }\\n    @media (min-width: 850px) {\\n      .site-header__logo {\\n        width: 145px;\\n        margin-right: 1.8rem; } }\\n  .site-header__explore-btn {\\n    background-image: linear-gradient(89deg, #ff006e 0%, #ff4e9a 100%, #ffd85e 100%);\\n    display: inline-flex;\\n    border-radius: 5px;\\n    padding: 0 9px;\\n    height: 35px;\\n    justify-content: space-evenly;\\n    align-items: center;\\n    position: relative; }\\n    .site-header__explore-btn > a {\\n      text-decoration: none;\\n      font-size: .875rem;\\n      font-weight: 700;\\n      color: #fff;\\n      width: 50px;\\n      height: 16px;\\n      display: inline-block;\\n      overflow: hidden;\\n      margin-right: 14px;\\n      margin-top: -2px; }\\n      .site-header__explore-btn > a i {\\n        position: absolute;\\n        top: 12px;\\n        right: 10px; }\\n        @media (min-width: 850px) {\\n          .site-header__explore-btn > a i {\\n            top: 15px;\\n            right: 15px; } }\\n      @media (min-width: 850px) {\\n        .site-header__explore-btn > a {\\n          width: 132px;\\n          margin-right: 9px;\\n          font-size: 1rem;\\n          margin-top: -4px;\\n          letter-spacing: .3px;\\n          overflow: visible; } }\\n    @media (min-width: 850px) {\\n      .site-header__explore-btn {\\n        height: 40px;\\n        padding: 0 12px; } }\\n  .site-header__menu-icon {\\n    width: 26px;\\n    height: 19px;\\n    position: absolute;\\n    right: 20px;\\n    z-index: 100;\\n    cursor: pointer; }\\n    .site-header__menu-icon::before {\\n      content: \\\"\\\";\\n      position: absolute;\\n      top: 0;\\n      left: 0;\\n      width: 26px;\\n      height: 2px;\\n      background-color: rgba(0, 0, 0, 0.5);\\n      transform-origin: 0 0;\\n      transition: transform .3s ease-out; }\\n    .site-header__menu-icon__middle {\\n      position: absolute;\\n      top: 9px;\\n      left: 0;\\n      width: 26px;\\n      height: 2px;\\n      background-color: rgba(0, 0, 0, 0.5);\\n      transition: all .3s ease-out; }\\n    .site-header__menu-icon::after {\\n      content: \\\"\\\";\\n      position: absolute;\\n      top: 18px;\\n      left: 0;\\n      width: 26px;\\n      height: 2px;\\n      background-color: rgba(0, 0, 0, 0.5);\\n      transform-origin: 0 100%;\\n      transition: transform .3s ease-out; }\\n    .site-header__menu-icon--close-x::before {\\n      transform: rotate(45deg); }\\n    .site-header__menu-icon--close-x .site-header__menu-icon__middle {\\n      opacity: 0;\\n      transform: scaleX(0); }\\n    .site-header__menu-icon--close-x::after {\\n      transform: rotate(-45deg); }\\n    @media (min-width: 700px) {\\n      .site-header__menu-icon {\\n        display: none; } }\\n  .site-header__menu-content {\\n    opacity: 0;\\n    transform: scaleY(0.5);\\n    transform-origin: 0 0;\\n    transition: all .3s ease-out;\\n    position: relative;\\n    z-index: -10;\\n    position: absolute;\\n    top: 3.94rem;\\n    background-color: #fff;\\n    left: 0;\\n    width: 100%;\\n    box-shadow: 0 2px 13px 0 #8c8c8c; }\\n    .site-header__menu-content--is-visible {\\n      opacity: 1;\\n      z-index: 5;\\n      transform: scaleY(1); }\\n    @media (min-width: 700px) {\\n      .site-header__menu-content {\\n        opacity: 1;\\n        z-index: 5;\\n        transform: scale(1);\\n        position: static;\\n        box-shadow: none;\\n        height: 100%; } }\\n\\n.primary-nav ul {\\n  list-style: none;\\n  padding: 0;\\n  display: flex;\\n  flex-direction: column;\\n  text-align: center;\\n  margin: 0; }\\n  .primary-nav ul li {\\n    border-bottom: .5px solid #ddd; }\\n    .primary-nav ul li:nth-last-child(1) {\\n      border-bottom: none; }\\n    @media (min-width: 700px) {\\n      .primary-nav ul li {\\n        border-bottom: none; }\\n        .primary-nav ul li:nth-last-child(1) {\\n          position: relative; } }\\n  @media (min-width: 700px) {\\n    .primary-nav ul {\\n      flex-direction: row;\\n      justify-content: space-between;\\n      margin: 0;\\n      height: 100%; } }\\n\\n.primary-nav a {\\n  text-decoration: none;\\n  color: #3c3c3c;\\n  font-size: .875rem;\\n  display: block;\\n  padding: 1.2rem 0;\\n  transition: background-color .3s ease-out; }\\n  .primary-nav a:hover {\\n    background-color: #eff1fe; }\\n  @media (min-width: 700px) {\\n    .primary-nav a {\\n      padding: 1rem 1rem;\\n      display: inline-flex;\\n      height: 100%;\\n      box-sizing: border-box;\\n      align-items: center; } }\\n  @media (min-width: 850px) {\\n    .primary-nav a {\\n      font-size: 1rem; } }\\n\\n@media (min-width: 700px) {\\n  .primary-nav {\\n    margin-left: 3rem;\\n    height: 100%; } }\\n\\n@media (min-width: 1100px) {\\n  .primary-nav {\\n    margin-left: 11rem; } }\\n\\n.top-search-section {\\n  position: relative; }\\n  .top-search-section__title {\\n    font-family: 'Opens Sans', sans-serif;\\n    font-size: 2.19rem;\\n    font-weight: bold;\\n    color: #303030;\\n    width: 17.75rem;\\n    line-height: 1.3;\\n    margin: 0;\\n    padding-top: 4rem; }\\n    @media (min-width: 700px) {\\n      .top-search-section__title {\\n        font-size: 4rem;\\n        width: 33rem; } }\\n    .top-search-section__title > span {\\n      color: #ff026f; }\\n  .top-search-section__text {\\n    font-size: .875rem;\\n    line-height: 1.75;\\n    margin: 10px 0 20px 3px;\\n    width: 18.125rem; }\\n    @media (min-width: 700px) {\\n      .top-search-section__text {\\n        font-size: 1rem;\\n        width: 22.5rem; } }\\n  .top-search-section__search {\\n    position: relative;\\n    max-width: 571px;\\n    margin-bottom: 2.875rem; }\\n    .top-search-section__search-input {\\n      border: none;\\n      display: block;\\n      width: 100%;\\n      height: 50px;\\n      padding: 15px;\\n      padding-top: 13px;\\n      box-sizing: border-box;\\n      border-radius: 26.5px;\\n      box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.11), 0 0 4px 0 rgba(0, 0, 0, 0.14); }\\n      .top-search-section__search-input:focus {\\n        outline: none; }\\n      .top-search-section__search-input::placeholder {\\n        font-size: .75rem;\\n        opacity: .6;\\n        letter-spacing: .2px; }\\n    .top-search-section__search-btn {\\n      position: absolute;\\n      top: 0;\\n      right: 0;\\n      width: 112px;\\n      color: #303030;\\n      font-weight: 700;\\n      font-size: .875rem;\\n      height: 42px;\\n      margin: 4px 5px;\\n      padding-right: 45px;\\n      border: none;\\n      border-radius: 21px;\\n      background-image: linear-gradient(89deg, #ffc300 0%, #ffac00 100%, #ffd85e 100%); }\\n    .top-search-section__search .search-icon {\\n      width: 30px;\\n      height: 30px;\\n      display: inline-flex;\\n      position: absolute;\\n      top: 9px;\\n      right: 11px;\\n      border-radius: 50%;\\n      background-color: #fff; }\\n      .top-search-section__search .search-icon img {\\n        width: 80%;\\n        margin: auto; }\\n    @media (min-width: 700px) {\\n      .top-search-section__search {\\n        margin-bottom: 4.5rem; } }\\n    @media (min-width: 850px) {\\n      .top-search-section__search {\\n        margin-bottom: 10rem; } }\\n    @media (min-width: 1100px) {\\n      .top-search-section__search {\\n        margin-bottom: 15.87rem; } }\\n  .top-search-section__background-image {\\n    position: absolute;\\n    top: -20px;\\n    left: 0;\\n    z-index: -1;\\n    display: none; }\\n    .top-search-section__background-image img {\\n      width: 65%; }\\n    @media (min-width: 850px) {\\n      .top-search-section__background-image {\\n        display: flex;\\n        justify-content: flex-end; } }\\n  @media (min-width: 700px) {\\n    .top-search-section {\\n      z-index: 15; } }\\n\\n/*\\r\\n@import \\\"modules/_large-hero\\\";\\r\\n@import \\\"modules/_btn\\\";\\r\\n@import \\\"modules/_wrapper\\\";\\r\\n@import \\\"modules/_page-section\\\";\\r\\n@import \\\"modules/_headline\\\";\\r\\n@import \\\"modules/_row\\\";\\r\\n@import \\\"modules/_generic-content-container\\\";\\r\\n@import \\\"modules/_section-title\\\";\\r\\n@import \\\"modules/_feature-item\\\";\\r\\n@import \\\"modules/_testimonial\\\";\\r\\n@import \\\"modules/_site-footer\\\";\\r\\n@import \\\"modules/_site-header\\\";\\r\\n@import \\\"modules/_primary-nav\\\";\\r\\n*/\\n\", \"\"]);\n// Exports\n/* harmony default export */ __webpack_exports__[\"default\"] = (___CSS_LOADER_EXPORT___);\n\n\n//# sourceURL=webpack:///./app/assets/styles/style.scss?./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js");

/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n/*\n  MIT License http://www.opensource.org/licenses/mit-license.php\n  Author Tobias Koppers @sokra\n*/\n// css base code, injected by the css-loader\n// eslint-disable-next-line func-names\nmodule.exports = function (useSourceMap) {\n  var list = []; // return the list of modules as css string\n\n  list.toString = function toString() {\n    return this.map(function (item) {\n      var content = cssWithMappingToString(item, useSourceMap);\n\n      if (item[2]) {\n        return \"@media \".concat(item[2], \" {\").concat(content, \"}\");\n      }\n\n      return content;\n    }).join('');\n  }; // import a list of modules into the list\n  // eslint-disable-next-line func-names\n\n\n  list.i = function (modules, mediaQuery, dedupe) {\n    if (typeof modules === 'string') {\n      // eslint-disable-next-line no-param-reassign\n      modules = [[null, modules, '']];\n    }\n\n    var alreadyImportedModules = {};\n\n    if (dedupe) {\n      for (var i = 0; i < this.length; i++) {\n        // eslint-disable-next-line prefer-destructuring\n        var id = this[i][0];\n\n        if (id != null) {\n          alreadyImportedModules[id] = true;\n        }\n      }\n    }\n\n    for (var _i = 0; _i < modules.length; _i++) {\n      var item = [].concat(modules[_i]);\n\n      if (dedupe && alreadyImportedModules[item[0]]) {\n        // eslint-disable-next-line no-continue\n        continue;\n      }\n\n      if (mediaQuery) {\n        if (!item[2]) {\n          item[2] = mediaQuery;\n        } else {\n          item[2] = \"\".concat(mediaQuery, \" and \").concat(item[2]);\n        }\n      }\n\n      list.push(item);\n    }\n  };\n\n  return list;\n};\n\nfunction cssWithMappingToString(item, useSourceMap) {\n  var content = item[1] || ''; // eslint-disable-next-line prefer-destructuring\n\n  var cssMapping = item[3];\n\n  if (!cssMapping) {\n    return content;\n  }\n\n  if (useSourceMap && typeof btoa === 'function') {\n    var sourceMapping = toComment(cssMapping);\n    var sourceURLs = cssMapping.sources.map(function (source) {\n      return \"/*# sourceURL=\".concat(cssMapping.sourceRoot || '').concat(source, \" */\");\n    });\n    return [content].concat(sourceURLs).concat([sourceMapping]).join('\\n');\n  }\n\n  return [content].join('\\n');\n} // Adapted from convert-source-map (MIT)\n\n\nfunction toComment(sourceMap) {\n  // eslint-disable-next-line no-undef\n  var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));\n  var data = \"sourceMappingURL=data:application/json;charset=utf-8;base64,\".concat(base64);\n  return \"/*# \".concat(data, \" */\");\n}\n\n//# sourceURL=webpack:///./node_modules/css-loader/dist/runtime/api.js?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nvar isOldIE = function isOldIE() {\n  var memo;\n  return function memorize() {\n    if (typeof memo === 'undefined') {\n      // Test for IE <= 9 as proposed by Browserhacks\n      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805\n      // Tests for existence of standard globals is to allow style-loader\n      // to operate correctly into non-standard environments\n      // @see https://github.com/webpack-contrib/style-loader/issues/177\n      memo = Boolean(window && document && document.all && !window.atob);\n    }\n\n    return memo;\n  };\n}();\n\nvar getTarget = function getTarget() {\n  var memo = {};\n  return function memorize(target) {\n    if (typeof memo[target] === 'undefined') {\n      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself\n\n      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {\n        try {\n          // This will throw an exception if access to iframe is blocked\n          // due to cross-origin restrictions\n          styleTarget = styleTarget.contentDocument.head;\n        } catch (e) {\n          // istanbul ignore next\n          styleTarget = null;\n        }\n      }\n\n      memo[target] = styleTarget;\n    }\n\n    return memo[target];\n  };\n}();\n\nvar stylesInDom = [];\n\nfunction getIndexByIdentifier(identifier) {\n  var result = -1;\n\n  for (var i = 0; i < stylesInDom.length; i++) {\n    if (stylesInDom[i].identifier === identifier) {\n      result = i;\n      break;\n    }\n  }\n\n  return result;\n}\n\nfunction modulesToDom(list, options) {\n  var idCountMap = {};\n  var identifiers = [];\n\n  for (var i = 0; i < list.length; i++) {\n    var item = list[i];\n    var id = options.base ? item[0] + options.base : item[0];\n    var count = idCountMap[id] || 0;\n    var identifier = \"\".concat(id, \" \").concat(count);\n    idCountMap[id] = count + 1;\n    var index = getIndexByIdentifier(identifier);\n    var obj = {\n      css: item[1],\n      media: item[2],\n      sourceMap: item[3]\n    };\n\n    if (index !== -1) {\n      stylesInDom[index].references++;\n      stylesInDom[index].updater(obj);\n    } else {\n      stylesInDom.push({\n        identifier: identifier,\n        updater: addStyle(obj, options),\n        references: 1\n      });\n    }\n\n    identifiers.push(identifier);\n  }\n\n  return identifiers;\n}\n\nfunction insertStyleElement(options) {\n  var style = document.createElement('style');\n  var attributes = options.attributes || {};\n\n  if (typeof attributes.nonce === 'undefined') {\n    var nonce =  true ? __webpack_require__.nc : undefined;\n\n    if (nonce) {\n      attributes.nonce = nonce;\n    }\n  }\n\n  Object.keys(attributes).forEach(function (key) {\n    style.setAttribute(key, attributes[key]);\n  });\n\n  if (typeof options.insert === 'function') {\n    options.insert(style);\n  } else {\n    var target = getTarget(options.insert || 'head');\n\n    if (!target) {\n      throw new Error(\"Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.\");\n    }\n\n    target.appendChild(style);\n  }\n\n  return style;\n}\n\nfunction removeStyleElement(style) {\n  // istanbul ignore if\n  if (style.parentNode === null) {\n    return false;\n  }\n\n  style.parentNode.removeChild(style);\n}\n/* istanbul ignore next  */\n\n\nvar replaceText = function replaceText() {\n  var textStore = [];\n  return function replace(index, replacement) {\n    textStore[index] = replacement;\n    return textStore.filter(Boolean).join('\\n');\n  };\n}();\n\nfunction applyToSingletonTag(style, index, remove, obj) {\n  var css = remove ? '' : obj.media ? \"@media \".concat(obj.media, \" {\").concat(obj.css, \"}\") : obj.css; // For old IE\n\n  /* istanbul ignore if  */\n\n  if (style.styleSheet) {\n    style.styleSheet.cssText = replaceText(index, css);\n  } else {\n    var cssNode = document.createTextNode(css);\n    var childNodes = style.childNodes;\n\n    if (childNodes[index]) {\n      style.removeChild(childNodes[index]);\n    }\n\n    if (childNodes.length) {\n      style.insertBefore(cssNode, childNodes[index]);\n    } else {\n      style.appendChild(cssNode);\n    }\n  }\n}\n\nfunction applyToTag(style, options, obj) {\n  var css = obj.css;\n  var media = obj.media;\n  var sourceMap = obj.sourceMap;\n\n  if (media) {\n    style.setAttribute('media', media);\n  } else {\n    style.removeAttribute('media');\n  }\n\n  if (sourceMap && btoa) {\n    css += \"\\n/*# sourceMappingURL=data:application/json;base64,\".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), \" */\");\n  } // For old IE\n\n  /* istanbul ignore if  */\n\n\n  if (style.styleSheet) {\n    style.styleSheet.cssText = css;\n  } else {\n    while (style.firstChild) {\n      style.removeChild(style.firstChild);\n    }\n\n    style.appendChild(document.createTextNode(css));\n  }\n}\n\nvar singleton = null;\nvar singletonCounter = 0;\n\nfunction addStyle(obj, options) {\n  var style;\n  var update;\n  var remove;\n\n  if (options.singleton) {\n    var styleIndex = singletonCounter++;\n    style = singleton || (singleton = insertStyleElement(options));\n    update = applyToSingletonTag.bind(null, style, styleIndex, false);\n    remove = applyToSingletonTag.bind(null, style, styleIndex, true);\n  } else {\n    style = insertStyleElement(options);\n    update = applyToTag.bind(null, style, options);\n\n    remove = function remove() {\n      removeStyleElement(style);\n    };\n  }\n\n  update(obj);\n  return function updateStyle(newObj) {\n    if (newObj) {\n      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {\n        return;\n      }\n\n      update(obj = newObj);\n    } else {\n      remove();\n    }\n  };\n}\n\nmodule.exports = function (list, options) {\n  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>\n  // tags it will allow on a page\n\n  if (!options.singleton && typeof options.singleton !== 'boolean') {\n    options.singleton = isOldIE();\n  }\n\n  list = list || [];\n  var lastIdentifiers = modulesToDom(list, options);\n  return function update(newList) {\n    newList = newList || [];\n\n    if (Object.prototype.toString.call(newList) !== '[object Array]') {\n      return;\n    }\n\n    for (var i = 0; i < lastIdentifiers.length; i++) {\n      var identifier = lastIdentifiers[i];\n      var index = getIndexByIdentifier(identifier);\n      stylesInDom[index].references--;\n    }\n\n    var newLastIdentifiers = modulesToDom(newList, options);\n\n    for (var _i = 0; _i < lastIdentifiers.length; _i++) {\n      var _identifier = lastIdentifiers[_i];\n\n      var _index = getIndexByIdentifier(_identifier);\n\n      if (stylesInDom[_index].references === 0) {\n        stylesInDom[_index].updater();\n\n        stylesInDom.splice(_index, 1);\n      }\n    }\n\n    lastIdentifiers = newLastIdentifiers;\n  };\n};\n\n//# sourceURL=webpack:///./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js?");

/***/ })

/******/ });