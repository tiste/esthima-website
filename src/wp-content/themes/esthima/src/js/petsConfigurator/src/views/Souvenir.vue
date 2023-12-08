<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--souvenir">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/geste-souvenir-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/geste-souvenir-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/geste-souvenir-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<form class="petsconfigurator__question__form">
				<span class="petsconfigurator__question__h1">
					Je souhaite ajouter un <br>“geste souvenir”
				</span>
				<a href="#" @click.prevent="peekaboo" class="petsconfigurator__peekaboo-link" :class="{'petsconfigurator__peekaboo-link--open': peekabooBool}">En savoir plus</a>
				<div v-show="peekabooBool" class="petsconfigurator__peekaboo-content">
					Lorem ipsum dolor sit amet consectetur. In aliquet ut neque faucibus et in. Nullam tristique vel dignissim phasellus dictum non maecenas ut. Enim nunc curabitur turpis mus molestie adipiscing.
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

				<div v-show="souvenir == true" class="petsconfigurator__souvenir-popup">
					<span class="petsconfigurator__souvenir-popup__quit" @click.prevent="closeGesteSouvenir"></span>
					<div class="petsconfigurator__souvenir-popup__content">
						<span class="petsconfigurator__question__h1">
							Je choisis mon <br>“geste souvenir”
						</span>
						<ul class="petsconfigurator__question__list-radio">
							<li>
								<input type="radio" id="gesteSouvenirTrue" value="empreinte" v-model="gesteSouvenir"/>
								<label for="gesteSouvenirTrue">
									<img :src="`${themeDirectoryUri}/images/configurateur/patte.svg`" alt="Empreinte">
								</label>
								<span>Empreinte</span>
							</li>
							<li>
								<input type="radio" id="gesteSouvenirFalse" value="touffe de poil" v-model="gesteSouvenir"/>
								<label for="gesteSouvenirFalse">
									<img :src="`${themeDirectoryUri}/images/configurateur/touffe.svg`" alt="touffe de poil">
								</label>
								<span>Touffe de poil</span>
							</li>
						</ul>
						<div class="input-errors" v-for="error of v$.gesteSouvenir.$errors" :key="error.$uid">
							<div class="error-msg">{{ error.$message }}</div>
						</div>
						<button @click.prevent="goNext" class="btn btn--arrow btn--arrow-disable-hover">Continuer</button>
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
		}
	})
	
    const gesteSouvenir = computed({
		get () {
			return store.state.petsConfigurator.gesteSouvenir
		},
		set (value) {
			store.commit('petsConfigurator/updateGesteSouvenir', value)
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

	const rules = {
		souvenir: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		},
		gesteSouvenir: {
			required: requiredIf(() => {
                helpers.withMessage('Veuillez choisir une option', required)
            })
		}
	}

	const v$ = useVuelidate(rules, {
		souvenir,
		gesteSouvenir
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
