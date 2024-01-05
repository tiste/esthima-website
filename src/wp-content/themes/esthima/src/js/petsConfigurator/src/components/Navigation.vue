<template>
	<nav class="petsconfigurator__navigation">
		<div class="petsconfigurator__navigation__content">
			<button @click.prevent="goPrev" class="btn btn--arrow btn--arrow-reverse btn--arrow-disable-hover petsconfigurator__navigation__button-desk">Retour</button>
			<ProgressBar :value="percentBar" />
			<div class="petsconfigurator__navigation__price">
				<span>Total : <b>{{totalPrice}}€</b></span>
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
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import { goPrev, goNext } from '../helpers/Navigate';
import ProgressBar from './ProgressBar'

const route = useRoute()

const store = useStore()

let percentBar = computed({
	get () {
		if (route.meta.percent) {
		 	return route.meta.percent
		} else {
			return 10
		}
	}
})

const totalPrice = computed({
	get () {
		return store.getters['petsConfigurator/totalPrice']
	}
})

</script>
