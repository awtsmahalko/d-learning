"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_component_videocon_view_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
var pre_url = baseUrl == '' ? "" : "/dlearning/public";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "card-title",
  props: ["classesId"],
  data: function data() {
    return {
      classData: {
        name: "",
        code: ""
      },
      image: "background-image:url(" + pre_url + "/material/img/class.jpg)"
    };
  },
  created: function created() {
    this.fetchTitleData();
  },
  methods: {
    fetchTitleData: function fetchTitleData() {
      var _this = this;

      this.axios.get(baseUrl + "/api/class/".concat(this.classesId)).then(function (res) {
        _this.classData = res.data;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/videocon/view.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/videocon/view.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _classes_cardTitle_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./../classes/cardTitle.vue */ "./resources/js/component/classes/cardTitle.vue");
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
  name: "video-view",
  data: function data() {
    return {
      is_teacher: false,
      is_form_create: true,
      meeting: {
        id: 0,
        user_id: sessionUserId,
        class_id: "",
        title: "",
        description: "",
        scheduled_at: ""
      },
      meetings: []
    };
  },
  methods: {
    createMeeting: function createMeeting() {
      var _this2 = this;

      $("#btn-submit").prop("disabled", true);
      axios.post(baseUrl + "/api/video/create", this.meeting).then(function (response) {
        $("#btn-submit").prop("disabled", false);

        _this2.fetchMeetings();

        $("#exampleModal").modal("hide");
        _this2.is_form_create ? success_add() : success_update();
      })["catch"](function (error) {
        console.log(error);
      });
    },
    fetchMeetings: function fetchMeetings() {
      var _this3 = this;

      axios.get(baseUrl + "/api/video", {
        params: {
          user_id: sessionUserId,
          category: sessionCategory,
          class_id: this.meeting.class_id
        }
      }).then(function (response) {
        _this3.meetings = response.data;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    showModal: function showModal() {
      this.resetForm();
      this.is_form_create = true;
      $("#exampleModal").modal("show");
    },
    editMeeting: function editMeeting(id) {
      var _this4 = this;

      this.is_form_create = false;
      axios.get(baseUrl + "/api/video/".concat(id)).then(function (response) {
        _this4.meeting = response.data; // this.meeting.scheduled_at = new Date(response.data.scheduled_at).toISOString();
        // this.meeting.scheduled_at = new Date(response.data.scheduled_at).toLocaleString().slice(0, 19);

        $("#exampleModal").modal("show");
      })["catch"](function (error) {});
    },
    deleteMeeting: function deleteMeeting(id) {
      var _this = this;

      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        showLoaderOnConfirm: true,
        preConfirm: function preConfirm() {
          return new Promise(function (resolve) {
            axios["delete"](baseUrl + "/api/video/".concat(id)).then(function (response) {
              _this.fetchMeetings();

              success_delete();
            })["catch"](function (error) {
              console.log(error);
            });
          });
        },
        allowOutsideClick: false
      });
    },
    resetForm: function resetForm() {
      this.meeting.id = 0;
      this.meeting.title = "";
      this.meeting.description = "";
      this.meeting.scheduled_at = "";
    },
    finishMeeting: function finishMeeting(id) {
      var _this = this;

      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, finish it!",
        showLoaderOnConfirm: true,
        preConfirm: function preConfirm() {
          return new Promise(function (resolve) {
            axios.post(baseUrl + "/api/video/".concat(id, "/edit")).then(function (response) {
              _this.fetchMeetings();

              success_update();
            })["catch"](function (error) {
              console.log(error);
            });
          });
        },
        allowOutsideClick: false
      });
    },
    fetchAttendee: function fetchAttendee(id) {}
  },
  created: function created() {
    this.is_teacher = sessionCategory == "T" ? true : false;
    this.meeting.class_id = this.$route.params.id;
    this.fetchMeetings();
  },
  mounted: function mounted() {},
  components: {
    CardTitle: _classes_cardTitle_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.card.card-background .full-background[data-v-33f3ef42] {\n  background-position: 50%;\n  background-size: cover;\n  margin-bottom: 30px;\n  width: 100%;\n  height: 100%;\n  position: absolute;\n  border-radius: 0.75rem;\n}\n.card .card-background[data-v-33f3ef42] {\n  align-items: center;\n}\n.card-background[data-v-33f3ef42] {\n  height: 200px;\n  margin-top: 0px;\n  margin-bottom: 0px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_style_index_0_id_33f3ef42_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_style_index_0_id_33f3ef42_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_style_index_0_id_33f3ef42_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/component/classes/cardTitle.vue":
/*!******************************************************!*\
  !*** ./resources/js/component/classes/cardTitle.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _cardTitle_vue_vue_type_template_id_33f3ef42_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true& */ "./resources/js/component/classes/cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true&");
/* harmony import */ var _cardTitle_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./cardTitle.vue?vue&type=script&lang=js& */ "./resources/js/component/classes/cardTitle.vue?vue&type=script&lang=js&");
/* harmony import */ var _cardTitle_vue_vue_type_style_index_0_id_33f3ef42_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css& */ "./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _cardTitle_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _cardTitle_vue_vue_type_template_id_33f3ef42_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _cardTitle_vue_vue_type_template_id_33f3ef42_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "33f3ef42",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/component/classes/cardTitle.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/component/videocon/view.vue":
/*!**************************************************!*\
  !*** ./resources/js/component/videocon/view.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _view_vue_vue_type_template_id_28ff3926___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./view.vue?vue&type=template&id=28ff3926& */ "./resources/js/component/videocon/view.vue?vue&type=template&id=28ff3926&");
/* harmony import */ var _view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./view.vue?vue&type=script&lang=js& */ "./resources/js/component/videocon/view.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _view_vue_vue_type_template_id_28ff3926___WEBPACK_IMPORTED_MODULE_0__.render,
  _view_vue_vue_type_template_id_28ff3926___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/component/videocon/view.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/component/classes/cardTitle.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/component/classes/cardTitle.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./cardTitle.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/component/videocon/view.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/component/videocon/view.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./view.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/videocon/view.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_style_index_0_id_33f3ef42_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=style&index=0&id=33f3ef42&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/component/classes/cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/component/classes/cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_template_id_33f3ef42_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_template_id_33f3ef42_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_cardTitle_vue_vue_type_template_id_33f3ef42_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true&");


/***/ }),

