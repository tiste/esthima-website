<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--info-animal">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img :src="`${themeDirectoryUri}/images/configurateur/chat-chien-nac.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<form class="petsconfigurator__question__form">
				<span class="petsconfigurator__question__h1">
					Mon animal est...
				</span>
				<ul class="petsconfigurator__question__list-radio">
					<li>
						<input type="radio" id="chien" value="chien" v-model="typeAnimal"/>
						<label for="chien">Un chien</label>
					</li>
					<li>
						<input type="radio" id="chat" value="chat" v-model="typeAnimal"/>
						<label for="chat">Un chat</label>
					</li>
					<li>
						<input type="radio" id="nac" value="nac" v-model="typeAnimal"/>
						<label for="nac">Un NAC</label>
					</li>
				</ul>
				<div class="input-errors" v-for="error of v$.typeAnimal.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
				<span class="petsconfigurator__question__h1">
					Il s’appelle...
				</span>
				<div class="input-text">
					<input type="text" id="nameAnimal" v-model="nameAnimal" placeholder=" ">
					<label for="nameAnimal">Nom<i style="color:red;">*</i></label>
				</div>
				<div class="input-errors" v-for="error of v$.nameAnimal.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
export default {
	name: 'InfoAnimal',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted, onUnmounted, ref } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useRouter } from 'vue-router'
	import { useVuelidate } from '@vuelidate/core'
	import { required, helpers } from '@vuelidate/validators'

	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''

	const store = useStore()
	
	const router = useRouter()

	const imgLoaded = ref(0)

	const typeAnimal = computed({
		get () {
			return store.state.petsConfigurator.typeAnimal
		},
		set (value) {
			store.commit('petsConfigurator/updateTypeAnimal', value)
		}
	})

	const nameAnimal = computed({
		get () {
			return store.state.petsConfigurator.nameAnimal
		},
		set (value) {
			store.commit('petsConfigurator/updateNameAnimal', value)
		}
	})

	const rules = {
		typeAnimal: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		},
		nameAnimal: { 
			required: helpers.withMessage('Veuillez remplir ce champ', required)
		}
	}

	const v$ = useVuelidate(rules, {
		typeAnimal,
		nameAnimal
	})


	const validate = async () => {
		const isFormCorrect = await v$.value.$validate();
      	if (!isFormCorrect) return false;
	}


	onMounted(() => {
  		EventBus.on('goNextStep', validate);
		setTimeout(() => {
			imgLoaded.value = true
		}, 300)
	})
	onUnmounted(() => {
		EventBus.off('goNextStep', validate);
		imgLoaded.value = false
	})
	
		
</script>