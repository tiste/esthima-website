<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--ceremonie">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/ceremonie-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/ceremonie-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/ceremonie-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<form class="petsconfigurator__question__form">
				<span class="petsconfigurator__question__h1">
					Je souhaite une cérémonie d’adieu
				</span>
				<ul class="petsconfigurator__question__list-radio petsconfigurator__question__list-radio--bool">
					<li>
						<input type="radio" id="ceremonieAdieuTrue" :value="true" v-model="ceremonieAdieu"/>
						<label for="ceremonieAdieuTrue">Oui</label>
					</li>
					<li>
						<input type="radio" id="ceremonieAdieuFalse" :value="false" v-model="ceremonieAdieu"/>
						<label for="ceremonieAdieuFalse">Non</label>
					</li>
				</ul>
				<div class="input-errors" v-for="error of v$.ceremonieAdieu.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
				
			</form>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Ceremonie',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted, onUnmounted, ref } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useVuelidate } from '@vuelidate/core'
	import { required, helpers } from '@vuelidate/validators'

	const store = useStore()
	
	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''

	const imgLoaded = ref(0)

	const ceremonieAdieu = computed({
		get () {
			return store.state.petsConfigurator.ceremonieAdieu
		},
		set (value) {
			store.commit('petsConfigurator/updateCeremonieAdieu', value)
		}
	})

	const typeAnimal = computed({
		get () {
			return store.state.petsConfigurator.typeAnimal
		}
	})

	const rules = {
		ceremonieAdieu: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		}
	}

	const v$ = useVuelidate(rules, {
		ceremonieAdieu
	})


	const validate = async () => {
		const isFormCorrect = await v$.value.$validate();
      	if (!isFormCorrect) return false;
	}

	onMounted(() => {
  		EventBus.on('goNextStep', validate)
		setTimeout(() => {
			imgLoaded.value = true
		}, 300)
	})
	onUnmounted(() => {
		EventBus.off('goNextStep', validate)
		imgLoaded.value = false
	})
		
</script>
