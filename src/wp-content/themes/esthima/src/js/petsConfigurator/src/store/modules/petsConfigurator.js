// import { getField, updateField } from 'vuex-map-fields'
// import { request } from '../../helpers/request'
// import { dataURLToBlob } from '../../helpers/dataURLToBlob'

const getDefaultState = () => {
	return {
		typeAnimal: '',
		nameAnimal: ''
	}
}

const state = getDefaultState()

// getters
const getters = {
	// getField
}

// actions
const actions = {
}

// mutations
const mutations = {
	// updateField
	updateTypeAnimal(state, value) {
		state.typeAnimal = value
	},
	updateNameAnimal(state, value) {
		state.nameAnimal = value
	},
}


export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}