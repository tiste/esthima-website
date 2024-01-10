<template>
  <section class="petsconfigurator" :class="classRoute" :style="petsConfigGrow">
    <router-view v-slot="{ Component }">
      <transition :name="transitionName">
        <component :is="Component" ref="stepRef" />
      </transition>
      <Navigation v-show="route.name != 'Home'" ref="nav" />
    </router-view>
  </section>
  <div class="petsconfigurator__bg" :class="{'petsconfigurator__bg--open': popupOpen}"></div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { RouterView, useRoute } from "vue-router";
import Navigation from "./components/Navigation";
import { useStore } from 'vuex'
import { request } from './helpers/Request.js'



const route = useRoute()
const store = useStore()

const nav = ref(0)
const petsConfigGrow = ref(0)

const transitionName = computed({
	get () {
		return store.state.petsConfigurator.transitionName
	}
})

const popupOpen = computed({
	get () {
		return store.state.petsConfigurator.popupOpen
	},
	set (value) {
		store.commit('petsConfigurator/updatePopupOpen', value)
	}
})

const classRoute = computed({
	get () {
    if (route.name) {
      return `petsconfigurator--${route.name.toLowerCase()}`
    }
    return ''
	}
})


const navHeightRefresh = () => {
  petsConfigGrow.value = `--data-petsconfig-grow:${nav.value.$el.clientHeight}px`
}

const productsUrnes = computed({
  get () {
    return store.state.petsConfigurator.productsUrnes
  },
  set (value) {
    store.commit('petsConfigurator/updateProductsUrnes', value)
  }
})

onMounted(() => {
  navHeightRefresh()
  window.addEventListener("resize", navHeightRefresh);
  popupOpen.value = false
  request('urnes').then((res) => {
    productsUrnes.value = res
  })
})


</script>