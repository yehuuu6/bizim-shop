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

/***/ "./src/auth/auth.js":
/*!**************************!*\
  !*** ./src/auth/auth.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _classes_AuthorizationClass_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./classes/AuthorizationClass.js */ \"./src/auth/classes/AuthorizationClass.js\");\n\r\n\r\nconst loader = document.querySelector(\".loader\");\r\n\r\nconst LoginPage = new _classes_AuthorizationClass_js__WEBPACK_IMPORTED_MODULE_0__.AuthorizationClass(\r\n  document.querySelector(\"#login-form\"),\r\n  document.querySelector(\"#login-form .logger\"),\r\n  loader,\r\n  \"/api/authorization/login.php\",\r\n  \"/\" // return url and default go back time\r\n);\r\nconst RegisterPage = new _classes_AuthorizationClass_js__WEBPACK_IMPORTED_MODULE_0__.AuthorizationClass(\r\n  document.querySelector(\"#register-form\"),\r\n  document.querySelector(\"#register-form .logger\"),\r\n  loader,\r\n  \"/api/authorization/register.php\",\r\n  \"./verify\"\r\n);\r\nconst forgotPasswordLogger = document.querySelector(\r\n  \"#forgot-password-form .logger\"\r\n);\r\nconst ForgotPasswordPage = new _classes_AuthorizationClass_js__WEBPACK_IMPORTED_MODULE_0__.SpecialAuthorizationClass(\r\n  document.querySelector(\"#forgot-password-form\"),\r\n  forgotPasswordLogger,\r\n  loader,\r\n  \"/api/authorization/forgot-password.php\",\r\n  \"./login\",\r\n  6000,\r\n  forgotPasswordLogger ? forgotPasswordLogger.innerHTML : null\r\n);\r\nconst ResetPasswordPage = new _classes_AuthorizationClass_js__WEBPACK_IMPORTED_MODULE_0__.AuthorizationClass(\r\n  document.querySelector(\"#reset-form\"),\r\n  document.querySelector(\"#reset-form .logger\"),\r\n  loader,\r\n  \"/api/authorization/reset-password.php\",\r\n  \"./login\",\r\n  6000\r\n);\r\n\r\nconst verifyLogger = document.querySelector(\"#verify-account-form .logger\");\r\nconst VerifyAccountPage = new _classes_AuthorizationClass_js__WEBPACK_IMPORTED_MODULE_0__.SpecialAuthorizationClass(\r\n  document.querySelector(\"#verify-account-form\"),\r\n  verifyLogger,\r\n  loader,\r\n  \"/api/authorization/resend-verify.php\",\r\n  \"#\",\r\n  3000,\r\n  verifyLogger ? verifyLogger.innerHTML : null\r\n);\r\n\r\n$(document).ready(function () {\r\n  $(document).on(\"submit\", \"#login-form\", function (e) {\r\n    e.preventDefault();\r\n    LoginPage.sendApiRequest();\r\n  });\r\n\r\n  $(document).on(\"submit\", \"#register-form\", function (e) {\r\n    e.preventDefault();\r\n    RegisterPage.sendApiRequest();\r\n  });\r\n\r\n  $(document).on(\"submit\", \"#forgot-password-form\", function (e) {\r\n    e.preventDefault();\r\n    ForgotPasswordPage.sendApiRequest();\r\n  });\r\n\r\n  $(document).on(\"submit\", \"#reset-form\", function (e) {\r\n    e.preventDefault();\r\n    ResetPasswordPage.sendApiRequest();\r\n  });\r\n  $(document).on(\"click\", \"#resend-verification\", function (e) {\r\n    e.preventDefault();\r\n    VerifyAccountPage.sendApiRequest();\r\n  });\r\n});\r\n\n\n//# sourceURL=webpack://htdocs/./src/auth/auth.js?");

/***/ }),

