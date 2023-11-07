import Home from './views/Home'
import InfoAnimal from './views/InfoAnimal'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/informations-animal',
        name: 'InfoAnimal',
        component: InfoAnimal
    },
];

export default routes;
