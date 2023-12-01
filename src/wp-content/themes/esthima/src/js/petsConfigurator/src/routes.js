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
          nextPath: 'Ceremonie'
        }
    },
    {
        path: '/ceremonie',
        name: 'Ceremonie',
        component: Ceremonie,
        meta: {
          backPath: 'Cendres',
          nextPath: 'Urne'
        }
    },
    {
        path: '/urne',
        name: 'Urne',
        component: Urne,
        meta: {
          backPath: 'Ceremonie',
          nextPath: 'Souvenir'
        }
    },
    {
        path: '/geste-souvenir',
        name: 'Souvenir',
        component: Souvenir,
        meta: {
          backPath: 'Urne',
          nextPath: 'Info'
        }
    },
    {
        path: '/informations',
        name: 'Info',
        component: Info,
        meta: {
          backPath: 'Souvenir',
          nextPath: 'Recap'
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