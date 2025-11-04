import app from './vue/instance';
import * as flowbite from 'flowbite'
import {createPinia} from "pinia";

require('./vue/components/__require');

const pinia = createPinia()
window.flowbite = flowbite;

app.use(pinia)
app.mount('#app');
