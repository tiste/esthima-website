<template>
	<nav class="petsconfigurator__navigation">
		<div class="petsconfigurator__navigation__content">
			<button @click.prevent="goPrev" class="btn btn--arrow btn--arrow-reverse btn--arrow-disable-hover petsconfigurator__navigation__button-desk">Retour</button>
			<ProgressBar :value="percentBar" />
			<div class="petsconfigurator__navigation__price">
				<span>Total : <b>82,5€</b></span>
			</div>
			<div class="petsconfigurator__navigation__buttons">
				<button @click.prevent="goPrev" class="btn btn--arrow btn--arrow-reverse btn--arrow-disable-hover ">Retour</button>
				<button @click.prevent="goNext" class="btn btn--arrow btn--arrow-disable-hover">Continuer</button>
			</div>
			<button @click.prevent="goNext" class="btn btn--arrow btn--arrow-disable-hover petsconfigurator__navigation__button-desk">Continuer</button>
		</div>
    </nav>
</template>

<script>
export default {
	name: 'Navigation',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router';
import EventBus from '../EventBus';
import { useStore } from 'vuex'
import ProgressBar from './ProgressBar'

const router = useRouter();
const route = useRoute();
const store = useStore()


let transitionName = computed({
	get () {
		return store.state.petsConfigurator.transitionName
	},
	set (value) {
		store.commit('petsConfigurator/updateTransitionName', value)
	}
})
let percentBar = computed({
	get () {
		if (route.meta.percent) {
		 	return route.meta.percent
		} else {
			return 10
		}
	}
})


function goPrev() {
	transitionName.value = 'slide-right'
	if (route.meta.backPath) {
		router.push({ name: route.meta.backPath })
	} else {
		router.back()
	}
}

async function goNext() {
	transitionName.value = 'slide-left'
	if (route.meta.nextPath) {
		const results = await EventBus.emit('goNextStep');
		const shouldProceed = !results.includes(false);
		if (shouldProceed) {
    		router.push({ name: route.meta.nextPath });
  		}
	}
}

</script>