/***/ "./resources/js/component/videocon/view.vue?vue&type=template&id=28ff3926&":
/*!*********************************************************************************!*\
  !*** ./resources/js/component/videocon/view.vue?vue&type=template&id=28ff3926& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_view_vue_vue_type_template_id_28ff3926___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_view_vue_vue_type_template_id_28ff3926___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_view_vue_vue_type_template_id_28ff3926___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./view.vue?vue&type=template&id=28ff3926& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/videocon/view.vue?vue&type=template&id=28ff3926&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/classes/cardTitle.vue?vue&type=template&id=33f3ef42&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-md-12" }, [
      _c("div", { staticClass: "card card-background" }, [
        _c("div", { staticClass: "full-background", style: _vm.image }),
        _vm._v(" "),
        _c("div", { staticClass: "card-body pt-12" }, [
          _c("h2", { staticClass: "text-white font-weight-bold pt-2" }, [
            _vm._v("\n          " + _vm._s(_vm.classData.name) + "\n        ")
          ]),
          _vm._v(" "),
          _c("p", { staticClass: "text-white" }, [
            _vm._v("\n          Class code: "),
            _c("b", [_vm._v(_vm._s(_vm.classData.code))])
          ])
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/videocon/view.vue?vue&type=template&id=28ff3926&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/component/videocon/view.vue?vue&type=template&id=28ff3926& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "content" }, [
    _c(
      "div",
      { staticClass: "container-fluid" },
      [
        _c("card-title", { attrs: { classesId: _vm.$route.params.id } }),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-12" }, [
            _c("div", { staticClass: "card" }, [
              _vm._m(0),
              _vm._v(" "),
              _c("div", { staticClass: "card-body" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    {
                      directives: [
                        {
                          name: "show",
                          rawName: "v-show",
                          value: _vm.is_teacher,
                          expression: "is_teacher"
                        }
                      ],
                      staticClass: "col-12 text-right"
                    },
                    [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-sm btn-primary",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.showModal.apply(null, arguments)
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                  ADD MEETING\n                "
                          )
                        ]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "table-responsive" }, [
                    _c("table", { staticClass: "table" }, [
                      _vm._m(1),
                      _vm._v(" "),
                      _vm.meetings.length > 0
                        ? _c(
                            "tbody",
                            _vm._l(_vm.meetings, function(meet, key) {
                              return _c("tr", { key: key }, [
                                _c("td", [_vm._v(_vm._s(meet.class))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(meet.title))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(meet.description))]),
                                _vm._v(" "),
                                _c("td", [
                                  _vm._v(
                                    "\n                        " +
                                      _vm._s(
                                        new Date(
                                          meet.scheduled_at
                                        ).toLocaleString()
                                      ) +
                                      "\n                      "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(meet.status))]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-right" }, [
                                  _c(
                                    "div",
                                    {
                                      directives: [
                                        {
                                          name: "show",
                                          rawName: "v-show",
                                          value: _vm.is_teacher,
                                          expression: "is_teacher"
                                        }
                                      ],
                                      staticClass: "btn-group",
                                      attrs: { role: "group" }
                                    },
                                    [
                                      _c(
                                        "button",
                                        {
                                          directives: [
                                            {
                                              name: "show",
                                              rawName: "v-show",
                                              value:
                                                meet.status == "F"
                                                  ? true
                                                  : false,
                                              expression:
                                                "meet.status == 'F' ? true : false"
                                            }
                                          ],
                                          staticClass: "btn btn-sm btn-warning",
                                          on: {
                                            click: function($event) {
                                              return _vm.fetchAttendee(meet.id)
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "i",
                                            { staticClass: "material-icons" },
                                            [_vm._v("people")]
                                          ),
                                          _vm._v(
                                            " Attendees\n                          "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          directives: [
                                            {
                                              name: "show",
                                              rawName: "v-show",
                                              value:
                                                meet.status == "P"
                                                  ? true
                                                  : false,
                                              expression:
                                                "meet.status == 'P' ? true : false"
                                            }
                                          ],
                                          staticClass: "btn btn-sm btn-info",
                                          on: {
                                            click: function($event) {
                                              return _vm.finishMeeting(meet.id)
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "i",
                                            { staticClass: "material-icons" },
                                            [_vm._v("check_circle")]
                                          ),
                                          _vm._v(
                                            " FINISH MEETING\n                          "
                                          )
                                        ]
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      directives: [
                                        {
                                          name: "show",
                                          rawName: "v-show",
                                          value:
                                            meet.status != "F" ? true : false,
                                          expression:
                                            "meet.status != 'F' ? true : false"
                                        }
                                      ],
                                      staticClass: "btn-group",
                                      attrs: { role: "group" }
                                    },
                                    [
                                      _c(
                                        "router-link",
                                        {
                                          staticClass: "btn btn-sm btn-primary",
                                          attrs: {
                                            to: {
                                              name: "meeting",
                                              params: {
                                                id: meet.id,
                                                number: meet.number,
                                                password: meet.password,
                                                class_id: meet.class_id
                                              }
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "span",
                                            { staticClass: "material-icons" },
                                            [_vm._v("videocam")]
                                          ),
                                          _vm._v(
                                            "\n                            " +
                                              _vm._s(
                                                _vm.is_teacher
                                                  ? "Start"
                                                  : "Join"
                                              )
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          directives: [
                                            {
                                              name: "show",
                                              rawName: "v-show",
                                              value: _vm.is_teacher,
                                              expression: "is_teacher"
                                            }
                                          ],
                                          staticClass: "btn btn-sm btn-success",
                                          on: {
                                            click: function($event) {
                                              return _vm.editMeeting(meet.id)
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "i",
                                            { staticClass: "material-icons" },
                                            [_vm._v("edit_note")]
                                          ),
                                          _vm._v(
                                            " Edit\n                          "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          directives: [
                                            {
                                              name: "show",
                                              rawName: "v-show",
                                              value: _vm.is_teacher,
                                              expression: "is_teacher"
                                            }
                                          ],
                                          staticClass: "btn btn-sm btn-danger",
                                          on: {
                                            click: function($event) {
                                              return _vm.deleteMeeting(meet.id)
                                            }
                                          }
                                        },
                                        [
                                          _c(
                                            "i",
                                            { staticClass: "material-icons" },
                                            [_vm._v("delete_forever")]
                                          ),
                                          _vm._v(
                                            "\n                            Delete\n                          "
                                          )
                                        ]
                                      )
                                    ],
                                    1
                                  )
                                ])
                              ])
                            }),
                            0
                          )
                        : _c("tbody", [_vm._m(2)])
                    ])
                  ])
                ])
              ])
            ])
          ])
        ])
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "exampleModal",
          tabindex: "-1",
          role: "dialog",
          "aria-labelledby": "exampleModalLabel",
          "aria-hidden": "true"
        }
      },
      [
        _c(
          "div",
          { staticClass: "modal-dialog", attrs: { role: "document" } },
          [
            _c("div", { staticClass: "modal-content" }, [
              _c("div", { staticClass: "modal-header" }, [
                _c(
                  "h5",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.is_form_create,
                        expression: "is_form_create"
                      }
                    ],
                    staticClass: "modal-title",
                    attrs: { id: "exampleModalLabel" }
                  },
                  [_vm._v("\n            Add new meeting\n          ")]
                ),
                _vm._v(" "),
                _c(
                  "h5",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: !_vm.is_form_create,
                        expression: "!is_form_create"
                      }
                    ],
                    staticClass: "modal-title",
                    attrs: { id: "exampleModalLabel" }
                  },
                  [_vm._v("\n            Update meeting\n          ")]
                ),
                _vm._v(" "),
                _vm._m(3)
              ]),
              _vm._v(" "),
              _c(
                "form",
                {
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      return _vm.createMeeting.apply(null, arguments)
                    }
                  }
                },
                [
                  _c("div", { staticClass: "modal-body" }, [
                    _c("div", { staticClass: "form-group bmd-form-group" }, [
                      _c("label", [_vm._v("Title")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.meeting.title,
                            expression: "meeting.title"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", required: "" },
                        domProps: { value: _vm.meeting.title },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.meeting, "title", $event.target.value)
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group bmd-form-group" }, [
                      _c("label", [_vm._v("Description")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.meeting.description,
                            expression: "meeting.description"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", required: "" },
                        domProps: { value: _vm.meeting.description },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.meeting,
                              "description",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group bmd-form-group" }, [
                      _c("label", [_vm._v("Date")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.meeting.scheduled_at,
                            expression: "meeting.scheduled_at"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: {
                          type: "datetime-local",
                          id: "datetimepicker",
                          required: ""
                        },
                        domProps: { value: _vm.meeting.scheduled_at },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.meeting,
                              "scheduled_at",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _vm._m(4)
                ]
              )
            ])
          ]
        )
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header card-header-primary" }, [
      _c("h4", { staticClass: "card-title" }, [_vm._v("Meetings")]),
      _vm._v(" "),
      _c("p", { staticClass: "card-category" }, [
        _vm._v("Here you can manage your meetings")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "text-primary" }, [
      _c("tr", [
        _c("th", [_vm._v("#")]),
        _vm._v(" "),
        _c("th", [_vm._v("Title")]),
        _vm._v(" "),
        _c("th", [_vm._v("Description")]),
        _vm._v(" "),
        _c("th", [_vm._v("Schedule")]),
        _vm._v(" "),
        _c("th", [_vm._v("Status")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-right" }, [_vm._v("Actions")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "4", align: "center" } }, [
        _vm._v("No Meeting Found")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "close",
        attrs: {
          type: "button",
          "data-dismiss": "modal",
          "aria-label": "Close"
        }
      },
      [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-sm btn-secondary",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("\n              Close\n            ")]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "btn btn-sm btn-primary",
          attrs: { type: "submit", id: "btn-submit" }
        },
        [_vm._v("\n              Save changes\n            ")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);