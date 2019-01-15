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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(6);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

Nova.booting(function (Vue, router, store) {
    router.addRoutes([{
        name: 'tracked-timesheets',
        path: '/tracked-timesheets',
        component: __webpack_require__(2)
    }]);
});

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(4)
/* template */
var __vue_template__ = __webpack_require__(5)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/Tool.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-68ff5483", Component.options)
  } else {
    hotAPI.reload("data-v-68ff5483", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 3 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      initialLoading: true,
      loading: false,
      runningTimer: {},
      timer: null,
      timeWorked: 0
    };
  },

  methods: {
    initialize: function initialize() {
      this.getRunningTimer();
    },
    getRunningTimer: function getRunningTimer() {
      var _this = this;

      Nova.request().get("/nova-vendor/tracked-timesheets/latest-timer").then(function (response) {
        _this.runningTimer = response.data;

        if (_this.isValid) {
          _this.timeWorked = response.data.time_worked;

          if (_this.isRunning) {
            _this.startTimer();
          }
        } else {
          // TODO: Move to create new.
        }

        _this.initialLoading = false;
        _this.loading = false;
      });
    },
    pauseRunningTimer: function pauseRunningTimer() {
      var _this2 = this;

      this.loading = true;

      Nova.request().get("/nova-vendor/tracked-timesheets/latest-timer/pause").then(function (response) {
        _this2.runningTimer = response.data;

        if (_this2.isValid) {
          _this2.timeWorked = response.data.time_worked;
        } else {
          // TODO: Move to create new.
        }

        _this2.loading = false;
      });
    },
    resumeRunningTimer: function resumeRunningTimer() {
      var _this3 = this;

      this.loading = true;

      Nova.request().get("/nova-vendor/tracked-timesheets/latest-timer/resume").then(function (response) {
        _this3.runningTimer = response.data;

        if (_this3.isValid) {
          _this3.timeWorked = response.data.time_worked;
        } else {
          // TODO: Move to create new.
        }

        _this3.loading = false;
      });
    },
    stopRunningTimer: function stopRunningTimer() {
      var _this4 = this;

      this.loading = true;

      Nova.request().get("/nova-vendor/tracked-timesheets/latest-timer/stop").then(function (response) {
        _this4.runningTimer = response.data;

        if (_this4.isValid) {
          _this4.timeWorked = response.data.time_worked;
        } else {
          // TODO: Move to create new.
        }

        _this4.loading = false;
      });
    },
    startTimer: function startTimer() {
      var _this5 = this;

      this.timer = setInterval(function () {
        return _this5.updateTimer();
      }, 1000);
    },
    updateTimer: function updateTimer() {
      this.timeWorked++;
    },
    pauseTimer: function pauseTimer() {
      this.pauseRunningTimer();

      clearInterval(this.timer);
      this.timer = null;
    },
    resumeTimer: function resumeTimer() {
      this.resumeRunningTimer();
      this.startTimer();
    },
    stopTimer: function stopTimer() {
      this.stopRunningTimer();

      clearInterval(this.timer);
      this.timer = null;
    },
    padTime: function padTime(time) {
      return (time < 10 ? "0" : "") + time;
    }
  },

  computed: {
    timeWorked: function timeWorked() {
      return this.timeWorked;
    },
    hours: function hours() {
      return Math.floor(this.timeWorked / 3600);
    },
    minutes: function minutes() {
      return this.padTime(Math.floor(this.timeWorked / 60) % 60);
    },
    seconds: function seconds() {
      return this.padTime(this.timeWorked % 60);
    },
    isValid: function isValid() {
      return this.runningTimer != "{}";
    },
    isRunning: function isRunning() {
      return this.isValid && !this.isEnded && this.runningTimer.paused_at == null;
    },
    isPaused: function isPaused() {
      return this.isValid && !this.isEnded && this.runningTimer.paused_at != null;
    },
    isEnded: function isEnded() {
      return this.isValid && this.runningTimer.ended_at != null;
    }
  },

  created: function created() {
    this.initialize();
  }
});

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "loading-view",
    { attrs: { loading: _vm.initialLoading } },
    [
      _c("h1", { staticClass: "mb-6 text-90 font-normal text-2xl" }, [
        _vm._v("Log Details")
      ]),
      _vm._v(" "),
      _c(
        "loading-card",
        {
          staticClass: "card overflow-hidden",
          attrs: { loading: _vm.loading }
        },
        [
          _vm.isValid
            ? _c("div", [
                _c("div", { staticClass: "px-8 py-6" }, [
                  _vm._v(
                    _vm._s(_vm.hours) +
                      ":" +
                      _vm._s(_vm.minutes) +
                      ":" +
                      _vm._s(_vm.seconds)
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "bg-30 flex px-8 py-4" }, [
                  _vm.isRunning
                    ? _c(
                        "button",
                        {
                          staticClass:
                            "btn btn-default btn-primary inline-flex items-center relative ml-auto mr-auto",
                          attrs: { type: "button" },
                          on: { click: _vm.pauseTimer }
                        },
                        [_vm._v("Pause")]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.isPaused
                    ? _c(
                        "button",
                        {
                          staticClass:
                            "btn btn-default btn-primary inline-flex items-center relative ml-auto mr-3",
                          attrs: { type: "button" },
                          on: { click: _vm.resumeTimer }
                        },
                        [_vm._v("Resume")]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.isPaused
                    ? _c(
                        "button",
                        {
                          staticClass:
                            "btn btn-default btn-primary inline-flex items-center relative mr-auto",
                          attrs: { type: "button" },
                          on: { click: _vm.stopTimer }
                        },
                        [_vm._v("Stop")]
                      )
                    : _vm._e()
                ])
              ])
            : _vm._e()
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-68ff5483", module.exports)
  }
}

/***/ }),
/* 6 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);