/***/ "./src/auth/classes/AuthorizationClass.js":
/*!************************************************!*\
  !*** ./src/auth/classes/AuthorizationClass.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   AuthorizationClass: () => (/* binding */ AuthorizationClass),\n/* harmony export */   SpecialAuthorizationClass: () => (/* binding */ SpecialAuthorizationClass)\n/* harmony export */ });\nclass AuthorizationClass {\r\n  constructor(form, logger, loader, url, returnUrl, goBackTime = 3000) {\r\n    this.form = form;\r\n    this.logger = logger;\r\n    this.loader = loader;\r\n    this.url = url;\r\n    this.returnUrl = returnUrl;\r\n    this.goBackTime = goBackTime;\r\n    this.timer = null;\r\n    this.timer2 = null;\r\n  }\r\n\r\n  showMessage(message, messageType, cause) {\r\n    clearTimeout(this.timer);\r\n\r\n    const iconPath = messageType === \"success\" ? \"success.png\" : \"error.png\";\r\n    const className = `logger ${messageType}`;\r\n    const imageTag = `<span><img src='/global/imgs/${iconPath}'/></span>`;\r\n\r\n    this.logger.className = className;\r\n    this.logger.innerHTML = `${imageTag} ${message}`;\r\n\r\n    if (cause !== \"none\") {\r\n      clearTimeout(this.timer2);\r\n\r\n      let element = document.querySelector(`[name=${cause}]`);\r\n      element.style.border = \"1px solid red\";\r\n\r\n      this.timer2 = setTimeout(() => {\r\n        element.style = \"\";\r\n      }, 2000);\r\n    }\r\n\r\n    this.timer = setTimeout(() => {\r\n      this.logger.className = \"logger\";\r\n      this.logger.innerHTML = \"\";\r\n    }, 8000);\r\n  }\r\n\r\n  sendApiRequest() {\r\n    this.loader.style.display = \"flex\";\r\n\r\n    $.ajax({\r\n      url: this.url,\r\n      type: \"POST\",\r\n      data: new FormData(this.form),\r\n      processData: false,\r\n      contentType: false,\r\n      success: (data) => {\r\n        this.loader.style.display = \"none\";\r\n        const response = JSON.parse(data);\r\n        const [status, message, cause] = response;\r\n        this.showMessage(message, status, cause);\r\n\r\n        if (status === \"success\") {\r\n          let i = this.goBackTime / 1000;\r\n          this.logger.innerHTML += `<span> ${i}</span>`;\r\n\r\n          const timer = setInterval(() => {\r\n            i--;\r\n            this.logger.lastElementChild.textContent = `${i}`; // Update the span's text content\r\n            if (i === -1) {\r\n              clearInterval(timer);\r\n            }\r\n          }, 1000);\r\n          setTimeout(() => {\r\n            window.location.href = this.returnUrl;\r\n          }, this.goBackTime);\r\n        }\r\n      },\r\n    });\r\n  }\r\n}\r\n\r\nclass SpecialAuthorizationClass extends AuthorizationClass {\r\n  constructor(\r\n    form,\r\n    logger,\r\n    loader,\r\n    url,\r\n    returnUrl,\r\n    goBackTime = 2000,\r\n    oldLoggerText\r\n  ) {\r\n    super(form, logger, loader, url, returnUrl, goBackTime);\r\n    this.oldLoggerText = oldLoggerText;\r\n  }\r\n\r\n  showMessage(message, messageType, cause) {\r\n    super.showMessage(message, messageType, cause);\r\n\r\n    clearTimeout(this.timer);\r\n\r\n    this.timer = setTimeout(() => {\r\n      this.logger.className = \"logger warning\";\r\n      this.logger.innerHTML = this.oldLoggerText;\r\n    }, 8000);\r\n  }\r\n}\r\n\n\n//# sourceURL=webpack://htdocs/./src/auth/classes/AuthorizationClass.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
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
/******/ 	var __webpack_exports__ = __webpack_require__("./src/auth/auth.js");
/******/ 	
/******/ })()
;