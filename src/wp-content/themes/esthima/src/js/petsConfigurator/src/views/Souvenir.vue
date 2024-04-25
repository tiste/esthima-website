<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--souvenir">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/geste-souvenir-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/geste-souvenir-chat.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/geste-souvenir-nac.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<form class="petsconfigurator__question__form">
				<span class="petsconfigurator__question__h1-sup">
					Pour ne jamais l’oublier
				</span>
				<span class="petsconfigurator__question__h1">
					Je souhaite ajouter un <br>“geste souvenir”
				</span>
				<a href="#" @click.prevent="peekaboo" class="petsconfigurator__peekaboo-link" :class="{'petsconfigurator__peekaboo-link--open': peekabooBool}">En savoir plus</a>
				<div v-show="peekabooBool" class="petsconfigurator__peekaboo-content">
					Pour garder une douce présence de votre animal auprès de vous, il vous est possible de conserver une empreinte de la patte ou une mèche de poils de votre animal en souvenir.
				</div>
				<ul class="petsconfigurator__question__list-radio petsconfigurator__question__list-radio--bool">
					<li>
						<input type="radio" id="souvenirTrue" :value="true" v-model="souvenir"/>
						<label for="souvenirTrue">Oui</label>
					</li>
					<li>
						<input type="radio" id="souvenirFalse" :value="false" v-model="souvenir"/>
						<label for="souvenirFalse">Non</label>
					</li>
				</ul>
				<div class="input-errors" v-for="error of v$.souvenir.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
  				</div>

				<div class="petsconfigurator__souvenir-popup" :class="{'petsconfigurator__souvenir-popup--open' : souvenir}">
					<span class="petsconfigurator__souvenir-popup__quit" @click.prevent="closeGesteSouvenir"></span>
					<div class="petsconfigurator__souvenir-popup__content">
						<span class="petsconfigurator__question__h1">
							Je choisis mon <br>“geste souvenir”
						</span>
						<ul class="petsconfigurator__question__list-radio">
							<li>
								<input type="checkbox" id="gesteSouvenirEmpreinte" :value="true" v-model="gesteSouvenirEmpreinte"/>
								<label for="gesteSouvenirEmpreinte">
									<img :src="`${themeDirectoryUri}/images/configurateur/patte.svg`" alt="Empreinte">
								</label>
								<span>Empreinte en argile</span>
							</li>
							<li>
								<input type="checkbox" id="gesteSouvenirTouffe" :value="true" v-model="gesteSouvenirTouffe"/>
								<label for="gesteSouvenirTouffe">
									<img :src="`${themeDirectoryUri}/images/configurateur/touffe.svg`" alt="touffe de poil">
								</label>
								<span>Coupe de poil</span>
							</li>
						</ul>
						<div class="input-errors" v-if="(v$.gesteSouvenirEmpreinte.$invalid || v$.gesteSouvenirTouffe.$invalid) && v$.$dirty">
							<div class="error-msg petsconfigurator-h-center">Veuillez choisir une option</div>
						</div>
						<button @click.prevent="goNextPage" class="btn btn--arrow btn--arrow-disable-hover">Continuer</button>
					</div>
				</div>
				
			</form>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Souvenir',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted, onUnmounted, ref } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useVuelidate } from '@vuelidate/core'
	import { required, helpers, requiredIf } from '@vuelidate/validators'
	import { goNext } from '../helpers/Navigate';


	const store = useStore()

	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''

	const imgLoaded = ref(0)
	
	const peekabooBool = ref(0)

	const souvenir = computed({
		get () {
			return store.state.petsConfigurator.souvenir
		},
		set (value) {
			store.commit('petsConfigurator/updateSouvenir', value)
			store.commit('petsConfigurator/updatePopupOpen', value)
		}
	})
	
    const gesteSouvenirEmpreinte = computed({
		get () {
			return store.state.petsConfigurator.gesteSouvenirEmpreinte
		},
		set (value) {
			store.commit('petsConfigurator/updateGesteSouvenirEmpreinte', value)
		}
	})

	const gesteSouvenirTouffe = computed({
		get () {
			return store.state.petsConfigurator.gesteSouvenirTouffe
		},
		set (value) {
			store.commit('petsConfigurator/updateGesteSouvenirTouffe', value)
		}
	})

	const typeAnimal = computed({
		get () {
			return store.state.petsConfigurator.typeAnimal
		}
	})



	const peekaboo = () => {
		peekabooBool.value = !peekabooBool.value
	}
	
	const closeGesteSouvenir = () => {
		souvenir.value = false
	}

	const gesteSouvenirIsSelected = (value) => {
		if (souvenir.value && !gesteSouvenirEmpreinte.value && !gesteSouvenirTouffe.value) {
			//invalide
			return false
		} 
		//valide
		return true
	}

	

	const rules = {
		souvenir: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		},
		gesteSouvenirEmpreinte: {
			gesteSouvenirIsSelected
		},
		gesteSouvenirTouffe: {
			gesteSouvenirIsSelected
		}
	}

	const v$ = useVuelidate(rules, {	
		souvenir,
		gesteSouvenirEmpreinte,
		gesteSouvenirTouffe,
	})


	const goNextPage = async () => {
		let isValid = await validate()
		if (isValid !== false) {
			store.commit('petsConfigurator/updatePopupOpen', false)
			goNext()
		}
	}

	const validate = async () => {
		const isFormCorrect = await v$.value.$validate();
      	if (!isFormCorrect) return false;
	}

	onMounted(() => {
		if (souvenir.value) {
			store.commit('petsConfigurator/updatePopupOpen', true)
		} else {
			store.commit('petsConfigurator/updatePopupOpen', false)
		}
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
