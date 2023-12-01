<template>
	<div>
		Je souhaite récupérer les cendres de {{nameAnimal}}
		<ul>
			<li>
				<input type="radio" id="cendreTrue" :value="true" v-model="cendre"/>
				<label for="cendreTrue">Oui</label>
			</li>
			<li>
				<input type="radio" id="cendreFalse" :value="false" v-model="cendre"/>
				<label for="cendreFalse">Non</label>
			</li>
		</ul>
		<div class="input-errors" v-for="error of v$.cendre.$errors" :key="error.$uid">
			<div class="error-msg">{{ error.$message }}</div>
  		</div>
	</div>
</template>

<script>
export default {
	name: 'Cendres',
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
	
	const cendre = computed({
		get () {
			return store.state.petsConfigurator.cendre
		},
		set (value) {
			store.commit('petsConfigurator/updateCendre', value)
		}
	})
	
	const nameAnimal = computed({
		get () {
			return store.state.petsConfigurator.nameAnimal
		}
	})


	const rules = {
		cendre: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		}
	}

	const v$ = useVuelidate(rules, {
		cendre
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
