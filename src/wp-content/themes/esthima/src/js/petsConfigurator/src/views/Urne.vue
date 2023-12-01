<template>
	<div>
		Je souhaite ajouter une urne décorative
		<ul>
			<li>
				<input type="radio" id="urneTrue" :value="true" v-model="urne"/>
				<label for="urneTrue">Oui</label>
			</li>
			<li>
				<input type="radio" id="urneFalse" :value="false" v-model="urne"/>
				<label for="urneFalse">Non</label>
			</li>
		</ul>
		<div class="input-errors" v-for="error of v$.urne.$errors" :key="error.$uid">
			<div class="error-msg">{{ error.$message }}</div>
  		</div>
	</div>
</template>

<script>
export default {
	name: 'Urne',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted, onUnmounted } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useVuelidate } from '@vuelidate/core'
	import { required, helpers } from '@vuelidate/validators'

	const store = useStore()

	const urne = computed({
		get () {
			return store.state.petsConfigurator.urne
		},
		set (value) {
			store.commit('petsConfigurator/updateUrne', value)
		}
	})

	const rules = {
		urne: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		}
	}

	const v$ = useVuelidate(rules, {
		urne
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
