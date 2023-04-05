import { createApp } from 'vue';
import App from './App.vue';
import { setupCalendar } from 'v-calendar';
import { router } from './routes/router'; //app.tsだとここがanyとかでエラー

const app = createApp(App);
app.use(router);
app.use(setupCalendar, {})
app.mount('#app');