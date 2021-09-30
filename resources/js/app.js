require('./bootstrap');

import Vue from 'vue'

import App from './vue/app'
import App1 from './vue/app1'

const app = new Vue({
    el: '#app',
    components : {App,App1}
});