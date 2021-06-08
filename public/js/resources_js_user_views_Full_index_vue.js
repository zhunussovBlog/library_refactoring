(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_user_views_Full_index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _mixins_goTo__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../mixins/goTo */ "./resources/js/user/mixins/goTo.js");
/* harmony import */ var _mixins_search__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins/search */ "./resources/js/user/mixins/search.js");
/* harmony import */ var _assets_icons_RightLittle__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../assets/icons/RightLittle */ "./resources/js/user/assets/icons/RightLittle.vue");
/* harmony import */ var _assets_icons_X__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../assets/icons/X */ "./resources/js/user/assets/icons/X.vue");
/* harmony import */ var _assets_icons_Save__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../assets/icons/Save */ "./resources/js/user/assets/icons/Save.vue");
/* harmony import */ var _assets_icons_Print__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../assets/icons/Print */ "./resources/js/user/assets/icons/Print.vue");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }

function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }

function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }

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
//
//
//
//
//
//
//
//
//






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  mixins: [_mixins_goTo__WEBPACK_IMPORTED_MODULE_0__.goTo, _mixins_search__WEBPACK_IMPORTED_MODULE_1__.getBookImage],
  components: {
    RightLittle: _assets_icons_RightLittle__WEBPACK_IMPORTED_MODULE_2__.default,
    X: _assets_icons_X__WEBPACK_IMPORTED_MODULE_3__.default,
    Save: _assets_icons_Save__WEBPACK_IMPORTED_MODULE_4__.default,
    Print: _assets_icons_Print__WEBPACK_IMPORTED_MODULE_5__.default
  },
  data: function data() {
    return {
      data: {
        array_data: [],
        image: '',
        isbn: '',
        description: '',
        content: ''
      },
      id: '',
      link: ''
    };
  },
  methods: {
    capitalize: function capitalize(s) {
      var string = s.slice();
      if (typeof string !== 'string') return '';
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    objectWithoutKey: function objectWithoutKey(object, key) {
      var deletedKey = object[key],
          otherKeys = _objectWithoutProperties(object, [key].map(_toPropertyKey));

      return otherKeys;
    },
    loadData: function loadData() {
      var _this = this;

      this.$store.commit('setFullPageLoading', true);
      this.$http.defaults.baseURL = window.configs.baseURL;
      this.$http.get('/api/media/show/' + this.id).then(function (response) {
        _this.data = Object.assign(_this.data, _this.importFromXML(response));
        _this.data.link = _this.link;
        _this.data.array_data = _this.convertToArray(objectWithoutKey(_this.data, ['id', 'type_key', 'issn', 'status', 'availability', 'description', 'content', 'array_data', 'image']));

        try {
          _this.getBookImage(_this.data, !_this.data.description);
        } catch (e) {}
      })["catch"](function (error) {
        console.error(error);
      }).then(function () {
        _this.$store.commit('setFullPageLoading', false);

        _this.$http.defaults.baseURL = window.configs.baseURL + window.configs.api;
      });
    },
    importFromXML: function importFromXML(response) {
      // need to have image in data
      var data = response.data.res;
      var xml = response.data.xmlInfo;

      if (xml) {
        data.description = this.getFromCatalog(xml, '520.a');
        var moreDescription = this.getFromCatalog(xml, '520.b');

        if (moreDescription) {
          data.description += '<br>' + moreDescription;
        }

        data.content = this.getFromCatalog(xml, '505.a');

        if (data.content) {
          data.content = data.content.split('--').join('<br>');
        }

        data.attribution = this.getFromCatalog(xml, '245.c');
      }

      return data;
    },
    getFromCatalog: function getFromCatalog(xml, code) {
      var data = xml.find(function (elem) {
        return elem.id == code;
      });
      return data ? data.data : null;
    },
    convertToArray: function convertToArray(object) {
      var arr = [];

      for (var key in object) {
        var obj = {
          key: key,
          value: object[key]
        };
        arr.push(obj);
      }

      return arr;
    },
    closeModal: function closeModal() {
      this.$emit('close');
      document.documentElement.classList.remove('overflow-hidden');
    },
    copyLink: function copyLink() {
      var copyText = document.createElement('input');
      copyText.value = this.link;
      document.body.appendChild(copyText);
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      /* For mobile devices */

      try {
        document.execCommand("copy");
        alert('Copied successfully: ' + copyText.value);
      } catch (e) {
        alert('Something went wrong');
      }

      document.body.removeChild(copyText);
    },
    printPage: function printPage() {
      window.print();
    }
  },
  created: function created() {
    this.id = this.$route.query.id;
    this.link = window.location.protocol + '//' + window.location.hostname + '/full?id=' + this.id;

    if (!this.id) {
      this.goTo('home');
    }

    this.loadData();
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.image[data-v-dc29a32e]{\n\tmin-width:12em;\n\tmax-width:12em;\n\tmin-height:15em;\n\tmax-height:15em;\n\tbackground-repeat: no-repeat;\n\tbackground-size: 100% 100%;\n}\n.bg-greyer[data-v-dc29a32e]{\n\tbackground: #a2a6a8 !important;\n}\n.exit[data-v-dc29a32e]{\n\tcolor:white;\n\tposition: absolute;\n\ttop:10%;\n\tright:4%;\n}\n.title[data-v-dc29a32e]{\n\tdisplay:flex;\n\talign-items:flex-end;\n}\n.title>.text[data-v-dc29a32e]{\n\tpadding-right:.3125em;\n\tfont-size:1.5em;\n}\n.title>.tline[data-v-dc29a32e]{\n\theight:1px;\n\tflex:1;\n\tbackground:#DADADA;\n\tmargin-bottom:.5em;\n}\ntd[data-v-dc29a32e]{\n\tborder-top: none;\n\tpadding-left: 0;\n}\n.mh-100[data-v-dc29a32e]{\n\tmin-height: 100%;\n}\n.min-vh-100[data-v-dc29a32e]{\n\tpadding-top: 5% !important;\n}\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_dc29a32e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_dc29a32e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_dc29a32e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/user/views/Full/index.vue":
/*!************************************************!*\
  !*** ./resources/js/user/views/Full/index.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _index_vue_vue_type_template_id_dc29a32e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=dc29a32e&scoped=true& */ "./resources/js/user/views/Full/index.vue?vue&type=template&id=dc29a32e&scoped=true&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/user/views/Full/index.vue?vue&type=script&lang=js&");
/* harmony import */ var _index_vue_vue_type_style_index_0_id_dc29a32e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css& */ "./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _index_vue_vue_type_template_id_dc29a32e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_vue_vue_type_template_id_dc29a32e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "dc29a32e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/user/views/Full/index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/user/views/Full/index.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/user/views/Full/index.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_dc29a32e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=style&index=0&id=dc29a32e&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/user/views/Full/index.vue?vue&type=template&id=dc29a32e&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/user/views/Full/index.vue?vue&type=template&id=dc29a32e&scoped=true& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_dc29a32e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_dc29a32e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_dc29a32e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=template&id=dc29a32e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=template&id=dc29a32e&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=template&id=dc29a32e&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/user/views/Full/index.vue?vue&type=template&id=dc29a32e&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "padding" }, [
    _c(
      "div",
      { staticClass: "d-flex align-items-start bg-white border-top py-4" },
      [
        _c("div", { staticClass: "mr-5" }, [
          _c("div", {
            staticClass: "image rounded bg-grey",
            style: "background-image: url(" + this.data.image + ")"
          }),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "d-flex align-items-center cursor-pointer py-2 mt-2",
              on: {
                click: function($event) {
                  return _vm.copyLink()
                }
              }
            },
            [
              _c("Save"),
              _vm._v(" "),
              _c("span", { staticClass: "ml-2" }, [
                _vm._v(_vm._s(_vm.$t("copy_link")))
              ])
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "d-flex align-items-center cursor-pointer py-2",
              on: {
                click: function($event) {
                  return _vm.printPage()
                }
              }
            },
            [
              _c("Print"),
              _vm._v(" "),
              _c("span", { staticClass: "ml-2" }, [
                _vm._v(_vm._s(_vm.$t("print_page")))
              ])
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "flex-fill" }, [
          _c("div", { staticClass: "d-flex flex-fill" }, [
            _c("div", { staticClass: "flex-fill" }, [
              _c(
                "div",
                {
                  staticClass:
                    "overflow-hidden title font-weight-bold font-size-24 cursor-pointer"
                },
                [_vm._v(_vm._s(_vm.data.title))]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "text-grey mt-2" }, [
                _vm.data.author
                  ? _c("div", [
                      _vm._v(
                        _vm._s(_vm.data.author) + ", " + _vm._s(_vm.data.year)
                      )
                    ])
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "d-flex text-center text-blue mt-3" }, [
                _vm.data.type
                  ? _c(
                      "div",
                      { staticClass: "rounded-lg bg-lightblue p-1 px-3" },
                      [_vm._v(_vm._s(_vm.$t(_vm.data.type)))]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.data.call_number
                  ? _c(
                      "div",
                      { staticClass: "rounded-lg bg-lightblue p-1 px-3 ml-3" },
                      [_vm._v(_vm._s(_vm.data.call_number))]
                    )
                  : _vm._e()
              ]),
              _vm._v(" "),
              _vm.data.description
                ? _c("div", { staticClass: "mt-3" }, [
                    _c("div", { staticClass: "text-grey font-size-14" }, [
                      _vm._v(
                        "\n\t\t\t\t\t\t\t" +
                          _vm._s(_vm.$t("description")) +
                          "\n\t\t\t\t\t\t"
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "mt-1",
                      domProps: { innerHTML: _vm._s(_vm.data.description) }
                    })
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.data.content
                ? _c("div", { staticClass: "mt-3" }, [
                    _c("div", { staticClass: "text-grey font-size-14" }, [
                      _vm._v(
                        "\n\t\t\t\t\t\t\t" +
                          _vm._s(_vm.$t("content")) +
                          "\n\t\t\t\t\t\t"
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "mt-1",
                      domProps: { innerHTML: _vm._s(_vm.data.content) }
                    })
                  ])
                : _vm._e()
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "text-center col-2 px-0" }, [
              _c(
                "div",
                { staticClass: "bg-lightgrey rounded-lg p-2 text-no-wrap" },
                [
                  _vm._v(
                    "\n\t\t\t\t\t\t" +
                      _vm._s(_vm.data.availability) +
                      "\n\t\t\t\t\t\t" +
                      _vm._s(_vm.$t("availability")) +
                      "\n\t\t\t\t\t"
                  )
                ]
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "title mt-4" }, [
            _c("div", { staticClass: "text" }, [
              _vm._v("\n\t\t\t\t\t" + _vm._s(_vm.$t("details")) + "\n\t\t\t\t")
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "tline" })
          ]),
          _vm._v(" "),
          _c("table", { staticClass: "table" }, [
            _c(
              "tbody",
              _vm._l(
                new Array(Math.ceil(_vm.data.array_data.length / 2)),
                function(info, index) {
                  return _c("tr", { key: index }, [
                    _c(
                      "td",
                      {
                        attrs: {
                          colspan:
                            _vm.data.array_data[index * 2 + 1] == undefined
                              ? "2"
                              : null
                        }
                      },
                      [
                        _c("div", { staticClass: "text-grey" }, [
                          _vm._v(
                            "\n\t\t\t\t\t\t\t\t" +
                              _vm._s(
                                _vm.$t(_vm.data.array_data[index * 2].key)
                              ) +
                              ":\n\t\t\t\t\t\t\t"
                          )
                        ]),
                        _vm._v(" "),
                        _c("div", [
                          _vm._v(
                            "\n\t\t\t\t\t\t\t\t" +
                              _vm._s(
                                _vm.data.array_data[index * 2].value !=
                                  undefined
                                  ? _vm.data.array_data[index * 2].value
                                  : _vm.$t("undefined")
                              ) +
                              "\n\t\t\t\t\t\t\t"
                          )
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _vm.data.array_data[index * 2 + 1] != undefined
                      ? _c("td", [
                          _c("div", { staticClass: "text-grey" }, [
                            _vm._v(
                              "\n\t\t\t\t\t\t\t\t" +
                                _vm._s(
                                  _vm.$t(_vm.data.array_data[index * 2 + 1].key)
                                ) +
                                ":\n\t\t\t\t\t\t\t"
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", [
                            _vm._v(
                              "\n\t\t\t\t\t\t\t\t" +
                                _vm._s(
                                  _vm.data.array_data[index * 2 + 1].value !=
                                    undefined
                                    ? _vm.data.array_data[index * 2 + 1].value
                                    : _vm.$t("undefined")
                                ) +
                                "\n\t\t\t\t\t\t\t"
                            )
                          ])
                        ])
                      : _vm._e()
                  ])
                }
              ),
              0
            )
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);