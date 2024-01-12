const getDefaultState = () => {
	return {
		transitionName: '',
		typeAnimal: '',
		nameAnimal: '',
		cendre: '',
		ceremonieAdieu: '',
		urne: '',
		urneProduct: '',
		souvenir: '',
		gesteSouvenirEmpreinte: false,
		gesteSouvenirTouffe: false,
		lastNameUser: '',
		firstNameUser: '',
		emailUser: '',
		telUser: '',
		popupOpen: false,
		productsUrnes: [],
		cremationChoice: '',
		prixEmpreinte: 30,
		prixTouffe: 5,
		cremations: {
			"privee": {
				"nac": "239",
				"chien": "319",
				"chat": "319"
			},
			"reference": {
				"nac": "149",
				"chien": "229",
				"chat": "229"
			}
		}
	}
}

const state = getDefaultState()

// getters
const getters = {
	totalPrice(state, getters) {
		let price = 0

		//urne 
		if(state.urne && state.urneProduct) {
			if (state.urneProduct['type'] == "variation" && state.urneProduct.variation_selected) {
				price = parseFloat(price) + parseFloat(state.urneProduct.display_price.display_price)
			} else {
				price = parseFloat(price) + parseFloat(state.urneProduct.price)
			}
		}

		//geste souvenir
		if (state.souvenir) {
			if (state.gesteSouvenirEmpreinte) {
				price = parseFloat(price) + state.prixEmpreinte
			}
			if (state.gesteSouvenirTouffe) {
				price = parseFloat(price) + state.prixTouffe
			}
		}

		//ceremonie
		if (state.ceremonieAdieu !== '') {
			let cremationChoice = getters.cremationChoice
			price = parseFloat(price) + parseFloat(state.cremations[cremationChoice][state.typeAnimal])
		}

		return price
	},
	cremationChoice(state) {
		let cremationChoice = state.ceremonieAdieu ? 'privee' : 'reference'
		return cremationChoice
	},
	priceCremation(state, getters) {
		let cremationChoice = getters.cremationChoice
		return state.cremations[cremationChoice][state.typeAnimal]
	}
}

// actions
const actions = {
}

// mutations
const mutations = {
	updateTransitionName(state, value) {
		state.transitionName = value
	},
	updateTypeAnimal(state, value) {
		state.typeAnimal = value
	},
	updateNameAnimal(state, value) {
		state.nameAnimal = value
	},
	updateCendre(state, value) {
		state.cendre = value
	},
	updateCeremonieAdieu(state, value) {
		state.ceremonieAdieu = value
	},
	updateUrne(state, value) {
		state.urne = value
	},
	updateSouvenir(state, value) {
		state.souvenir = value
	},
	updateGesteSouvenirEmpreinte(state, value) {
		state.gesteSouvenirEmpreinte = value
	},
	updateGesteSouvenirTouffe(state, value) {
		state.gesteSouvenirTouffe = value
	},
	updateLastNameUser(state, value) {
		state.lastNameUser = value
	},
	updateFirstNameUser(state, value) {
		state.firstNameUser = value
	},
	updateEmailUser(state, value) {
		state.emailUser = value
	},
	updateTelUser(state, value) {
		state.telUser = value
	},
	updatePopupOpen(state, value) {
		state.popupOpen = value
	},
	updateProductsUrnes(state, value) {
		state.productsUrnes = value
	},
	updateUrneProduct(state, value) {
		state.urneProduct = value
	},
	resetState(state) {
		Object.assign(state, getDefaultState())
	}
}


export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}