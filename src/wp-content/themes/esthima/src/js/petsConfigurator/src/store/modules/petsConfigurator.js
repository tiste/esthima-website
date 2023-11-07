import { getField, updateField } from 'vuex-map-fields'
import { request } from '../../helpers/request'
import { dataURLToBlob } from '../../helpers/dataURLToBlob'

const getDefaultState = () => {
	return {
	}
}

const state = getDefaultState()

// getters
const getters = {
	getField
}

// actions
const actions = {
}

// mutations
const mutations = {
	updateField
}


export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}