import { createApp } from 'vue';
import App from './App.vue';
import { router } from './routes/router'; //app.tsだとここがanyとかでエラー

const app = createApp(App);
app.use(router);
app.mount('#app');