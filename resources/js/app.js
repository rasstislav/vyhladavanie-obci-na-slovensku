/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import vueDebounce from 'vue-debounce';

import VillageSelect from './components/VillageSelectComponent';

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Set Vue & plugins globally
window.Vue = Vue;
window.axios = axios;

// Set Vue axios
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
Vue.use(VueAxios, axios);

// Use plugins
Vue.use(vueDebounce)

// Load components
Vue.component('app-village-select', VillageSelect)

// Create a fresh Vue application instance
new Vue({
    el: '#app',
});
