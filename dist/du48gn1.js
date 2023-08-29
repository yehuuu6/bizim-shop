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

/***/ "./src/dashboard/classes/PanelClass.js":
/*!*********************************************!*\
  !*** ./src/dashboard/classes/PanelClass.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ PanelClass)\n/* harmony export */ });\nclass PanelClass {\r\n  constructor(logger, loader) {\r\n    this.logger = logger;\r\n    this.loader = loader;\r\n    this.timer = null;\r\n    this.timer2 = null;\r\n  }\r\n\r\n  showMessage(data) {\r\n    clearTimeout(this.timer);\r\n\r\n    try {\r\n      var response = JSON.parse(data);\r\n      var [messageType, message, cause] = response;\r\n    } catch (e) {\r\n      // DANGER This is a security risk. Do not use this in production.\r\n      var [messageType, message, cause] = [\"error\", data, \"none\"];\r\n    }\r\n\r\n    const iconPath =\r\n      messageType === \"success\"\r\n        ? \"success.png\"\r\n        : messageType === \"error\"\r\n        ? \"error.png\"\r\n        : messageType === \"warning\"\r\n        ? \"info.png\"\r\n        : \"\";\r\n\r\n    const className = `logger ${messageType}`;\r\n    const imageTag = `<span><img src='/global/imgs/${iconPath}'/></span>`;\r\n\r\n    this.logger.className = className;\r\n    this.logger.innerHTML = `${imageTag} ${message}`;\r\n\r\n    if (cause !== \"none\") {\r\n      clearTimeout(this.timer2);\r\n\r\n      let element = document.querySelector(`[name=${cause}]`)\r\n        ? document.querySelector(`[name=${cause}]`)\r\n        : document.querySelector(`[id=${cause}]`);\r\n      element.style.border = \"1px solid red\";\r\n\r\n      this.timer2 = setTimeout(() => {\r\n        element.style = \"\";\r\n      }, 2000);\r\n    }\r\n\r\n    this.timer = setTimeout(() => {\r\n      this.logger.className = \"logger\";\r\n      this.logger.innerHTML = \"\";\r\n    }, 8000);\r\n  }\r\n\r\n  async sendApiRequest(url, formData) {\r\n    this.loader.style.display = \"flex\";\r\n\r\n    return new Promise((resolve, reject) => {\r\n      $.ajax({\r\n        url: url,\r\n        type: \"POST\",\r\n        data: formData,\r\n        processData: false,\r\n        contentType: false,\r\n        success: (data) => {\r\n          resolve(data);\r\n        },\r\n        error: (error) => {\r\n          reject(error);\r\n        },\r\n      });\r\n    }).finally(() => {\r\n      this.loader.style.display = \"none\";\r\n    });\r\n  }\r\n}\r\n\n\n//# sourceURL=webpack://htdocs/./src/dashboard/classes/PanelClass.js?");

/***/ }),

/***/ "./src/dashboard/models/Modal.js":
/*!***************************************!*\
  !*** ./src/dashboard/models/Modal.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ ConfirmationModal)\n/* harmony export */ });\nfunction ConfirmationModal() {\r\n  const modal = document.createElement(\"div\");\r\n  modal.classList.add(\"delete-modal\");\r\n\r\n  const delCon = document.createElement(\"div\");\r\n  delCon.classList.add(\"delete-modal-content\");\r\n\r\n  const modTitle = document.createElement(\"h1\");\r\n  modTitle.innerText = \"Uyarı!\";\r\n  modTitle.classList.add(\"delete-modal-title\");\r\n\r\n  const lineBreak = document.createElement(\"hr\");\r\n  lineBreak.classList.add(\"delete-modal-line\");\r\n\r\n  const delModText = document.createElement(\"p\");\r\n\r\n  const delModWarn = document.createElement(\"strong\");\r\n  delModWarn.innerText = \"BU EYLEM GERİ ALINAMAZ.\";\r\n  delModWarn.classList.add(\"warn\");\r\n\r\n  const delSpan = document.createElement(\"span\");\r\n  delSpan.innerText = \"Devam et?\";\r\n\r\n  const delModBtns = document.createElement(\"div\");\r\n  delModBtns.classList.add(\"delete-modal-btns\");\r\n\r\n  const delModCan = document.createElement(\"button\");\r\n  delModCan.classList.add(\"btn\", \"success-btn\");\r\n  delModCan.innerText = \"Hayır\";\r\n  delModCan.addEventListener(\"click\", () => {\r\n    modal.remove();\r\n  });\r\n\r\n  const delModCon = document.createElement(\"button\");\r\n  delModCon.classList.add(\"btn\", \"delete-btn\");\r\n  delModCon.innerText = \"Evet\";\r\n\r\n  // Close delete modal when outside of modal is clicked\r\n  modal.addEventListener(\"click\", (e) => {\r\n    if (e.target === modal) {\r\n      modal.remove();\r\n    }\r\n  });\r\n\r\n  delModBtns.append(delModCon, delModCan);\r\n  delCon.append(\r\n    modTitle,\r\n    lineBreak.cloneNode(),\r\n    delModText,\r\n    lineBreak.cloneNode(),\r\n    delModWarn,\r\n    lineBreak.cloneNode(),\r\n    delSpan,\r\n    delModBtns\r\n  );\r\n\r\n  modal.appendChild(delCon);\r\n\r\n  return {\r\n    modal: modal,\r\n    modalText: delModText,\r\n    modalBtn: delModCon,\r\n  };\r\n}\r\n\n\n//# sourceURL=webpack://htdocs/./src/dashboard/models/Modal.js?");

/***/ }),

