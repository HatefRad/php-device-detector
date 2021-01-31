import {createApp} from 'vue';

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import UserDevice from './UserDevice.vue';
import Devices from './Devices.vue';
import mitt from 'mitt';

const emitter = mitt();

const app = createApp({
    data() {
        return {}
    }
});

app.config.globalProperties.emitter = emitter

app.component('user-device-component', UserDevice);
app.component('devices-component', Devices);

app.mount('#app');
