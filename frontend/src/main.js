import { createApp } from "vue";
import { createPinia } from "pinia";
import "./style.css";
import App from "@/App.vue";
import router from "@/router";
import Vue3Toastify from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const pinia = createPinia();

createApp(App).use(router).use(pinia).use(Vue3Toastify).mount("#app");
