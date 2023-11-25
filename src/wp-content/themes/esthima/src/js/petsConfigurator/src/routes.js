import { createRouter, createWebHashHistory } from "vue-router";
import Home from './views/Home'
import InfoAnimal from './views/InfoAnimal'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/informations-animal',
        name: 'InfoAnimal',
        component: InfoAnimal
    }
  ],
});

export default router;