/***/ "./src/dashboard/user.js":
/*!*******************************!*\
  !*** ./src/dashboard/user.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   ProfilePage: () => (/* binding */ ProfilePage)\n/* harmony export */ });\n/* harmony import */ var _classes_PanelClass_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./classes/PanelClass.js */ \"./src/dashboard/classes/PanelClass.js\");\n/* harmony import */ var _models_Modal_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./models/Modal.js */ \"./src/dashboard/models/Modal.js\");\n/* harmony import */ var _utils_functions_usr_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils/functions.usr.js */ \"./src/dashboard/utils/functions.usr.js\");\n\r\n\r\n\r\n\r\nconst { modal, modalText, modalBtn } = (0,_models_Modal_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"])();\r\n\r\nconst profileLogger = document.querySelector(\"#logger-profile\");\r\nconst profileLoader = document.querySelector(\"#loader-profile\");\r\n\r\nconst ProfilePage = new _classes_PanelClass_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"](profileLogger, profileLoader);\r\n\r\nconst ResetPassword = new _classes_PanelClass_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"](profileLogger, profileLoader);\r\n\r\nconst RemoveAvatar = new _classes_PanelClass_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"](profileLogger, profileLoader);\r\n\r\n$(document).ready(function () {\r\n  $(document).on(\"submit\", \"#profile-form\", function (e) {\r\n    e.preventDefault();\r\n    (0,_utils_functions_usr_js__WEBPACK_IMPORTED_MODULE_2__.getApiResponse)(\r\n      ProfilePage,\r\n      \"/api/dashboard/users/edit-profile.php\",\r\n      new FormData(this),\r\n      profileLogger\r\n    );\r\n  });\r\n  $(document).on(\"click\", \"#password-reset\", function (e) {\r\n    e.preventDefault();\r\n    (0,_utils_functions_usr_js__WEBPACK_IMPORTED_MODULE_2__.getApiResponse)(\r\n      ResetPassword,\r\n      \"/api/dashboard/users/reset-password.php\",\r\n      new FormData(),\r\n      profileLogger\r\n    );\r\n  });\r\n  $(document).on(\"click\", \"#delete-avatar\", function (e) {\r\n    e.preventDefault();\r\n    document.body.append(modal);\r\n    modalText.innerText = \"Profil resminizi silmek istediğinize emin misiniz?\";\r\n    modalBtn.addEventListener(\"click\", function () {\r\n      (0,_utils_functions_usr_js__WEBPACK_IMPORTED_MODULE_2__.getApiResponse)(\r\n        RemoveAvatar,\r\n        \"/api/dashboard/users/delete-avatar.php\",\r\n        new FormData(),\r\n        profileLogger\r\n      );\r\n      modalText.innerText = \"\";\r\n      modalBtn.removeEventListener(\"click\", this);\r\n      modal.remove();\r\n      (0,_utils_functions_usr_js__WEBPACK_IMPORTED_MODULE_2__.clearAvatarInput)();\r\n      document.querySelector(\".profile-image\").src = \"/global/imgs/nopp.png\";\r\n      $(\"#delete-avatar\").remove();\r\n    });\r\n  });\r\n});\r\n\r\n// Exports\r\n\r\n\r\n\n\n//# sourceURL=webpack://htdocs/./src/dashboard/user.js?");

/***/ }),

