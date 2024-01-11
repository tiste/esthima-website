<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--urne">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/urne-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/urne-chat.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/urne-nac.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
		</div>

		<div class="petsconfigurator__question">
			<form class="petsconfigurator__question__form">
				<span class="petsconfigurator__question__h1">
					Je souhaite ajouter une urne décorative
				</span>
				<ul class="petsconfigurator__question__list-radio petsconfigurator__question__list-radio--bool">
					<li>
						<input type="radio" id="urneTrue" :value="true" v-model="urne"/>
						<label for="urneTrue">Oui</label>
					</li>
					<li>
						<input type="radio" id="urneFalse" :value="false" v-model="urne"/>
						<label for="urneFalse">Non</label>
					</li>
				</ul>
				<div class="input-errors" v-for="error of v$.urne.$errors" :key="error.$uid">
					<div class="error-msg">{{ error.$message }}</div>
				</div>
				
				<div class="petsconfigurator__urne-popup" :class="{'petsconfigurator__urne-popup--open' : showPopup}">
					<span class="petsconfigurator__urne-popup__quit" @click.prevent="closeUrne"></span>
					<div class="petsconfigurator__urne-popup__content" v-if="showPopup">
						<span class="petsconfigurator__question__h1">
							Je choisis mon <br>urne décorative
						</span>
						<div class="petsconfigurator__show-up-urne" v-if="urneShowUp != null">
							<a href="#" class="petsconfigurator__show-up-urne__back" @click.prevent="showDetailUrne(null)">&lt; Retour</a>
							<div class="petsconfigurator__show-up-urne__content">
								<div class="petsconfigurator__show-up-urne__picture">
									<img v-lazy="urneShowUp.image_url"  />
								</div>
								<div class="petsconfigurator__show-up-urne__info">
									<span class="petsconfigurator__show-up-urne__info__ref">REFERENCE: {{urneShowUp.sku}}</span>
									<span class="petsconfigurator__show-up-urne__info__name">{{urneShowUp.name}}</span>
									<span class="petsconfigurator__show-up-urne__info__stock petsconfigurator__show-up-urne__info__stock--instock" v-show="urneShowUp.stock_status == 'instock' && urneShowUp.available == true">En stock</span>
									<span class="petsconfigurator__show-up-urne__info__stock" v-show="urneShowUp.available == false">Indisponible</span>
									<span class="petsconfigurator__show-up-urne__info__description">{{urneShowUp.description}}</span>
									<span class="petsconfigurator__show-up-urne__info__separator"></span>
									<ul class="petsconfigurator__show-up-urne__info__list-variation">
										<li v-for="(variation, name) in urneShowUp.variations">
											<label v-if="name == 'pa_couleur'">Couleurs</label>
											<label v-else-if="name == 'pa_contenance'">Poids de l'animal</label>
											<label v-else-if="name == 'pa_matiere'">Matière</label>
											<label v-else>{{ name }}</label>
											<select @change="updateProductShowUp()" :ref="el => { urneAttributesSelected[`attribute_${name}`] = el }">
												<option v-for="v in variation" :value="v">{{v}}</option>
											</select>
										</li>
									</ul>
									<span class="petsconfigurator__show-up-urne__info__price" v-if="urneShowUp.available == false">Indisponible</span>
									<span class="petsconfigurator__show-up-urne__info__price" v-else>{{formatCurrency(urneShowUp.price)}}</span>
									<button class="btn btn--primary petsconfigurator__show-up-urne__info__btn" @click.prevent="selectUrne(urneShowUp)">Sélectionner le produit</button>
								</div>
							</div>
						</div>
						<ul class="petsconfigurator__question__list-radio petsconfigurator__question__list-radio--urnes" :style="(urneShowUp != null) ? 'display:none!important' : ''">
							<li v-for="p in productsUrnes" class="petsconfigurator__urne" @click.prevent="showDetailUrne(p)">
								<div class="petsconfigurator__urne__thumb">
									<img v-lazy="p.image_url" />
								</div>
								<span class="petsconfigurator__urne__name">
									{{p.name}}
								</span>
								<span class="petsconfigurator__urne__price">
									Dès {{formatCurrency(p.price)}}
								</span>
							</li>
							<li v-for="i in 20" class="petsconfigurator__urne petsconfigurator__urne--loading" v-show="productsUrnes.length <= 0">
								<div class="petsconfigurator__urne__thumb"></div>
								<span class="petsconfigurator__urne__name">
								</span>
								<span class="petsconfigurator__urne__price">
								</span>
							</li>
						</ul>
						
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Urne',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { computed, onMounted, onUnmounted, ref, nextTick } from 'vue'
	import EventBus from '../EventBus';
	import { useStore } from 'vuex'
	import { useVuelidate } from '@vuelidate/core'
	import { required, helpers } from '@vuelidate/validators'
	import { goNext } from '../helpers/Navigate';


	const store = useStore()

	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''

	const imgLoaded = ref(0)
	
	const urneAttributesSelected = ref([])
	
	const showPopup = ref(false)

	const urneShowUp = ref(null)

	const urne = computed({
		get () {
			return store.state.petsConfigurator.urne
		},
		set (value) {
			store.commit('petsConfigurator/updateUrne', value)
			showPopup.value = value
			store.commit('petsConfigurator/updatePopupOpen', value)
		}
	})
	const urneProduct = computed({
		get () {
			return store.state.petsConfigurator.UrneProduct
		},
		set (value) {
			store.commit('petsConfigurator/updateUrneProduct', value)
		}
	})

	const typeAnimal = computed({
		get () {
			return store.state.petsConfigurator.typeAnimal
		}
	})

	const rules = {
		urne: {
			required: helpers.withMessage('Veuillez choisir une option', required)
		}
	}

	const v$ = useVuelidate(rules, {
		urne
	})

	const productsUrnes = computed({
		get () {
			return store.state.petsConfigurator.productsUrnes
		}
	})

	const closeUrne = () => {
		urne.value = false
	}

	const validate = async () => {
		const isFormCorrect = await v$.value.$validate();
      	if (!isFormCorrect) return false;
	}

	const showDetailUrne = (urne) => {
		urneShowUp.value = urne
		if (
			urneShowUp.value != null &&
			urneShowUp.value.type == "variable"
		) {
			nextTick(() => {
				updateProductShowUp()
      		});
		}
		
	}

	const updateProductShowUp = () => {
		
		if (
			urneShowUp.value == null ||
			urneShowUp.value.type != "variable"
		) {
			return
		}
		
		let availableVariations = urneShowUp.value.available_variations
		let foundVariations = null
		let urneAttributesSelectedValue = {}
		
		Object.keys(urneAttributesSelected.value).map((nameAttrib) => {
			if (urneAttributesSelected.value[nameAttrib]) {
				urneAttributesSelectedValue[nameAttrib] = urneAttributesSelected.value[nameAttrib].value 
			}
		})
		
		availableVariations.map((availableVariation) => {
			const obj1 = urneAttributesSelectedValue
			const obj2 = availableVariation.attributes
			const obj1Keys = Object.keys(obj1).sort();
			const obj2Keys = Object.keys(obj2).sort();
			if (obj1Keys.length !== obj2Keys.length) {
				} else {
				const areEqual = obj1Keys.every((key, index) => {
					const objValue1 = obj1[key];
					const objValue2 = obj2[obj2Keys[index]];
					return objValue1 === objValue2;
				});
				if (areEqual) {
					foundVariations = availableVariation
				}
			}
		})

		let tmpData = {...urneShowUp.value}

		if (foundVariations) {
			tmpData.sku = foundVariations.sku
			tmpData.price = foundVariations.display_price
			tmpData.stock_status = (foundVariations.is_in_stock) ? 'instock' : ''
			tmpData.variation_selected = foundVariations
			tmpData.available = true
		} else {
			tmpData.available = false
		}
		
		urneShowUp.value = tmpData

	}

	const selectUrne = (selectUrne) => {
		urneProduct.value = selectUrne
		store.commit('petsConfigurator/updatePopupOpen', false)
		showPopup.value = false
		goNext()
	}

	const formatCurrency = (value) => {
      if (isNaN(value)) {
        return value;
      }

      const options = {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      };

      return new Intl.NumberFormat('fr-FR', options).format(value);
    }

	onMounted(() => {
		if (urne.value) {
			showPopup.value = true
			store.commit('petsConfigurator/updatePopupOpen', true)
		} else {
			showPopup.value = false
			store.commit('petsConfigurator/updatePopupOpen', false)
		}
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
