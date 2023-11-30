// // Import Vue
// import Vue from 'vue'
// import VueRouter from 'vue-router'
// import Vuelidate from 'vuelidate'
// import store from './store/index';


// // Import Vue App, routes, store
// import App from './App'
// import routes from './routes'
// import './directives/directives'
// import './mixins/mixins'


// Vue.use(Vuelidate)
// Vue.use(VueRouter)

// Vue.config.silent = true


// // Configure router
// const router = new VueRouter({
//     routes,
//     linkActiveClass: 'active',
//     // mode: 'history'
// })


// window.vmPetsConfigurator = new Vue({
//     el: '#petsConfigurator',
//     render: h => h(App),
//     router,
//     store
// })


import { createApp } from "vue";

import App from "./App.vue";
import router from "./routes";
import store from './store/index';


const app = createApp(App);

app.use(router);

app.use(store);

app.mount("#petsConfigurator");
