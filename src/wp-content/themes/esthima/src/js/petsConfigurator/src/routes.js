import { createRouter, createWebHashHistory } from "vue-router";

const Home = () => import('./views/Home')
const InfoAnimal = () => import('./views/InfoAnimal')
const Cendres = () => import('./views/Cendres')

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
          nextPath: 'InfoAnimal'
        } 
    },
    {
        path: '/informations-animal',
        name: 'InfoAnimal',
        component: InfoAnimal,
        meta: {
          backPath: 'Home',
          nextPath: 'Cendres'
        }
    },
    {
        path: '/cendres',
        name: 'Cendres',
        component: Cendres,
        meta: {
          backPath: 'InfoAnimal',
          nextPath: 'Cendres'
        }

    }
  ],
});

export default router;