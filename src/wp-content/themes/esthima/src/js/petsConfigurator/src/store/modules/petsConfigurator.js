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
		gesteSouvenir: '',
		lastNameUser: '',
		firstNameUser: '',
		emailUser: '',
		popupOpen: false,
		productsUrnes: [],
		cremationChoice: '',
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
	totalPrice(state) {
		let price = 0

		//urne 
		if(state.urne && state.urneProduct) {
			if (state.urneProduct['type'] == "variation" && state.urneProduct.variation_selected) {
				price = eval(price + state.urneProduct.display_price.display_price)
			} else {
				price = eval(price + state.urneProduct.price)
			}
		}

		//geste souvenir
		if (state.souvenir) {
			if (state.gesteSouvenir == "empreinte") {
				// price = price + prixEmpreinte
			} else {
				// price = price + prixTouffe
			}
			price = price + 20
		}
		//ceremonie
		if (state.ceremonieAdieu) {
			if (state.cremationChoice) {
				price = eval(price + state.cremations[state.cremationChoice][state.typeAnimal])
			}
		}

		return price
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
	updateGesteSouvenir(state, value) {
		state.gesteSouvenir = value
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