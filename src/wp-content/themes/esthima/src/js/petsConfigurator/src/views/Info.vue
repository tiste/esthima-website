<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--info">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/info-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/info-chat.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/info-nac.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<form class="petsconfigurator__question__form">
				<span class="petsconfigurator__question__h1">
					Vos informations :
				</span>
				<div class="input-text">
					<input type="text" id="lastNameUser" v-model="lastNameUser" placeholder=" ">
					<label for="lastNameUser">Nom<i style="color:red;">*</i></label>
				</div>
				<div class="input-errors" v-for="error of v$.lastNameUser.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
				<div class="input-text">
					<input type="text" id="lastNameUser" v-model="firstNameUser" placeholder=" ">
					<label for="lastNameUser">Prénom<i style="color:red;">*</i></label>
				</div>
				<div class="input-errors" v-for="error of v$.firstNameUser.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
				<div class="input-text">
					<input type="text" id="emailUser" v-model="emailUser" placeholder=" ">
					<label for="emailUser">Email<i style="color:red;">*</i></label>
				</div>
				<div class="input-errors" v-for="error of v$.emailUser.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
				<div class="input-text">
					<input type="text" id="telUser" v-model="telUser" placeholder=" ">
					<label for="telUser">Numéro de téléphone<i style="color:red;">*</i></label>
				</div>
				<div class="input-errors" v-for="error of v$.telUser.$errors" :key="error.$uid">
					<div class="error-msg" v-if="error.$message != ''">{{ error.$message }}</div>
					<div class="error-msg" v-else>{{ error.$params.message }}</div>
				</div>
			</form>
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
	import { computed, onMounted, onUnmounted, ref } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useVuelidate } from '@vuelidate/core'
	import { required, email, helpers } from '@vuelidate/validators'

	const store = useStore()

	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''
	
	const imgLoaded = ref(0)

	const isFrenchPhoneNumber = helpers.withParams(
		{ type: 'isFrenchPhoneNumber', message: 'Numéro de téléphone invalide' },
		value => /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/gmi.test(value)
	)

	
	const typeAnimal = computed({
		get () {
			return store.state.petsConfigurator.typeAnimal
		}
	})

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
   
	const telUser = computed({
		get () {
			return store.state.petsConfigurator.telUser
		},
		set (value) {
			store.commit('petsConfigurator/updateTelUser', value)
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
		},
		telUser: { 
			required: helpers.withMessage('Veuillez remplir ce champ', required),
			isFrenchPhoneNumber
		}
	}

	const v$ = useVuelidate(rules, {
		lastNameUser,
		firstNameUser,
		emailUser,
		telUser
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