/***/ "./src/dashboard/utils/functions.usr.js":
/*!**********************************************!*\
  !*** ./src/dashboard/utils/functions.usr.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   clearAvatarInput: () => (/* binding */ clearAvatarInput),\n/* harmony export */   getApiResponse: () => (/* binding */ getApiResponse),\n/* harmony export */   getDate: () => (/* binding */ getDate),\n/* harmony export */   getPerm: () => (/* binding */ getPerm),\n/* harmony export */   scrollToElement: () => (/* binding */ scrollToElement),\n/* harmony export */   trimSentence: () => (/* binding */ trimSentence)\n/* harmony export */ });\n/* harmony import */ var _user_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../user.js */ \"./src/dashboard/user.js\");\n\r\n\r\n// Directly gets response and displays the message. Use this if you don't need to do stuff with response.\r\nfunction getApiResponse(panelObject, url, formData, scrollTo) {\r\n  panelObject.sendApiRequest(url, formData).then((data) => {\r\n    try {\r\n      var response = JSON.parse(data);\r\n    } catch (e) {\r\n      panelObject.showMessage(\r\n        JSON.stringify[\r\n          (\"error\", \"Bir hata oluştu. Lütfen tekrar deneyin.\", \"none\")\r\n        ]\r\n      );\r\n    }\r\n    if (panelObject == _user_js__WEBPACK_IMPORTED_MODULE_0__.ProfilePage && response[0] === \"success\")\r\n      clearAvatarInput();\r\n    panelObject.showMessage(data);\r\n    scrollToElement(scrollTo);\r\n  });\r\n}\r\n\r\nfunction clearAvatarInput() {\r\n  document.querySelector(\"#avatar-input\").value = \"\";\r\n  document.querySelector(\"#avatar-input-displayer\").innerText =\r\n    \"Dosya seçilmedi.\";\r\n}\r\n\r\nfunction scrollToElement(element) {\r\n  window.scrollTo({\r\n    top: element.offsetTop,\r\n    behavior: \"smooth\",\r\n  });\r\n}\r\n\r\nfunction trimSentence(sentence, maxLength) {\r\n  if (sentence.length > maxLength) {\r\n    sentence = sentence.substring(0, maxLength - 3) + \"...\";\r\n  }\r\n  return sentence;\r\n}\r\n\r\nfunction getDate(raw) {\r\n  const [year, month_t, day] = raw.split(\"-\");\r\n  const month_names = [\r\n    \"Jan\",\r\n    \"Feb\",\r\n    \"March\",\r\n    \"April\",\r\n    \"May\",\r\n    \"June\",\r\n    \"July\",\r\n    \"Aug\",\r\n    \"Sep\",\r\n    \"Oct\",\r\n    \"Nov\",\r\n    \"Dec\",\r\n  ];\r\n  const month = month_names[Number(month_t) - 1];\r\n  const day_trimmed = Number(day).toString();\r\n  return `${month} ${day_trimmed}, ${year}`;\r\n}\r\n\r\nfunction getPerm(id) {\r\n  let perm = \"\";\r\n  id = parseInt(id);\r\n  switch (id) {\r\n    case 0:\r\n      perm = \"Üye\";\r\n      break;\r\n    case 1:\r\n      perm = \"Yönetici\";\r\n      break;\r\n  }\r\n  return perm;\r\n}\r\n\n\n//# sourceURL=webpack://htdocs/./src/dashboard/utils/functions.usr.js?");

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
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = __webpack_require__("./src/dashboard/user.js");
/******/ 	
/******/ })()
;