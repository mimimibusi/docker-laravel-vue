/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import { createApp } from 'vue';
import App from './App.vue';
import { setupCalendar } from 'v-calendar';
import { router } from './routes/router'; //app.tsだとここがanyとかでエラー

const app = createApp(App);
app.use(router);
app.use(setupCalendar, {})
app.mount('#app');
app.component('example-component', require('./components/ExampleComponent.vue').default);
