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

		Il s’appelle...
		<input type="text" v-model="nameAnimal">

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
	import { computed, ref } from 'vue'
	import { useStore } from 'vuex'

	const store = useStore()

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

</script>