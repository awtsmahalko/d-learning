"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[32],{5609:(t,e,s)=>{s.d(e,{Z:()=>i});var a=s(3645),n=s.n(a)()((function(t){return t[1]}));n.push([t.id,".card.card-background .full-background[data-v-1eb97cb1]{background-position:50%;background-size:cover;border-radius:.75rem;height:100%;margin-bottom:30px;position:absolute;width:100%}.card .card-background[data-v-1eb97cb1]{align-items:center}.card-background[data-v-1eb97cb1]{height:200px;margin-bottom:0;margin-top:0}.btn-width[data-v-1eb97cb1]{width:100%}.filepond--wrapper[data-v-1eb97cb1]{border:1px solid #ccc;border-radius:4px}",""]);const i=n},3645:t=>{t.exports=function(t){var e=[];return e.toString=function(){return this.map((function(e){var s=t(e);return e[2]?"@media ".concat(e[2]," {").concat(s,"}"):s})).join("")},e.i=function(t,s,a){"string"==typeof t&&(t=[[null,t,""]]);var n={};if(a)for(var i=0;i<this.length;i++){var o=this[i][0];null!=o&&(n[o]=!0)}for(var r=0;r<t.length;r++){var c=[].concat(t[r]);a&&n[c[0]]||(s&&(c[2]?c[2]="".concat(s," and ").concat(c[2]):c[2]=s),e.push(c))}},e}},3379:(t,e,s)=>{var a,n=function(){return void 0===a&&(a=Boolean(window&&document&&document.all&&!window.atob)),a},i=function(){var t={};return function(e){if(void 0===t[e]){var s=document.querySelector(e);if(window.HTMLIFrameElement&&s instanceof window.HTMLIFrameElement)try{s=s.contentDocument.head}catch(t){s=null}t[e]=s}return t[e]}}(),o=[];function r(t){for(var e=-1,s=0;s<o.length;s++)if(o[s].identifier===t){e=s;break}return e}function c(t,e){for(var s={},a=[],n=0;n<t.length;n++){var i=t[n],c=e.base?i[0]+e.base:i[0],d=s[c]||0,l="".concat(c," ").concat(d);s[c]=d+1;var u=r(l),f={css:i[1],media:i[2],sourceMap:i[3]};-1!==u?(o[u].references++,o[u].updater(f)):o.push({identifier:l,updater:p(f,e),references:1}),a.push(l)}return a}function d(t){var e=document.createElement("style"),a=t.attributes||{};if(void 0===a.nonce){var n=s.nc;n&&(a.nonce=n)}if(Object.keys(a).forEach((function(t){e.setAttribute(t,a[t])})),"function"==typeof t.insert)t.insert(e);else{var o=i(t.insert||"head");if(!o)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");o.appendChild(e)}return e}var l,u=(l=[],function(t,e){return l[t]=e,l.filter(Boolean).join("\n")});function f(t,e,s,a){var n=s?"":a.media?"@media ".concat(a.media," {").concat(a.css,"}"):a.css;if(t.styleSheet)t.styleSheet.cssText=u(e,n);else{var i=document.createTextNode(n),o=t.childNodes;o[e]&&t.removeChild(o[e]),o.length?t.insertBefore(i,o[e]):t.appendChild(i)}}function v(t,e,s){var a=s.css,n=s.media,i=s.sourceMap;if(n?t.setAttribute("media",n):t.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(a+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),t.styleSheet)t.styleSheet.cssText=a;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(a))}}var h=null,m=0;function p(t,e){var s,a,n;if(e.singleton){var i=m++;s=h||(h=d(e)),a=f.bind(null,s,i,!1),n=f.bind(null,s,i,!0)}else s=d(e),a=v.bind(null,s,e),n=function(){!function(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t)}(s)};return a(t),function(e){if(e){if(e.css===t.css&&e.media===t.media&&e.sourceMap===t.sourceMap)return;a(t=e)}else n()}}t.exports=function(t,e){(e=e||{}).singleton||"boolean"==typeof e.singleton||(e.singleton=n());var s=c(t=t||[],e);return function(t){if(t=t||[],"[object Array]"===Object.prototype.toString.call(t)){for(var a=0;a<s.length;a++){var n=r(s[a]);o[n].references--}for(var i=c(t,e),d=0;d<s.length;d++){var l=r(s[d]);0===o[l].references&&(o[l].updater(),o.splice(l,1))}s=i}}}},49:(t,e,s)=>{s.d(e,{Z:()=>n});const a={name:"card-title",props:["classesId"],data:function(){return{classData:{name:"",code:""},image:{backgroundImage:"/material/img/class.jpg"}}},created:function(){this.fetchTitleData()},methods:{fetchTitleData:function(){var t=this;this.axios.get("/api/class/".concat(this.classesId)).then((function(e){t.classData=e.data}))}}};const n=(0,s(1900).Z)(a,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12"},[s("div",{staticClass:"card card-background"},[s("div",{staticClass:"full-background",staticStyle:{"background-image":"url(/material/img/class.jpg)"}}),t._v(" "),s("div",{staticClass:"card-body pt-12"},[s("h2",{staticClass:"font-weight-bold pt-2"},[t._v("\n            "+t._s(t.classData.name)+"\n            ")]),t._v(" "),s("p",[t._v("\n            Class code: "),s("b",[t._v(t._s(t.classData.code))])])])])])])}),[],!1,null,null,null).exports},2032:(t,e,s)=>{s.r(e),s.d(e,{default:()=>c});const a={components:{cardTitle:s(49).Z},name:"view-class-list",data:function(){return{studentsList:[],students:[],studlist:{class_id:"",student_id:""}}},created:function(){this.studlist.class_id=this.$route.params.id,this.fetchStudentsList()},mounted:function(){$(".select2").select2(),this.fetchStudentsList(),this.fetchStudents(),$("#student_id").change(function(){this.studlist.student_id=$("#student_id").val()}.bind(this))},methods:{showAddModal:function(){this.resetForm(),$("#addModal").modal("show")},fetchStudents:function(){var t=this;axios.get("/api/studentsList/students",{params:{user_id:sessionUserId}}).then((function(e){t.students=e.data})).catch((function(t){console.log(t)}))},fetchStudentsList:function(){var t=this;axios.get("/api/studentsList",{params:{class_id:this.$route.params.id}}).then((function(e){console.log(e.data),t.studentsList=e.data})).catch((function(t){console.log(t)}))},addStudent:function(){var t=this;axios.post("/api/studentsList",{student_list:this.studlist}).then((function(e){$("#addModal").modal("hide"),success_add(),t.fetchStudentsList()})).catch((function(t){console.log(t)}))},removeStudent:function(t){var e=this;swal({title:"Are you sure?",text:"You won't be able to revert this!",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!",showLoaderOnConfirm:!0,preConfirm:function(){return new Promise((function(s){axios.delete("/api/deleteStudentsList/".concat(t)).then((function(t){console.log(t),e.fetchStudentsList(),success_delete()})).catch((function(t){console.log(t)}))}))},allowOutsideClick:!1})},resetForm:function(){$("#student_id").val(""),$(".select2").select2().trigger("change")}}};var n=s(3379),i=s.n(n),o=s(5609),r={insert:"head",singleton:!1};i()(o.Z,r);o.Z.locals;const c=(0,s(1900).Z)(a,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"content pt-0"},[s("div",{staticClass:"container-fluid pt-0"},[s("card-title",{attrs:{classesId:t.studlist.class_id}}),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12"},[s("div",{staticClass:"card"},[t._m(0),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 text-right"},[s("button",{staticClass:"btn btn-sm btn-primary",on:{click:t.showAddModal}},[t._v(" Add Student ")])]),t._v(" "),s("div",{staticClass:"table-responsive"},[s("table",{staticClass:"table"},[t._m(1),t._v(" "),t.studentsList.length>0?s("tbody",t._l(t.studentsList,(function(e,a){return s("tr",{key:a},[s("td"),t._v(" "),s("td",[t._v(t._s(e.user.fname+" "+e.user.mname+" "+e.user.lname))]),t._v(" "),s("td",[t._v(t._s(new Date(e.created_at).toLocaleString()))]),t._v(" "),s("td",[s("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(s){return t.removeStudent(e.id)}}},[t._v("Delete")])])])})),0):s("tbody",[t._m(2)])])])])])])])])],1),t._v(" "),s("div",{staticClass:"modal fade",attrs:{id:"addModal",role:"dialog","aria-labelledby":"exampleModalLabel","aria-hidden":"true"}},[s("div",{staticClass:"modal-dialog",attrs:{role:"document"}},[s("div",{staticClass:"modal-content"},[s("form",{on:{submit:function(e){return e.preventDefault(),t.addStudent.apply(null,arguments)}}},[t._m(3),t._v(" "),s("div",{staticClass:"modal-body"},[s("div",{staticClass:"form-group bmd-form-group"},[s("label",[t._v("Student")]),t._v(" "),s("select",{staticClass:"form-control select2",staticStyle:{width:"100%"},attrs:{id:"student_id",required:""}},[s("option",{attrs:{value:""}},[t._v("-- Select student --")]),t._v(" "),t._l(t.students,(function(e,a){return s("option",{key:a,domProps:{value:e.id}},[t._v(" "+t._s(e.fname+" "+e.mname+" "+e.lname)+" ")])}))],2)])]),t._v(" "),t._m(4)])])])])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"card-header card-header-primary"},[s("h4",{staticClass:"card-title "},[t._v("Class list")]),t._v(" "),s("p",{staticClass:"card-category"},[t._v(" Here you can manage your list of students")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",{staticClass:" text-primary"},[s("tr",[s("th",[t._v("#")]),t._v(" "),s("th",[t._v("Student Name")]),t._v(" "),s("th",[t._v("Date Joined")]),t._v(" "),s("th",{staticClass:"text-right"},[t._v("Actions")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("td",{attrs:{colspan:"4",align:"center"}},[t._v("No Class List Found")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal-header"},[s("h5",{staticClass:"modal-title",attrs:{id:"exampleModalLabel"}},[t._v("Add Student to List")]),t._v(" "),s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[s("span",{attrs:{"aria-hidden":"true"}},[t._v("×")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Save changes")]),t._v(" "),s("button",{staticClass:"btn btn-secondary",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])}],!1,null,"1eb97cb1",null).exports}}]);