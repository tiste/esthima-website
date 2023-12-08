import EventBus from '../EventBus';
import { computed } from 'vue'
import store from '../store/index';
import router from "../routes";

const transitionName = computed({
	get () {
		return store.state.petsConfigurator.transitionName
	},
	set (value) {
		store.commit('petsConfigurator/updateTransitionName', value)
	}
})

export function goPrev() {
	transitionName.value = 'slide-right'
	if (router.currentRoute.value.meta.backPath) {
		router.push({ name: router.currentRoute.value.meta.backPath })
	} else {
		router.back()
	}
}

export async function goNext() {
	transitionName.value = 'slide-left'
	if (router.currentRoute.value.meta.nextPath) {
		const results = await EventBus.emit('goNextStep');
		const shouldProceed = !results.includes(false);
		if (shouldProceed) {
    		router.push({ name: router.currentRoute.value.meta.nextPath });
  		}
	}
}
