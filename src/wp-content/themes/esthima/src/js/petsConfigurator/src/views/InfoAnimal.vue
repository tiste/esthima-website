<template>
	<div>
		Mon animal est...
		<ul>
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

		Il s’appelle...
		<input type="text" v-model="nameAnimal">
		<div class="input-errors" v-for="error of v$.nameAnimal.$errors" :key="error.$uid">
			<div class="error-msg">{{ error.$message }}</div>
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
	import { computed, onMounted, onUnmounted } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useRouter } from 'vue-router'
	import { useVuelidate } from '@vuelidate/core'
	import { required } from '@vuelidate/validators'

	const store = useStore()
	
	const router = useRouter()

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
		typeAnimal: { required },
		nameAnimal: { required }
	}

	const v$ = useVuelidate(rules, {
		typeAnimal,
		nameAnimal
	})


	const validate = async () => {
		const isFormCorrect = await v$.value.$validate();
		console.log(isFormCorrect)
      	if (!isFormCorrect) return false;
	}

	onMounted(() => {
  		EventBus.on('goNextStep', validate);
	})
	onUnmounted(() => {
		EventBus.off('goNextStep', validate);
	})
		
	// router.beforeEach((to, from) => {
	// 	if (
	// 		from.name == 'InfoAnimal' &&
	// 		to.name == from.meta.nextPath
	// 	) {
	// 		alert('aaa')
	// 		console.log(this.v$.$validate())
	// 		return false
	// 	}
	// })


</script>