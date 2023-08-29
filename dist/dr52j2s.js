/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/dashboard/routing.js":
/*!**********************************!*\
  !*** ./src/dashboard/routing.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   setPageContent: () => (/* binding */ setPageContent)\n/* harmony export */ });\nconst menuBtns = document.querySelectorAll(\".menu-btn\");\r\nconst homePage = document.getElementById(\"home\");\r\nconst profilePage = document.getElementById(\"change-user-info\");\r\n\r\n// Menubar animations\r\nconst menuToggle = document.querySelector(\"#menu-toggle\");\r\nconst menu = document.querySelector(\".left-bar\");\r\nconst pages = document.querySelectorAll(\".page-content\");\r\nconst loaders = document.querySelectorAll(\".loader\");\r\n\r\nconst menuState = {\r\n  value: localStorage.getItem(\"menuState\"),\r\n};\r\n\r\nif (menuState.value === \"active\") {\r\n  activateMenu();\r\n} else if (menuState.value === \"hidden\") {\r\n  deactivateMenu();\r\n}\r\n\r\nmenuToggle.addEventListener(\"change\", () => {\r\n  if (menuToggle.checked) {\r\n    deactivateMenu();\r\n  } else {\r\n    activateMenu();\r\n  }\r\n});\r\n\r\ntry {\r\n  var productPage = document.getElementById(\"manage-products\");\r\n  var createProduct = document.getElementById(\"add-product\");\r\n  var userPage = document.getElementById(\"manage-users\");\r\n} catch (e) {\r\n  // Do nothing\r\n}\r\n\r\nlet sections = [homePage, profilePage];\r\n\r\n// Push userPage and productPage to sections array if they exist\r\nif (userPage) {\r\n  sections.push(userPage);\r\n}\r\nif (productPage) {\r\n  sections.push(productPage);\r\n}\r\nif (createProduct) {\r\n  sections.push(createProduct);\r\n}\r\n\r\n// Get the hash value from the URL\r\nlet hash = window.location.hash;\r\n\r\n// Remove the '#' symbol from the hash\r\nhash = hash.substring(1);\r\n\r\nfunction activateMenu() {\r\n  menuToggle.checked = false;\r\n  menuState.value = \"active\";\r\n  menu.classList.remove(\"hidden-menu\");\r\n  menu.classList.add(\"active-menu\");\r\n  pages.forEach((page) => {\r\n    page.classList.add(\"wide-page\");\r\n    page.classList.remove(\"narrow-page\");\r\n  });\r\n  loaders.forEach((loader) => {\r\n    loader.style.paddingLeft = \"325px\";\r\n  });\r\n  localStorage.setItem(\"menuState\", \"active\");\r\n}\r\n\r\nfunction deactivateMenu() {\r\n  menuToggle.checked = true;\r\n  menuState.value = \"hidden\";\r\n  menu.classList.remove(\"active-menu\");\r\n  menu.classList.add(\"hidden-menu\");\r\n  pages.forEach((page) => {\r\n    page.classList.remove(\"wide-page\");\r\n    page.classList.add(\"narrow-page\");\r\n  });\r\n  loaders.forEach((loader) => {\r\n    loader.style.paddingLeft = \"0\";\r\n  });\r\n  localStorage.setItem(\"menuState\", \"hidden\");\r\n}\r\n\r\nfunction setPageContent(type, page) {\r\n  // Scroll to top of the page\r\n  $(\"html, body\").animate(\r\n    {\r\n      scrollTop: 0,\r\n    },\r\n    \"slow\"\r\n  );\r\n\r\n  if (page !== homePage) {\r\n    window.location.hash = page.dataset.url;\r\n  } else {\r\n    window.location.hash = \"\";\r\n  }\r\n\r\n  document.title = `${page.dataset.title} - Bizim Shop Panel`;\r\n\r\n  page.style.display = \"flex\";\r\n  sections.forEach((section) => {\r\n    if (section !== page) {\r\n      section.style.display = \"none\";\r\n    }\r\n  });\r\n\r\n  if (type == \"hash\") {\r\n    menuBtns.forEach((btn) => {\r\n      if (btn.dataset.name === hash) {\r\n        btn.classList.add(\"active\");\r\n      } else {\r\n        btn.classList.remove(\"active\");\r\n      }\r\n    });\r\n  }\r\n}\r\n\r\nswitch (hash) {\r\n  case \"home\":\r\n    setPageContent(\"hash\", homePage);\r\n    break;\r\n  case \"profile\":\r\n    setPageContent(\"hash\", profilePage);\r\n    break;\r\n  case \"products\":\r\n    setPageContent(\"hash\", productPage);\r\n    break;\r\n  case \"users\":\r\n    setPageContent(\"hash\", userPage);\r\n    break;\r\n  case \"add-product\":\r\n    setPageContent(\"hash\", createProduct);\r\n    break;\r\n}\r\n\r\nmenuBtns.forEach((btn) => {\r\n  btn.addEventListener(\"click\", (e) => {\r\n    e.preventDefault();\r\n    switch (btn.dataset.name) {\r\n      case \"home\":\r\n        setPageContent(\"btn\", homePage);\r\n        break;\r\n      case \"profile\":\r\n        setPageContent(\"btn\", profilePage);\r\n        break;\r\n      case \"store\":\r\n        setPageContent(\"btn\", storePage);\r\n        break;\r\n      case \"products\":\r\n        setPageContent(\"btn\", productPage);\r\n        break;\r\n      case \"users\":\r\n        setPageContent(\"btn\", userPage);\r\n        break;\r\n      case \"add-product\":\r\n        setPageContent(\"btn\", createProduct);\r\n        break;\r\n    }\r\n\r\n    // Remove active class from all menu-btns\r\n    menuBtns.forEach((btn) => {\r\n      btn.classList.remove(\"active\");\r\n    });\r\n    // Add active class to clicked menu-btn\r\n    btn.classList.add(\"active\");\r\n  });\r\n});\r\n\n\n//# sourceURL=webpack://htdocs/./src/dashboard/routing.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/dashboard/routing.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;