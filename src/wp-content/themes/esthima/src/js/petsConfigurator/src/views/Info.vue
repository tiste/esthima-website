<template>
	<div>
        Vos informations :
		<input type="text" v-model="lastNameUser">
		<div class="input-errors" v-for="error of v$.lastNameUser.$errors" :key="error.$uid">
			<div class="error-msg">{{ error.$message }}</div>
        </div>
        <input type="text" v-model="firstNameUser">
        <div class="input-errors" v-for="error of v$.firstNameUser.$errors" :key="error.$uid">
			<div class="error-msg">{{ error.$message }}</div>
        </div>
        <input type="text" v-model="emailUser">
        <div class="input-errors" v-for="error of v$.emailUser.$errors" :key="error.$uid">
			<div class="error-msg">{{ error.$message }}</div>
        </div>
	</div>
</template>

<script>
export default {
	name: 'Info',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted, onUnmounted } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useRouter } from 'vue-router'
	import { useVuelidate } from '@vuelidate/core'
	import { required, email, helpers } from '@vuelidate/validators'

	const store = useStore()
	
	const router = useRouter()

	const lastNameUser = computed({
		get () {
			return store.state.petsConfigurator.lastNameUser
		},
		set (value) {
			store.commit('petsConfigurator/updateLastNameUser', value)
		}
	})
	
    const firstNameUser = computed({
		get () {
			return store.state.petsConfigurator.firstNameUser
		},
		set (value) {
			store.commit('petsConfigurator/updateFirstNameUser', value)
		}
	})
   
    const emailUser = computed({
		get () {
			return store.state.petsConfigurator.emailUser
		},
		set (value) {
			store.commit('petsConfigurator/updateEmailUser', value)
		}
	})

	const rules = {
		lastNameUser: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		},
		firstNameUser: { 
			required: helpers.withMessage('Veuillez remplir ce champ', required)
		},
		emailUser: { 
			required: helpers.withMessage('Veuillez remplir ce champ', required),
			email: helpers.withMessage("L'email est incorrect", email)
		}
	}

	const v$ = useVuelidate(rules, {
		lastNameUser,
		firstNameUser,
		emailUser
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