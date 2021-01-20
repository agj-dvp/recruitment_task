
require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue'
import router from './router'
import VueAutosuggest from "vue-autosuggest"
import CripLoading from "crip-vue-loading"
import axios from "axios"
import VueSpinners from 'vue-spinners'

Vue.component('mainapp', require('./components/MainApp').default)
Vue.component('navbar', require('./components/Pages/Navbar').default)
Vue.component('search', require('./components/Pages/Search').default)
Vue.use(VueAutosuggest)
Vue.use(VueSpinners)
Vue.use(CripLoading, {axios})


const app = new Vue({
    el: '#app',
    router,
})
router.mode = 'html5'