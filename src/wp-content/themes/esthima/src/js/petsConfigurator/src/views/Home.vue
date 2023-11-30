<template>
	<div>
		<img src="/wp-content/themes/esthima/images/configurateur/configurateur-cadre-chien.png" alt="" />
		<h1>
			Lorem ipsum dolor sit amet consectetur. Volutpat pellentesque interdum
			dignissim.
		</h1>
		<p>
			Lorem ipsum dolor sit amet consectetur. Commodo felis enim mus placerat
			amet risus dapibus vestibulum in. Nunc et sed faucibus quam. Ornare
			adipiscing sit sed viverra ornare morbi risus lectus ultricies. Diam a
			laoreet magna a consectetur velit.
		</p>
		<button @click.prevent="goNext">Commencer</button>
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
	import { useRoute, useRouter } from 'vue-router'

	const router = useRouter()
	const route = useRoute()

	function goNext() {
		if (route.meta.nextPath) {
			router.push({ name: route.meta.nextPath })
		}
	}
</script>
