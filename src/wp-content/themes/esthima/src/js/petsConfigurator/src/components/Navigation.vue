<template>
	<nav class="petsconfigurator__navigation">
		<button @click.prevent="goPrev">Retour</button>
		<button @click.prevent="goNext">Continuer</button>
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
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();

function goPrev() {
	if (route.meta.backPath) {
		router.push({ name: route.meta.backPath })
	} else {
		router.back()
	}
}
function goNext() {
	if (route.meta.nextPath) {
		router.push({ name: route.meta.nextPath })
	}
}

</script>
