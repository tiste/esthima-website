<template>
	<nav class="petsconfigurator__navigation">
		<button @click.prevent="goPrev" class="btn btn--arrow">Retour</button>
		<button @click.prevent="goNext" class="btn btn--arrow">Continuer</button>
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
