"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[94],{5735:(t,e,a)=>{a.d(e,{Z:()=>i});var n=a(3645),s=a.n(n)()((function(t){return t[1]}));s.push([t.id,".card.card-background .full-background[data-v-7af7a26a]{background-position:50%;background-size:cover;border-radius:.75rem;height:100%;margin-bottom:30px;position:absolute;width:100%}.card .card-background[data-v-7af7a26a]{align-items:center}.card-background[data-v-7af7a26a]{height:200px;margin-bottom:0;margin-top:0}",""]);const i=s},8255:(t,e,a)=>{a.d(e,{Z:()=>i});var n=a(3645),s=a.n(n)()((function(t){return t[1]}));s.push([t.id,".card.card-background .full-background[data-v-3cb74b66]{background-position:50%;background-size:cover;border-radius:.75rem;height:100%;margin-bottom:30px;position:absolute;width:100%}.card .card-background[data-v-3cb74b66]{align-items:center}.card-background[data-v-3cb74b66]{height:200px;margin-bottom:0;margin-top:0}.btn-width[data-v-3cb74b66]{width:100%}.filepond--wrapper[data-v-3cb74b66]{border:1px solid #ccc;border-radius:4px}",""]);const i=s},3645:t=>{t.exports=function(t){var e=[];return e.toString=function(){return this.map((function(e){var a=t(e);return e[2]?"@media ".concat(e[2]," {").concat(a,"}"):a})).join("")},e.i=function(t,a,n){"string"==typeof t&&(t=[[null,t,""]]);var s={};if(n)for(var i=0;i<this.length;i++){var r=this[i][0];null!=r&&(s[r]=!0)}for(var o=0;o<t.length;o++){var c=[].concat(t[o]);n&&s[c[0]]||(a&&(c[2]?c[2]="".concat(a," and ").concat(c[2]):c[2]=a),e.push(c))}},e}},3379:(t,e,a)=>{var n,s=function(){return void 0===n&&(n=Boolean(window&&document&&document.all&&!window.atob)),n},i=function(){var t={};return function(e){if(void 0===t[e]){var a=document.querySelector(e);if(window.HTMLIFrameElement&&a instanceof window.HTMLIFrameElement)try{a=a.contentDocument.head}catch(t){a=null}t[e]=a}return t[e]}}(),r=[];function o(t){for(var e=-1,a=0;a<r.length;a++)if(r[a].identifier===t){e=a;break}return e}function c(t,e){for(var a={},n=[],s=0;s<t.length;s++){var i=t[s],c=e.base?i[0]+e.base:i[0],d=a[c]||0,l="".concat(c," ").concat(d);a[c]=d+1;var u=o(l),f={css:i[1],media:i[2],sourceMap:i[3]};-1!==u?(r[u].references++,r[u].updater(f)):r.push({identifier:l,updater:b(f,e),references:1}),n.push(l)}return n}function d(t){var e=document.createElement("style"),n=t.attributes||{};if(void 0===n.nonce){var s=a.nc;s&&(n.nonce=s)}if(Object.keys(n).forEach((function(t){e.setAttribute(t,n[t])})),"function"==typeof t.insert)t.insert(e);else{var r=i(t.insert||"head");if(!r)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");r.appendChild(e)}return e}var l,u=(l=[],function(t,e){return l[t]=e,l.filter(Boolean).join("\n")});function f(t,e,a,n){var s=a?"":n.media?"@media ".concat(n.media," {").concat(n.css,"}"):n.css;if(t.styleSheet)t.styleSheet.cssText=u(e,s);else{var i=document.createTextNode(s),r=t.childNodes;r[e]&&t.removeChild(r[e]),r.length?t.insertBefore(i,r[e]):t.appendChild(i)}}function v(t,e,a){var n=a.css,s=a.media,i=a.sourceMap;if(s?t.setAttribute("media",s):t.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(n+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}var h=null,m=0;function b(t,e){var a,n,s;if(e.singleton){var i=m++;a=h||(h=d(e)),n=f.bind(null,a,i,!1),s=f.bind(null,a,i,!0)}else a=d(e),n=v.bind(null,a,e),s=function(){!function(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t)}(a)};return n(t),function(e){if(e){if(e.css===t.css&&e.media===t.media&&e.sourceMap===t.sourceMap)return;n(t=e)}else s()}}t.exports=function(t,e){(e=e||{}).singleton||"boolean"==typeof e.singleton||(e.singleton=s());var a=c(t=t||[],e);return function(t){if(t=t||[],"[object Array]"===Object.prototype.toString.call(t)){for(var n=0;n<a.length;n++){var s=o(a[n]);r[s].references--}for(var i=c(t,e),d=0;d<a.length;d++){var l=o(a[d]);0===r[l].references&&(r[l].updater(),r.splice(l,1))}a=i}}}},6412:(t,e,a)=>{a.d(e,{Z:()=>d});var n=""==baseUrl?"":"/dlearning/public";const s={name:"card-title",props:["classesId"],data:function(){return{classData:{name:"",code:""},image:"background-image:url("+n+"/material/img/class.jpg)"}},created:function(){this.fetchTitleData()},methods:{fetchTitleData:function(){var t=this;this.axios.get(baseUrl+"/api/class/".concat(this.classesId)).then((function(e){t.classData=e.data}))}}};var i=a(3379),r=a.n(i),o=a(5735),c={insert:"head",singleton:!1};r()(o.Z,c);o.Z.locals;const d=(0,a(1900).Z)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"card card-background"},[a("div",{staticClass:"full-background",style:t.image}),t._v(" "),a("div",{staticClass:"card-body pt-12"},[a("h2",{staticClass:"text-white font-weight-bold pt-2"},[t._v("\n          "+t._s(t.classData.name)+"\n        ")]),t._v(" "),a("p",{staticClass:"text-white"},[t._v("\n          Class code: "),a("b",[t._v(t._s(t.classData.code))])])])])])])}),[],!1,null,"7af7a26a",null).exports},9094:(t,e,a)=>{a.r(e),a.d(e,{default:()=>c});const n={components:{cardTitle:a(6412).Z},name:"view-class-list",data:function(){return{studentsList:[],students:[],studlist:{class_id:"",student_id:""}}},created:function(){this.studlist.class_id=this.$route.params.id,this.fetchStudentsList()},mounted:function(){$(".select2").select2(),this.fetchStudentsList(),this.fetchStudents(),$("#student_id").change(function(){this.studlist.student_id=$("#student_id").val()}.bind(this))},methods:{showAddModal:function(){this.resetForm(),$("#addModal").modal("show")},fetchStudents:function(){var t=this;axios.get(baseUrl+"/api/studentsList/students",{params:{user_id:sessionUserId}}).then((function(e){t.students=e.data})).catch((function(t){console.log(t)}))},fetchStudentsList:function(){var t=this;axios.get(baseUrl+"/api/studentsList",{params:{class_id:this.$route.params.id}}).then((function(e){console.log(e.data),t.studentsList=e.data})).catch((function(t){console.log(t)}))},addStudent:function(){var t=this;axios.post(baseUrl+"/api/studentsList",{student_list:this.studlist}).then((function(e){$("#addModal").modal("hide"),1==e.data?success_add():entry_already_exists(),t.fetchStudentsList()})).catch((function(t){console.log(t)}))},removeStudent:function(t){var e=this;swal({title:"Are you sure?",text:"You won't be able to revert this!",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!",showLoaderOnConfirm:!0,preConfirm:function(){return new Promise((function(a){axios.delete(baseUrl+"/api/deleteStudentsList/".concat(t)).then((function(t){console.log(t),e.fetchStudentsList(),success_delete()})).catch((function(t){console.log(t)}))}))},allowOutsideClick:!1})},resetForm:function(){$("#student_id").val(""),$(".select2").select2().trigger("change")}}};var s=a(3379),i=a.n(s),r=a(8255),o={insert:"head",singleton:!1};i()(r.Z,o);r.Z.locals;const c=(0,a(1900).Z)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"content pt-0"},[a("div",{staticClass:"container-fluid pt-0"},[a("card-title",{attrs:{classesId:t.studlist.class_id}}),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"card"},[t._m(0),t._v(" "),a("div",{staticClass:"card-body"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 text-right"},[a("button",{staticClass:"btn btn-sm btn-primary",on:{click:t.showAddModal}},[t._v("\n                  Add Student\n                ")])]),t._v(" "),a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table"},[t._m(1),t._v(" "),t.studentsList.length>0?a("tbody",t._l(t.studentsList,(function(e,n){return a("tr",{key:n},[a("td"),t._v(" "),a("td",[t._v("\n                        "+t._s(e.user.fname+" "+e.user.mname+" "+e.user.lname)+"\n                      ")]),t._v(" "),a("td",[t._v("\n                        "+t._s(new Date(e.created_at).toLocaleString())+"\n                      ")]),t._v(" "),a("td",[a("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(a){return t.removeStudent(e.id)}}},[a("span",{staticClass:"material-icons"},[t._v("remove_circle")]),t._v("\n                          Remove\n                        ")])])])})),0):a("tbody",[t._m(2)])])])])])])])])],1),t._v(" "),a("div",{staticClass:"modal fade",attrs:{id:"addModal",role:"dialog","aria-labelledby":"exampleModalLabel","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[a("form",{on:{submit:function(e){return e.preventDefault(),t.addStudent.apply(null,arguments)}}},[t._m(3),t._v(" "),a("div",{staticClass:"modal-body"},[a("div",{staticClass:"form-group bmd-form-group"},[a("label",[t._v("Student")]),t._v(" "),a("select",{staticClass:"form-control select2",staticStyle:{width:"100%"},attrs:{id:"student_id",required:""}},[a("option",{attrs:{value:""}},[t._v("-- Select student --")]),t._v(" "),t._l(t.students,(function(e,n){return a("option",{key:n,domProps:{value:e.id}},[t._v("\n                  "+t._s(e.fname+" "+e.mname+" "+e.lname)+"\n                ")])}))],2)])]),t._v(" "),t._m(4)])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card-header card-header-primary"},[a("h4",{staticClass:"card-title"},[t._v("Class list")]),t._v(" "),a("p",{staticClass:"card-category"},[t._v("\n              Here you can manage your list of students\n            ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",{staticClass:"text-primary"},[a("tr",[a("th",[t._v("#")]),t._v(" "),a("th",[t._v("Student Name")]),t._v(" "),a("th",[t._v("Date Joined")]),t._v(" "),a("th",{staticClass:"text-right"},[t._v("Actions")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"4",align:"center"}},[t._v("No Class List Found")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-header"},[a("h5",{staticClass:"modal-title",attrs:{id:"exampleModalLabel"}},[t._v("\n              Add Student to List\n            ")]),t._v(" "),a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("\n              Save changes\n            ")]),t._v(" "),a("button",{staticClass:"btn btn-secondary",attrs:{type:"button","data-dismiss":"modal"}},[t._v("\n              Close\n            ")])])}],!1,null,"3cb74b66",null).exports}}]);