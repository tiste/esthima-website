import { createStore } from 'vuex'
import petsConfigurator from './modules/petsConfigurator'
import VuexPersistence from 'vuex-persist'
import Cookie from 'js-cookie'


const debug = process.env.NODE_ENV !== 'production'

const cookieName = 'petsConfigurator' 

const vuexCookie = new VuexPersistence({
	key: cookieName,
	storage: window.localStorage
	// restoreState: (key, storage) => Cookie.getJSON(key),
	// saveState: (key, state, storage) => Cookie.set(key, state, {
	// 	expires: 3
	// })
})

export default createStore({
	modules: {
	  petsConfigurator
	},
	devtools: false,
	plugins: [vuexCookie.plugin]
})