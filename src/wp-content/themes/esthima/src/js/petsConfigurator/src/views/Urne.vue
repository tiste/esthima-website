<template>
	<div class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--urne">
		<div class="petsconfigurator__hero petsconfigurator__hero--pets">
			<img v-if="typeAnimal == 'chien'" :src="`${themeDirectoryUri}/images/configurateur/urne-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'chat'" :src="`${themeDirectoryUri}/images/configurateur/urne-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
			<img v-else-if="typeAnimal == 'nac'" :src="`${themeDirectoryUri}/images/configurateur/urne-chien.png`" :class="{'petsconfigurator__hero__imgloaded': imgLoaded}" alt="">
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
				
				<div class="petsconfigurator__urne-popup" :class="{'petsconfigurator__urne-popup--open' : urne}">
					<span class="petsconfigurator__urne-popup__quit" @click.prevent="closeUrne"></span>
					<div class="petsconfigurator__urne-popup__content">
						<span class="petsconfigurator__question__h1">
							Je choisis mon <br>urne décorative
						</span>
						<div class="petsconfigurator__show-up-urne" v-if="urneShowUp != null">
							<a href="#" @click.prevent="showDetailUrne(null)">retour</a>
							<div class="petsconfigurator__show-up-urne__content">
								<div>
									<img :src="urneShowUp.image_url" />
								</div>
								<div>
									REFERENCE: {{urneShowUp.sku}}
									<br>
									{{urneShowUp.name}}
									<br>
									<span v-show="urneShowUp.stock_status == 'instock' && urneShowUp.available == true">En stock</span>
									<br>
									<span v-show="urneShowUp.available == false">Indisponible</span>
									<br>
									{{urneShowUp.description}}
									<br>
									<hr>
									<ul>
										<li v-for="(variation, name) in urneShowUp.variations">
											{{ name }}
											<select @change="updateProductShowUp()" :ref="el => { urneAttributesSelected[`attribute_${name}`] = el }">
												<option v-for="v in variation" :value="v">{{v}}</option>
											</select>
										</li>
									</ul>
									<span v-if="urneShowUp.available == false">Indisponible</span>
									<span v-else>{{formatCurrency(urneShowUp.price)}}</span>
								</div>
							</div>
						</div>
						<ul class="petsconfigurator__question__list-radio petsconfigurator__question__list-radio--urnes" :style="(urneShowUp != null) ? 'display:none!important' : ''">
							<li v-for="p in productsUrnes" class="petsconfigurator__urne" @click.prevent="showDetailUrne(p)">
								<div class="petsconfigurator__urne__thumb">
									<img :src="p.image_url" />
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

	const store = useStore()

	const themeDirectoryUri = window.wpvar.themeDirectoryUri || ''

	const imgLoaded = ref(0)
	
	const urneAttributesSelected = ref([])

	const urneShowUp = ref(null)

	const urne = computed({
		get () {
			return store.state.petsConfigurator.urne
		},
		set (value) {
			store.commit('petsConfigurator/updateUrne', value)
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
			tmpData.available = true
		} else {
			tmpData.available = false
		}
		
		urneShowUp.value = tmpData

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
