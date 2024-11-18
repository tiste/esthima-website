<template>
	<div class="petsconfigurator__content petsconfigurator__content--home">
		<div class="petsconfigurator__content__inner">
			<h1 class="petsconfigurator__h1 petsconfigurator-h-center">
				Personnalisez* les obsèques de votre animal
			</h1>
			<p class="petsconfigurator__p petsconfigurator-h-center">
				Parce que votre histoire est unique, rendez hommage à votre animal selon vos souhaits.
			</p>
			<button @click.prevent="goNext" class="btn btn--arrow petsconfigurator-h-center">Commencer</button>
		</div>
	</div>
	<div class="petsconfigurator__footnotes">
		*: A l’issue de la simulation, le coût des obsèques est donné à titre indicatif. Cette simulation n'a pas de valeur contractuelle.
	</div>
</template>

<script>
export default {
	name: 'Home',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted } from 'vue'
	import { useRoute, useRouter } from 'vue-router'
	import { useStore } from 'vuex'

	const router = useRouter()
	const route = useRoute()
	const store = useStore()


	let transitionName = computed({
		get () {
			return store.state.petsConfigurator.transitionName
		},
		set (value) {
			store.commit('petsConfigurator/updateTransitionName', value)
		}
	})

	function goNext() {
		transitionName.value = 'slide-left'
		if (route.meta.nextPath) {
			// window.dataLayer.push({
			// 	'event': 'clickConfigurateur',
			// 	'eventCategory': 'Configurateur',
			// 	'eventAction' : 'Initialisation',
			// 	'eventLabel': ''
			// });
			router.push({ name: route.meta.nextPath })
		}
	}

	onMounted(() => {
		store.commit('petsConfigurator/resetState')
	})
</script>
