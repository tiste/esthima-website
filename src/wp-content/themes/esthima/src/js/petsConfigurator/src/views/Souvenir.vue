<template>
	<div>
		Je souhaite ajouter un “geste souvenir”
        
        En savoir plus
        Lorem ipsum dolor sit amet consectetur. In aliquet ut neque faucibus et in. Nullam tristique vel dignissim phasellus dictum non maecenas ut. Enim nunc curabitur turpis mus molestie adipiscing.
		<ul>
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

        Je choisis mon geste souvenir
		<ul>
			<li>
				<input type="radio" id="gesteSouvenirTrue" value="empreinte" v-model="gesteSouvenir"/>
				<label for="gesteSouvenirTrue">Empreinte</label>
			</li>
			<li>
				<input type="radio" id="gesteSouvenirFalse" value="touffe de poil" v-model="gesteSouvenir"/>
				<label for="gesteSouvenirFalse">Touffe de poil</label>
			</li>
		</ul>
		<div class="input-errors" v-for="error of v$.gesteSouvenir.$errors" :key="error.$uid">
			<div class="error-msg">{{ error.$message }}</div>
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
	import { computed, onMounted, onUnmounted } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useVuelidate } from '@vuelidate/core'
	import { required, helpers, requiredIf } from '@vuelidate/validators'

	const store = useStore()

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
  		EventBus.on('goNextStep', validate);
	})
	onUnmounted(() => {
		EventBus.off('goNextStep', validate);
	})
		
</script>
