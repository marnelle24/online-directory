require('./bootstrap');

// Require Vue
window.Vue = require('vue').default;

Vue.use(require('vue-moment'));

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import { BIconArrowUp, BIconArrowDown } from 'bootstrap-vue'
Vue.component('BIconArrowUp', BIconArrowUp)
Vue.component('BIconArrowDown', BIconArrowDown)


// Register Vue Components
Vue.component('homepage', 
    require('./components/homepage.vue').default);

// Initialize Vue
const app = new Vue({
    el: '#app',
});