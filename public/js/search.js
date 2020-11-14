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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/search.js":
/*!********************************!*\
  !*** ./resources/js/search.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// const { lowerFirst } = require("lodash");
$('.service').on('change', function () {
  change();
});
$('#cerca').on('click', function () {
  change();
}); // function change(){
//     var service = '';
//     var city = ($('#city').val() == '') ? '?city=0' : '?city='+$('#city').val();
//     var rooms = ($('#rooms').val() == '') ? '&room=0' : '&room='+$('#rooms').val();
//     $('.service').each(function(){
//         if ($(this).is(':checked')){
//             service = service + '&' + $(this).attr('value') + '=' + '1';
//         } else {
//             service = service + '&' + $(this).attr('value') + '=' + '0';
//         }
//     })
//     window.history.pushState("","", city+rooms+service);
// }

var url = window.location.href;

if (url.includes('?')) {
  getApiParams();
  insertValues();
} // var url_string = window.location.href; //window.location.href
// var url = new URL(url_string);
// var c = url.searchParams.get("city");
// console.log(c);


function change() {
  var params = {};
  params['city'] = $('#city').val() == '' ? '0' : $('#city').val();
  params['rooms'] = $('#rooms').val() == '' ? '0' : $('#rooms').val();
  $('.service').each(function () {
    if ($(this).is(':checked')) {
      params[$(this).attr('value')] = '1';
    } else {
      params[$(this).attr('value')] = '0';
    }
  });
  var str = jQuery.param(params);
  window.history.pushState("", "", '?' + str);
  getApiParams();
}

function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }
}

;

function getApiParams() {
  var urlParams = {};
  urlParams['city'] = getUrlParameter('city');
  urlParams['rooms'] = getUrlParameter('rooms');

  for (var i = 1; i <= $('.service').length; i++) {
    urlParams[i] = getUrlParameter(i.toString());
  }

  console.log(urlParams);
}

function insertValues() {
  if (getUrlParameter('city') != 0) {
    $('#city').val(getUrlParameter('city'));
  }

  $('#rooms').val(getUrlParameter('rooms'));

  for (var x = 1; x <= $('.service').length; x++) {
    if (getUrlParameter(x.toString()) == '1') {
      $('[value=' + x + ']').prop('checked', true);
    }
  }
}

/***/ }),

/***/ 1:
/*!**************************************!*\
  !*** multi ./resources/js/search.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/davidefrancavilla/Desktop/Classe#16/boolbnb/resources/js/search.js */"./resources/js/search.js");


/***/ })

/******/ });