/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();
/* Slider da página inicial */

/* Máscara para telefone */
$(document).ready(function () {
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 50) {
      $(".header").addClass("change");
    } else {
      $(".header").removeClass("change");
    }
  });

  /*** MENU CLASS SCROLL ***/
  $(".filtro_box .box_explorador").click(function () {
    $(this).next(".filtro_estado").toggle();
  });
  $(".box_filtro_busca .box_explorador").click(function () {
    $(".filtro_busca").toggle();
  });
  $(".telefone").mask('(99) 999999999');
  $(".cep").mask('99999-999');
  $(".cpf").mask('999.999.999-99');
  $(".data").mask('99/99/9999');

  /* Esconder e abrir hamburguer menu */
  $(".m-menu").click(function () {
    $("#main-menu").toggle();
  });
  $('.explorerSelectState').change(function () {
    var value = $(this).val();
    $('.explorerSelectState').each(function () {
      if ($(this).val() !== value) {
        $(this).val(value);
      }
    });
    redirectToExplorer();
  });
  $('.explorerSelectRate').change(function () {
    redirectToExplorer();
  });
  $('.explorerTopState').change(function () {
    redirectToSelectedUF();
  });
  $('.explorerTopParty').change(function () {
    redirectToSelectedParty();
  });
  $('.explorerTopAxis').change(function () {
    redirectToSelectedAxis();
  });
  $('#stateSelectorExplorerPanel').change(function () {
    var acronym = $(this).val();
    $('.stateSubstitute').html($(this).find(':selected').attr('data-name').toUpperCase());
    $('.substituteLink').each(function () {
      var href = $(this).attr('href');
      $(this).attr('href', href.replace('/br/', '/' + acronym + '/'));
    });
    $('#modal_filtro_porperty').foundation('reveal', 'open');
  });
  $('#stateSelectorExplorerPanelSelected').change(function () {
    var acronym = $(this).val();
    $('.stateSubstitute').html($(this).find(':selected').attr('data-name').toUpperCase());
    $('.substituteLink').each(function () {
      var href = $(this).attr('href');
      $(this).attr('href', href.replace('/br/', '/' + acronym + '/'));
    });
    $('#modal_destaque_property').foundation('reveal', 'open');
  });
  $('.filterSelectState').change(function () {
    redirectToFilter();
  });
  $('.filterSelectRate').change(function () {
    redirectToFilter();
  });
  $('.rangeCustomIndex').on("input change", function () {
    var text = 'relevante';
    var style = '50% 100%';
    if ($(this).val() === '0') {
      style = '0% 100%';
      text = 'não relevante (x0)';
    }
    if ($(this).val() === '1') {
      style = '50% 100%';
      text = ' relevante (x1)';
    }
    if ($(this).val() === '2') {
      style = '100% 100%';
      text = 'muito relevante (x2)';
    }
    $(this).css('background-size', style).siblings('.textRelevance').html(text);
    checkChecks();
  });
  $('.customindexsubmit').click(function (e) {
    var checked = false;
    $('.rangeCustomIndex').each(function (range) {
      if ($(this).val() !== '1') {
        checked = true;
      }
    });
    if (!checked) {
      e.preventDefault();
    } else {
      $(this).parent('forms').submit();
    }
  });
  $('#stateCustomIndex').change(function () {
    $('#hiddenInputState').val($(this).val());
    $('#hiddenForm').submit();
  });
  $('#classificationCustomIndex').change(function () {
    $('#hiddenInputClassification').val($(this).val());
    $('#hiddenForm').submit();
  });
});
function checkChecks() {
  var checked = false;
  $('.rangeCustomIndex').each(function () {
    if ($(this).val() !== '1') {
      checked = true;
    }
  });
  if (checked) {
    $('.customindexsubmit').removeClass('disabled');
  } else {
    $('.customindexsubmit').addClass('disabled');
  }
}
function redirectToExplorer() {
  var state = $('.explorerSelectState').val() || null;
  var rate = $('.explorerSelectRate').val() || null;
  if (!state && rate) {
    location.href = baseUrl + '/explorador/' + rate;
  }
  if (state && rate) {
    location.href = baseUrl + '/explorador/' + rate + '/' + state.toLowerCase();
  }
  if (state && !rate) {
    location.href = baseUrl + '/explorador/estado/' + state.toLowerCase();
  }
  if (!state && !rate) {
    location.href = baseUrl + '/explorador/';
  }
}
function redirectToSelectedUF() {
  var state = $('.explorerTopState').val() || null;
  if (state) {
    location.href = baseUrl + '/explorador/topn/estado/' + state.toLowerCase();
  }
}
function redirectToSelectedParty() {
  var party = $('.explorerTopParty').val() || null;
  if (party) {
    location.href = baseUrl + '/explorador/topn/party/' + party.toLowerCase();
  }
}
function redirectToSelectedAxis() {
  var axis = $('.explorerTopAxis').val() || null;
  if (axis) {
    location.href = baseUrl + '/explorador/topn/eixo/' + axis.toLowerCase();
  }
}
function redirectToFilter() {
  var stateSelect = $('.filterSelectState');
  var state = stateSelect.val() || 'br';
  var rate = $('.filterSelectRate').val() || null;
  var uri = stateSelect.attr('data-params');
  if (rate) {
    location.href = baseUrl + '/explorador/filtro/' + state.toLowerCase() + uri + rate;
  }
  if (state && !rate) {
    location.href = baseUrl + '/explorador/filtro/' + state.toLowerCase() + uri;
  }
}

/***/ }),

/***/ "./resources/css/app.scss":
/*!********************************!*\
  !*** ./resources/css/app.scss ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;