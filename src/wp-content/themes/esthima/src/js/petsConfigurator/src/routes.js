import { createRouter, createWebHashHistory } from "vue-router";

const Home = () => import('./views/Home')
const InfoAnimal = () => import('./views/InfoAnimal')
const Cendres = () => import('./views/Cendres')
const Ceremonie = () => import('./views/Ceremonie')
const Urne = () => import('./views/Urne')
const Souvenir = () => import('./views/Souvenir')
const Info = () => import('./views/Info')
const Recap = () => import('./views/Recap')

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
          nextPath: 'InfoAnimal',
          percent: 10
        } 
    },
    {
        path: '/informations-animal',
        name: 'InfoAnimal',
        component: InfoAnimal,
        meta: {
          backPath: 'Home',
          nextPath: 'Cendres',
          percent: 30
        }
    },
    {
        path: '/cendres',
        name: 'Cendres',
        component: Cendres,
        meta: {
          backPath: 'InfoAnimal',
          nextPath: 'Ceremonie',
          percent: 40
        }
    },
    {
        path: '/ceremonie',
        name: 'Ceremonie',
        component: Ceremonie,
        meta: {
          backPath: 'Cendres',
          nextPath: 'Urne',
          percent: 50
        }
    },
    {
        path: '/urne',
        name: 'Urne',
        component: Urne,
        meta: {
          backPath: 'Ceremonie',
          nextPath: 'Souvenir',
          percent: 70
        }
    },
    {
        path: '/geste-souvenir',
        name: 'Souvenir',
        component: Souvenir,
        meta: {
          backPath: 'Urne',
          nextPath: 'Info',
          percent: 80
        }
    },
    {
        path: '/informations',
        name: 'Info',
        component: Info,
        meta: {
          backPath: 'Souvenir',
          nextPath: 'Recap',
          percent: 90
        }
    },
    {
        path: '/recapitulatif',
        name: 'Recap',
        component: Recap,
        meta: {
          backPath: 'Info',
          nextPath: ''
        }
    },
  ],
});

export default router;