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
		prixEmpreinte: 34,
		prixTouffe: 5.50,
		cremations: {
			"plurielle": {
				"nac": "80",
				"chien": "110",
				"chat": "110",
				"description": {
					"cremation": {
						"nac": "80",
						"chien": "110",
						"chat": "110",
					},
					"cendres": {
						"nac": "87",
						"chien": "147",
						"chat": "147",
					},
					"ceremonie": {
						"nac": "100",
						"chien": "100",
						"chat": "100",
					}
				}
			},
			"reference": {
				"nac": "167",
				"chien": "257",
				"chat": "257",
				"description": {
					"cremation": {
						"nac": "167",
						"chien": "257",
						"chat": "257",
					},
					"cendres": {
						"nac": "87",
						"chien": "147",
						"chat": "147",
					},
					"ceremonie": {
						"nac": "100",
						"chien": "100",
						"chat": "100",
					}
				}
			},
			"privee": {
				"nac": "267",
				"chien": "357",
				"chat": "357",
				"description": {
					"cremation": {
						"nac": "267",
						"chien": "357",
						"chat": "357",
					},
					"cendres": {
						"nac": "87",
						"chien": "147",
						"chat": "147",
					},
					"ceremonie": {
						"nac": "100",
						"chien": "100",
						"chat": "100",
					}
				}
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
	getSouvenirPrice(state) {
		let price = 0
		//geste souvenir
		if (state.souvenir) {
			if (state.gesteSouvenirEmpreinte) {
				price = parseFloat(price) + state.prixEmpreinte
			}
			if (state.gesteSouvenirTouffe) {
				price = parseFloat(price) + state.prixTouffe
			}
		}

		return price
	},
	getUrnePrice(state) {
		let price = 0

		//urne 
		if(state.urne && state.urneProduct) {
			if (state.urneProduct['type'] == "variation" && state.urneProduct.variation_selected) {
				price = parseFloat(price) + parseFloat(state.urneProduct.display_price.display_price)
			} else {
				price = parseFloat(price) + parseFloat(state.urneProduct.price)
			}
		}
		return price
	},
	cremationChoice(state) {
		//plurielle
		// state.ceremonieAdieu false
		// state.cendre false
		
		//reference
		// state.ceremonieAdieu false
		// state.cendre true

		//privee
		// state.ceremonieAdieu true
		// state.cendre true

		let cremationChoice = ''
		
		if (state.ceremonieAdieu == true && state.cendre == true) {
			cremationChoice = 'privee';
		} else if ((state.ceremonieAdieu == false || state.ceremonieAdieu == '') && state.cendre == true) {
			cremationChoice = 'reference';
		} else if (state.ceremonieAdieu == false && state.cendre == false) {
			cremationChoice = 'plurielle';
		} else {
			cremationChoice = 'plurielle';
		}
	
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