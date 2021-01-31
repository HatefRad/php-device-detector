import {createApp} from 'vue'
import mitt from 'mitt';

const emitter = mitt();
let app = createApp({})
app.config.globalProperties.emitter = emitter