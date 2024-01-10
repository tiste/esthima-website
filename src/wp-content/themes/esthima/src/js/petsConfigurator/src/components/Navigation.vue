<template>
	<nav class="petsconfigurator__navigation">
		<div class="petsconfigurator__navigation__content">
			<button @click.prevent="goPrev" class="btn btn--arrow btn--arrow-reverse btn--arrow-disable-hover petsconfigurator__navigation__button-desk">Retour</button>
			<ProgressBar :value="percentBar" v-if="route.name != 'Recap'" />
			
			<div class="petsconfigurator__navigation__buttons">
				<button @click.prevent="goPrev" class="btn btn--arrow btn--arrow-reverse btn--arrow-disable-hover" v-if="route.name != 'Recap'">Retour</button>
				<button @click.prevent="goPrev" class="btn btn--arrow btn--arrow-reverse btn--arrow-disable-hover petsconfigurator__navigation__recap-btn-back" v-else>Retour</button>
				<button @click.prevent="goNext" class="btn btn--arrow btn--arrow-disable-hover" v-if="route.name != 'Recap'">Continuer</button>
			</div>
			<div class="petsconfigurator__navigation__price" v-if="route.name != 'Recap'">
				<span>Total : <b>{{totalPrice}}€</b></span>
			</div>
			<div class="petsconfigurator__navigation__price petsconfigurator__navigation__price--recap" v-else>
				<span>Total : <b>{{totalPrice}}€</b></span>
				<span class="petsconfigurator__navigation__price__alma">Paiement en plusieurs fois avec <img :src="`${themeDirectoryUri}/images/configurateur/alma.svg`" alt=""></span>
			</div>
			<button @click.prevent="goNext" class="btn btn--arrow btn--arrow-disable-hover petsconfigurator__navigation__button-desk" v-if="route.name != 'Recap'">Continuer</button>
			<button @click.prevent="downloadOffre" class="btn btn--arrow btn--arrow-disable-hover petsconfigurator__navigation__recap-btn" v-if="route.name == 'Recap'">Télécharger mon offre personnalisée</button>
			<button class="btn btn--arrow btn--arrow-disable-hover petsconfigurator__navigation__recap-btn" v-if="route.name == 'Recap'">Être rappelé par Esthima</button>
		</div>
    </nav>
</template>

<script>
export default {
	name: 'Navigation',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import { goPrev, goNext } from '../helpers/Navigate';
import ProgressBar from './ProgressBar'
import { request } from '../helpers/Request.js'

const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''
const userID = window.wpvar.currentAccountID || ''
const baseApi = window.wpvar.baseApi || ''

const route = useRoute()

const store = useStore()

let percentBar = computed({
	get () {
		if (route.meta.percent) {
		 	return route.meta.percent
		} else {
			return 10
		}
	}
})

const totalPrice = computed({
	get () {
		return store.getters['petsConfigurator/totalPrice']
	}
})

const downloadOffre = () => {
	let data = {
		'espece': store.state.petsConfigurator.typeAnimal,
        'nom': store.state.petsConfigurator.nameAnimal,
        'recuperation_cendres': store.state.petsConfigurator.cendre,
        'ceremonie_adieu': (store.state.petsConfigurator.ceremonieAdieu) ? 'Oui' : 'Non',
        'urne': (store.state.petsConfigurator.urne) ? urneDetails.value : 'Non',
        'urne_sku': (store.state.petsConfigurator.urne) ? urneSku.value : '',
        'geste_souvenir': (store.state.petsConfigurator.souvenir) ? `Oui / ${store.state.petsConfigurator.gesteSouvenir}` : 'Non',
        'cremation': store.getters['petsConfigurator/cremationChoice'],
        'prix_urne': urnePrice.value,
        'prix_geste_souvenir': souvenirPrice.value,
        'prix_cremation': store.getters['petsConfigurator/priceCremation'],
        'prix_total': store.getters['petsConfigurator/totalPrice'],
        'email': store.state.petsConfigurator.emailUser,
        'nom_personne': store.state.petsConfigurator.lastNameUser,
        'prenom_personne': store.state.petsConfigurator.firstNameUser,
        'userID': userID,
	}

	request('register-devis', JSON.stringify(data), 'POST').then((postID) => {
		window.open( `${baseApi}generate-pdf?id=${postID}`, '_blank');
	})
}

const urneSku = computed({
	get() {
		if (store.state.petsConfigurator.urne) {
			if (store.state.petsConfigurator.urne.type == "variable") {
				return store.state.petsConfigurator.urne.variation_selected.sku
			} else {
				return store.state.petsConfigurator.urne.sku
			}
		}
	}
})

const urnePrice = computed({
	get() {
		if (store.state.petsConfigurator.urne) {
			if (store.state.petsConfigurator.urne.type == "variable") {
				return store.state.petsConfigurator.urne.variation_selected.display_price
			} else {
				return store.state.petsConfigurator.urne.price
			}
		}
	}
})

const souvenirPrice = computed({
	get() {
		if (store.state.petsConfigurator.gesteSouvenir) {
			if (store.state.petsConfigurator.gesteSouvenir == "empreinte") {
				return store.state.petsConfigurator.prixEmpreinte
			} else {
				return store.state.petsConfigurator.prixTouffe
			}
		}
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


</script>
