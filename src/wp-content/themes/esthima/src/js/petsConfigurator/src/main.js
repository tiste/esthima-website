import { createApp } from "vue";
import VueLazyLoad from 'vue3-lazyload'

import App from "./App.vue";
import router from "./routes";
import store from './store/index';


const app = createApp(App);

app.use(router);

app.use(store);

app.use(VueLazyLoad)

app.mount("#petsConfigurator");
