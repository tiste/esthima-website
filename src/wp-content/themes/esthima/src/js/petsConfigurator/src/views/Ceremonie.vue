<template>
	<div class="petsconfigurator__content">
		Je souhaite une cérémonie d’adieu
		<ul>
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
	import { computed, onMounted, onUnmounted } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useVuelidate } from '@vuelidate/core'
	import { required, helpers } from '@vuelidate/validators'

	const store = useStore()

	const ceremonieAdieu = computed({
		get () {
			return store.state.petsConfigurator.ceremonieAdieu
		},
		set (value) {
			store.commit('petsConfigurator/updateCeremonieAdieu', value)
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
  		EventBus.on('goNextStep', validate);
	})
	onUnmounted(() => {
		EventBus.off('goNextStep', validate);
	})
		
</script>
