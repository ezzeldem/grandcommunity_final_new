
import { createApp } from 'vue';
const app = createApp({});
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);
app.mount('#app');
require('./bootstrap');

import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'socket.io',
	host: window.location.hostname + ':6001'
});
