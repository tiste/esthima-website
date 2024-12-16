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
		prixTouffe: 5.50,
		cremations: {
			"plurielle": {
				"nac": "75",
				"chien": "105",
				"chat": "105",
				"description": {
					"cremation": {
						"nac": "75",
						"chien": "105",
						"chat": "105",
					},
					"cendres": {
						"nac": "80",
						"chien": "130",
						"chat": "130",
					},
					"ceremonie": {
						"nac": "90",
						"chien": "90",
						"chat": "90",
					}
				}
			},
			"reference": {
				"nac": "160",
				"chien": "245",
				"chat": "245",
				"description": {
					"cremation": {
						"nac": "160",
						"chien": "245",
						"chat": "245",
					},
					"cendres": {
						"nac": "80",
						"chien": "130",
						"chat": "130",
					},
					"ceremonie": {
						"nac": "90",
						"chien": "90",
						"chat": "90",
					}
				}
			},
			"privee": {
				"nac": "255",
				"chien": "340",
				"chat": "340",
				"description": {
					"cremation": {
						"nac": "255",
						"chien": "340",
						"chat": "340",
					},
					"cendres": {
						"nac": "80",
						"chien": "130",
						"chat": "130",
					},
					"ceremonie": {
						"nac": "90",
						"chien": "90",
						"chat": "90",
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