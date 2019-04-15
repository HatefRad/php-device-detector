window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.component('user-device-component', require('./UserDevice.vue').default);
Vue.component('devices-component', require('./Devices.vue').default);

const app = new Vue({
    el: '#app'
});
