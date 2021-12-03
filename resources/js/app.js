require("./bootstrap");

import Vue from "vue";

import App from "./component/app";
import VueRouter from "vue-router";
import VueAxios from "vue-axios";
import axios from "axios";
import { routes } from "./routes";
import VueMobileDetection from 'vue-mobile-detection';


Vue.use(VueMobileDetection);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: "history",
    // base: "/dlearning/",
    routes: routes,
    linkActiveClass: "active"
});

const app = new Vue({
    el: "#app",
    router: router,
    render: h => h(App)
});

