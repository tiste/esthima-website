<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--recap">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/recap-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/recap-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/recap-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<span class="petsconfigurator__question__h1">
				Mon offre personnalisée :
			</span>
			<ul>
				<li>Espèce : {{ store.state.petsConfigurator.typeAnimal}}</li>
				<li>Nom : {{ store.state.petsConfigurator.nameAnimal}}</li>
				<li>Récupération des cendres : {{ (store.state.petsConfigurator.cendre) ? 'Oui' : 'Non'}}</li>
				<li>Cérémonie d'adieu : {{ (store.state.petsConfigurator.ceremonieAdieu) ? 'Oui' : 'Non' }}</li>
				<li>Urne : {{ (store.state.petsConfigurator.urne) ? urneDetails : 'Non'}}</li>
				<li>Geste souvenir : {{ (store.state.petsConfigurator.souvenir) ? `Oui / ${store.state.petsConfigurator.gesteSouvenir}` : 'Non'}}</li>
			</ul>

			<span>
				Pour {{ store.state.petsConfigurator.nameAnimal }},<br>
				voici la prestation funéraire proposée :
			</span>

			<div v-if="cremationChoice == 'privee'">
				<span>La crémation<br><b>privée</b></span>
				<ul>
					<li>
						Prise en charge de l'animal décédé
					</li>
					<li>
						Recueillement auprès de votre animal dans le salon funéraire avant sa crémation
					</li>
					<li>
						Crémation individuelle
					</li>
					<li>
						Remise d'un certificat de crémation
					</li>
					<li>
						Restitution des cendres dans une urne de dispersion ou dans une urne décorative (en option).
					</li>
					<li>
						Remise de l'urne au crématorium, en agence Esthima ou en clinique vétérinaire
					</li>
				</ul>
			</div>
		
			<div v-else>
				<span>La crémation<br><b>référence</b></span>
				<ul>
					<li>
						Prise en charge de l'animal décédé
					</li>
					<li>
						Recueillement auprès de votre animal dans le salon funéraire avant sa crémation
					</li>
					<li>
						Crémation individuelle
					</li>
					<li>
						Remise d'un certificat de crémation
					</li>
				</ul>
			</div>
		</div> 

	</div>
</template>
<script>
export default {
	name: 'Recap',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted, onUnmounted, ref } from 'vue'
	import { useStore } from 'vuex'

	const store = useStore()

	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''
	
	const imgLoaded = ref(0)

		
	const typeAnimal = computed({
		get () {
			return store.state.petsConfigurator.typeAnimal
		}
	})

	const urneDetails = computed({
		get () {
			if (store.state.petsConfigurator.urne) {
				let n = store.state.petsConfigurator.urneProduct.name 
				if (store.state.petsConfigurator.urneProduct.type == 'variable') {
					let variations = Object.values(store.state.petsConfigurator.urneProduct.variation_selected.attributes).join(' , ')
					if (variations) {
						n = `${n} / (${variations})`
					}
				}
				return n
			} 
		}
	})

	const cremationChoice = computed({
		get () {
			return store.getters['petsConfigurator/cremationChoice']
		}
	})


	
	onMounted(() => {
		setTimeout(() => {
			imgLoaded.value = true
		}, 300)
	})
	onUnmounted(() => {
		imgLoaded.value = false
	})
</script>
