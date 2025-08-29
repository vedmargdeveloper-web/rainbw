/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/css/main.css":
/*!********************************!*\
  !*** ./resources/css/main.css ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/***/ (() => {

$(document).ready(function () {
  $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
    var $el = $(this);
    var $parent = $(this).offsetParent(".dropdown-menu");
    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    var $subMenu = $(this).next(".dropdown-menu");
    $subMenu.toggleClass('show');
    $(this).parent("li").toggleClass('show');
    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
      $('.dropdown-menu .show').removeClass("show");
    });
    if (!$parent.parent().hasClass('navbar-nav')) {
      $el.next().css({
        "top": $el[0].offsetTop,
        "left": $parent.outerWidth() - 4
      });
    }
    return false;
  });
});

// Todays Date
$(function () {
  var interval = setInterval(function () {
    var momentNow = moment();
    $('#today-date').html(momentNow.format('DD') + ' ' + ' ' + momentNow.format('- dddd').substring(0, 12));
  }, 100);
});
$(function () {
  var interval = setInterval(function () {
    var momentNow = moment();
    $('#todays-date').html(momentNow.format('DD MMMM YYYY'));
  }, 100);
});

// Loading
$(function () {
  $("#loading-wrapper").fadeOut(3000);
});

// Textarea characters left
$(function () {
  $('#characterLeft').text('140 characters left');
  $('#message').keydown(function () {
    var max = 140;
    var len = $(this).val().length;
    if (len >= max) {
      $('#characterLeft').text('You have reached the limit');
      $('#characterLeft').addClass('red');
      $('#btnSubmit').addClass('disabled');
    } else {
      var ch = max - len;
      $('#characterLeft').text(ch + ' characters left');
      $('#btnSubmit').removeClass('disabled');
      $('#characterLeft').removeClass('red');
    }
  });
});

// Todo list
$('.todo-body').on('click', 'li.todo-list', function () {
  $(this).toggleClass('done');
});

// Tasks
(function ($) {
  var checkList = $('.task-checkbox'),
    toDoCheck = checkList.children('input[type="checkbox"]');
  toDoCheck.each(function (index, element) {
    var $this = $(element),
      taskItem = $this.closest('.task-block');
    $this.on('click', function (e) {
      taskItem.toggleClass('task-checked');
    });
  });
})(jQuery);

// Tasks Important Active
$('.task-actions').on('click', '.important', function () {
  $(this).toggleClass('active');
});

// Tasks Important Active
$('.task-actions').on('click', '.star', function () {
  $(this).toggleClass('active');
});

// Quick Links Sidebar
(function ($) {
  // Collaboration Yammer Sidebar
  $('.quick-links-btn').click(function () {
    // Slide Box Toggle
    $('.quick-links-box').toggleClass("quick-links-box-show");
    $('.screen-overlay').toggleClass("show");
    $('body').css('overflow', 'hidden');
  });
  $('.quick-links-box-close').click(function () {
    // Slide Box Toggle
    $('.quick-links-box').toggleClass("quick-links-box-show");
    $('.screen-overlay').toggleClass("show");
    $('body').css('overflow', 'auto');
  });
})(jQuery);

// Quick Settings Sidebar
(function ($) {
  // Collaboration Yammer Sidebar
  $('.quick-settings-btn').click(function () {
    // Slide Box Toggle
    $('.quick-settings-box').toggleClass("quick-settings-box-show");
    $('.screen-overlay').toggleClass("show");
    $('body').css('overflow', 'hidden');
  });
  $('.quick-settings-box-close').click(function () {
    // Slide Box Toggle
    $('.quick-settings-box').toggleClass("quick-settings-box-show");
    $('.screen-overlay').toggleClass("show");
    $('body').css('overflow', 'auto');
  });
})(jQuery);

// Countdown
$(document).ready(function () {
  countdown();
  setInterval(countdown, 1000);
  function countdown() {
    var now = moment(),
      // get the current moment
      // May 28, 2013 @ 12:00AM
      then = moment([2020, 2, 7]),
      // get the difference from now to then in ms
      ms = then.diff(now, 'milliseconds', true);
    // If you need years, uncomment this line and make sure you add it to the concatonated phrase
    /*
    years = Math.floor(moment.duration(ms).asYears());
    then = then.subtract('years', years);
    */
    // update the duration in ms
    ms = then.diff(now, 'milliseconds', true);
    // get the duration as months and round down
    // months = Math.floor(moment.duration(ms).asMonths());

    // // subtract months from the original moment (not sure why I had to offset by 1 day)
    // then = then.subtract('months', months).subtract('days', 1);
    // update the duration in ms
    ms = then.diff(now, 'milliseconds', true);
    days = Math.floor(moment.duration(ms).asDays());
    then = then.subtract(days, 'days');
    // update the duration in ms
    ms = then.diff(now, 'milliseconds', true);
    hours = Math.floor(moment.duration(ms).asHours());
    then = then.subtract(hours, 'hours');
    // update the duration in ms
    ms = then.diff(now, 'milliseconds', true);
    minutes = Math.floor(moment.duration(ms).asMinutes());
    then = then.subtract(minutes, 'minutes');
    // update the duration in ms
    ms = then.diff(now, 'milliseconds', true);
    seconds = Math.floor(moment.duration(ms).asSeconds());

    // concatonate the variables
    diff = '<div class="num">' + days + ' <span class="text"> Days Left</span></div>';
    $('#daysLeft').html(diff);
  }
});
$('body').on('click', '.quotation_uid', function () {
  var id = $(this).val();
  var base_url = $('meta[name="base_url"]').attr('content');
  $.ajax({
    url: base_url + '/admin/ajax/fetchstatus',
    type: 'GET',
    dataType: 'json',
    data: {
      inquiry_id: id
    }
  }).done(function (success) {
    //console.log();
    if (success.status != undefined) {
      $("#dynamic_lead_status").html(success.status);
    } else {
      $("#dynamic_lead_status").html('');
    }
    console.log(success);
  }).fail(function () {
    console.log("error");
  }).always(function () {
    console.log("complete");
  });
});
$('body').on('focusout', '#customer_mobile', function () {
  // alert('sadf');

  var id = $(this).val();
  var base_url = $('meta[name="base_url"]').attr('content');
  $.ajax({
    url: base_url + '/admin/ajax/fetch-inquiry',
    type: 'GET',
    dataType: 'json',
    data: {
      phone: id
    }
  }).done(function (success) {
    if (success.status) {
      $('.history-btn').show();
      $("#history-table").html(success.inquires);
    } else {
      //console.log(success);
      $('.history-btn').hide();
      $("#history-table").html('');
    }
  }).fail(function (error) {
    console.log("error", error);
  }).always(function () {
    console.log("complete");
  });
});

// Bootstrap JS ***********

// Tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
$(function () {
  $('[data-toggle="popover"]').popover();
});

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
/******/ 			"/js/main": 0,
/******/ 			"css/main": 0
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
/******/ 	__webpack_require__.O(undefined, ["css/main"], () => (__webpack_require__("./resources/js/main.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/main"], () => (__webpack_require__("./resources/css/main.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;