const getDefaultState = () => {
	return {
		transitionName: '',
		typeAnimal: '',
		nameAnimal: '',
		cendre: '',
		ceremonieAdieu: '',
		urne: '',
		souvenir: '',
		gesteSouvenir: '',
		lastNameUser: '',
		firstNameUser: '',
		emailUser: '',
		popupOpen: false,
		productsUrnes: [],
	}
}

const state = getDefaultState()

// getters
const getters = {
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