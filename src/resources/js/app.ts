/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import { createApp } from "vue";
import App from "./App.vue";
import { router } from "./routes/router"; //app.tsだとここがanyとかでエラー
import ExampleComponent from "./components/ExampleComponent.vue";

const app = createApp(App);
app.use(router);
app.mount("#app");
app.component("example-component", ExampleComponent);
