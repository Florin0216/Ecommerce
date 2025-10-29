import app from './vue/instance';
import * as flowbite from 'flowbite'

require('./vue/components/__require');

window.flowbite = flowbite;

app.mount('#app');
