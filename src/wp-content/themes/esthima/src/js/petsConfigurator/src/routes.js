import { createRouter, createWebHashHistory } from "vue-router";
import store from "./store/index";

import Home from './views/Home';
import InfoAnimal from './views/InfoAnimal';
import Cendres from './views/Cendres';
import Ceremonie from './views/Ceremonie';
import Urne from './views/Urne';
import Souvenir from './views/Souvenir';
import Info from './views/Info';
import Recap from './views/Recap';

// const Home = () => import('./views/Home')
// const InfoAnimal = () => import('./views/InfoAnimal')
// const Cendres = () => import('./views/Cendres')
// const Ceremonie = () => import('./views/Ceremonie')
// const Urne = () => import('./views/Urne')
// const Souvenir = () => import('./views/Souvenir')
// const Info = () => import('./views/Info')
// const Recap = () => import('./views/Recap')

// Création du router
const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
          nextPath: 'InfoAnimal',
          percent: 10,
          step: 0
        }
    },
    {
        path: '/informations-animal',
        name: 'InfoAnimal',
        component: InfoAnimal,
        meta: {
          backPath: 'Home',
          nextPath: 'Cendres',
          percent: 30,
          step: 1
        }
    },
    {
        path: '/cendres',
        name: 'Cendres',
        component: Cendres,
        meta: {
          backPath: 'InfoAnimal',
          nextPath: 'Ceremonie',
          percent: 40,
          step: 2
        }
    },
    {
        path: '/ceremonie',
        name: 'Ceremonie',
        component: Ceremonie,
        meta: {
          backPath: 'Cendres',
          nextPath: 'Urne',
          percent: 50,
          step: 3
        }
    },
    {
        path: '/urne',
        name: 'Urne',
        component: Urne,
        meta: {
          backPath: 'Ceremonie',
          nextPath: 'Souvenir',
          percent: 70,
          step: 4
        }
    },
    {
        path: '/geste-souvenir',
        name: 'Souvenir',
        component: Souvenir,
        meta: {
          backPath: 'Urne',
          nextPath: 'Info',
          percent: 80,
          step: 5
        },
    },
    {
        path: '/informations',
        name: 'Info',
        component: Info,
        meta: {
          backPath: 'Souvenir',
          nextPath: 'Recap',
          percent: 90,
          step: 6
        }
    },
    {
        path: '/recapitulatif',
        name: 'Recap',
        component: Recap,
        meta: {
          backPath: 'Info',
          nextPath: '',
          percent: 0,
          step: 7
        }
    },
  ],
});

router.beforeEach((to, from) => {
  console.log(`Navigating from ${from.name} to ${to.name}`)
  console.log('Current cendre state:', store.state.petsConfigurator.cendre)

  if (to.name === 'Recap') {
	console.log('Entering Recap route')
  }

  console.log(to.name)
  console.log(["Ceremonie", "Urne"].indexOf(to.name))
  console.log(store.getters.cremationChoice)
  console.log(store.state.petsConfigurator.cendre == false   )
  if (["Ceremonie", "Urne"].indexOf(to.name) !== -1 ) {
    if (store.state.petsConfigurator.cendre == false) {
      if (from.name == "Cendres") {
        return { name: 'Info' }
      } else {
        //plurielle so push souvenir
        if (from.name == "Souvenir") {
          return { name: 'Cendres' }
        } else {
          return { name: 'Souvenir' }
        }
      }
    }
  }

  // Si l'options Cendre est sur false, sur la page info si on fait retour sa ramene au step cendres
  if (to.name === "Souvenir" && from.name === "Info") {
    if (store.state.petsConfigurator.cendre == false) {
      if (from.name == "Info") {
        return { name: 'Cendres' };
      }
    }
  }

})

router.afterEach((to, from) => {
  if (from.name != "" && from.name !== undefined && from.name != "Home" && to.name != "Recap") {
    window.dataLayer.push({
      'event': 'clickConfigurateur',
      'eventCategory': 'Configurateur',
      'eventAction' : 'Step ' + from.meta.step,
      'eventLabel': 'Submit'
    });
  } else if (from.name == "Home") {
      window.dataLayer.push({
        'event': 'clickConfigurateur',
        'eventCategory': 'Configurateur',
        'eventAction' : 'Initialisation',
        'eventLabel': ''
      });
  } else if (to.name == "Recap") {
      // window.dataLayer.push({
      //   'event': 'confirmationConfigurateur',
      //   'eventCategory': 'Configurateur',
      //   'eventAction' : 'Page de confirmation',
      //   'eventLabel': ''
      // });
      window.dataLayer.push({
        'event': 'clickConfigurateur',
        'eventCategory': 'Configurateur',
        'eventAction' : 'Final Step',
        'eventLabel': 'Submit'
      });
  }
})

export default router;
