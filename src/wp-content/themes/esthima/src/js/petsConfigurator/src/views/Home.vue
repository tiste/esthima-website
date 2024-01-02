<template>
	<div class="petsconfigurator__content petsconfigurator__content--home">
		<div class="petsconfigurator__content__inner">
			<h1 class="petsconfigurator__h1 petsconfigurator-h-center">
				Lorem ipsum dolor sit amet consectetur.
			</h1>
			<p class="petsconfigurator__p petsconfigurator-h-center">
				Lorem ipsum dolor sit amet consectetur. Commodo felis enim mus placerat amet risus dapibus vestibulum in. Nunc et sed faucibus quam.
			</p>
			<button @click.prevent="goNext" class="btn btn--arrow petsconfigurator-h-center">Commencer</button>
		</div>
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
			router.push({ name: route.meta.nextPath })
		}
	}

	onMounted(() => {
		store.commit('petsConfigurator/resetState')
	})
</script>
