<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--recap">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/recap-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/recap-chat.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/recap-nac.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<div class="petsconfigurator__question__form">

				<span class="petsconfigurator__question__h1">
					Mon offre personnalisée :
				</span>
				<ul class="petsconfigurator__question__list">
					<li>Espèce : <span>{{ store.state.petsConfigurator.typeAnimal}}</span></li>
					<li>Nom : <span>{{ store.state.petsConfigurator.nameAnimal}}</span></li>
					<li v-if="store.state.petsConfigurator.cendre">Prix de la crémation avec récupération des cendres : <span>{{ yesCendre }}</span></li>
					<li v-else>Prix de la crémation sans récupération des cendres : <span>{{ noCendre }}</span></li>
					<li v-if="store.state.petsConfigurator.ceremonieAdieu">Cérémonie d'adieu : <span>Oui <small v-html="yesCeremonie"></small></span></li>
					<li v-else>Cérémonie d'adieu : <span>Non</span></li>
					<li v-if="store.state.petsConfigurator.urne">Urne : <span>{{urneDetails}} <small v-html="detailYesUrnes"></small></span></li>
					<li v-else>Urne : <span>Non</span></li>
					<li v-if="store.state.petsConfigurator.souvenir">Geste souvenir : <span v-html="souvenirDetails"></span></li>
					<li v-else>Geste souvenir : <span>Non</span></li>
				</ul>

				<span class="petsconfigurator__question__subtitle">
					Pour {{ store.state.petsConfigurator.nameAnimal }},<br>
					voici la prestation funéraire proposée&nbsp;:
				</span>

				<div v-if="cremationChoice == 'privee'" class="petsconfigurator__question__cremation">
					<div class="petsconfigurator__question__cremation__title">
						<div class="petsconfigurator__question__cremation__title__image">
							<img :src="`${themeDirectoryUri}/images/configurateur/fleur.svg`" alt="">
						</div>
						<div>
							<span class="petsconfigurator__question__cremation__title__one">La crémation</span><br>
							<span class="petsconfigurator__question__cremation__title__two">privée</span>
						</div>
					</div>
					<ul class="petsconfigurator__question__cremation__list">
						<li>
							Prise en charge de l'animal décédé
						</li>
						<li v-if="store.state.petsConfigurator.ceremonieAdieu">
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

				<div v-else-if="cremationChoice == 'reference'" class="petsconfigurator__question__cremation">
					<div class="petsconfigurator__question__cremation__title">
						<div class="petsconfigurator__question__cremation__title__image">
							<img :src="`${themeDirectoryUri}/images/configurateur/fleur.svg`" alt="">
						</div>
						<div>
							<span class="petsconfigurator__question__cremation__title__one">La crémation</span><br>
							<span class="petsconfigurator__question__cremation__title__two">référence</span>
						</div>
					</div>
					<ul class="petsconfigurator__question__cremation__list">
						<li>
							Prise en charge de l'animal décédé
						</li>
						<li v-if="store.state.petsConfigurator.ceremonieAdieu">
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
				<div v-else class="petsconfigurator__question__cremation">
					<div class="petsconfigurator__question__cremation__title">
						<div class="petsconfigurator__question__cremation__title__image">
							<img :src="`${themeDirectoryUri}/images/configurateur/fleur.svg`" alt="">
						</div>
						<div>
							<span class="petsconfigurator__question__cremation__title__one">La crémation</span><br>
							<span class="petsconfigurator__question__cremation__title__two">plurielle</span>
						</div>
					</div>
					<ul class="petsconfigurator__question__cremation__list">
						<li>
							Prise en charge de l'animal décédé
						</li>
						<li>
							Crémation collective avec d'autres animaux de compagnie
						</li>
					</ul>
				</div>
				<div class="petsconfigurator__question__footnotes">
					Cette simulation est fournie à titre indicatif. Elle ne prend pas en compte le lieu de prise en charge de l'animal, la disponibilité des accessoires souhaités et ne constitue donc pas un devis. Cette simulation n'a pas de valeur contractuelle. Si vous avez besoin d'un complément d'informations, nos conseillers sont là pour vous guider.
				</div>
			</div>

		</div>
		<div class="petsconfigurator__souvenir-popup" :class="{'petsconfigurator__souvenir-popup--open' : popUpKiamo}">
			<span class="petsconfigurator__souvenir-popup__quit" @click.prevent="closePopUpKiamo"></span>
			<div class="petsconfigurator__souvenir-popup__content">
				<div style="padding: 30px;font-weight: 600;padding-top: 50px;font-size: 16px;text-align: left;align-items: flex-start;">
					<p style="text-align: left;">Nous avons bien pris en compte votre demande de rappel, nous allons la traiter dans les meilleurs délais.</p>
					<p>Pour information, nos services sont ouverts du lundi au vendredi de 8h00 à 18h00 et le samedi de 8h30 à 12h30; nous prendrons en compte votre demande de rappel dans ces horaires</p>
				</div>
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
	import EventBus from '../EventBus';


	const store = useStore()

	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''

	const imgLoaded = ref(0)

	const popUpKiamo = ref(false)

	const yesCendre = computed({
		get () {
			return `${store.state.petsConfigurator.cremations.reference[store.state.petsConfigurator.typeAnimal]}€`
		}
	})

	const noCendre = computed({
		get () {
			return `${store.state.petsConfigurator.cremations.plurielle[store.state.petsConfigurator.typeAnimal]}€`
		}
	})

	const yesCeremonie = computed({
		get () {
			return `(+${store.state.petsConfigurator.cremations[cremationChoice.value].description.ceremonie[store.state.petsConfigurator.typeAnimal]}€)`
		}
	})

	const detailYesUrnes = computed({
		get () {
			return `(+${getUrnePrice.value}€)`
		}
	})

	const yesSouvenir = computed({
		get () {
			return `(+${getSouvenirPrice.value}€)`
		}
	})

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
						n = `${n} (${variations})`
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

	const getSouvenirPrice = computed({
		get () {
			return store.getters['petsConfigurator/getSouvenirPrice']
		}
	})

	const getUrnePrice = computed({
		get () {
			return store.getters['petsConfigurator/getUrnePrice']
		}
	})

	const souvenirDetails = computed({
	get() {
			let p = []
			if (store.state.petsConfigurator.gesteSouvenirEmpreinte) {
				if (store.state.petsConfigurator.gesteSouvenirEmpreinte) {
					p.push(`Empreinte <small>(+${store.state.petsConfigurator.prixEmpreinte}€)</small>`)
				}
			}
			if (store.state.petsConfigurator.gesteSouvenirTouffe) {
				if (store.state.petsConfigurator.gesteSouvenirTouffe) {
					p.push(`Touffe de poils <small>(+${store.state.petsConfigurator.prixTouffe}€)</small>`)
				}
			}
			return p.join(' , ')
		}
	})

	const closePopUpKiamo = () => {
		popUpKiamo.value = false
		store.commit('petsConfigurator/updatePopupOpen', false)
	}
	const showPopUpKiamo = () => {
		popUpKiamo.value = true
		store.commit('petsConfigurator/updatePopupOpen', true)
	}


	onMounted(() => {
		EventBus.on('confirmCallKiamo', showPopUpKiamo)
		setTimeout(() => {
			imgLoaded.value = true
		}, 300)
	})
	onUnmounted(() => {
		EventBus.off('confirmCallKiamo', showPopUpKiamo)
		imgLoaded.value = false
	})
</script>
