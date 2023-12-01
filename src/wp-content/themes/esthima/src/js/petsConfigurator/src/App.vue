<template>
  <section class="petsconfigurator">
    <router-view v-slot="{ Component }">
      <transition :name="transitionName">
        <component :is="Component" ref="stepRef" />
      </transition>
      <Navigation v-show="route.name != 'Home'" />
    </router-view>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { RouterView, useRoute } from "vue-router";
import Navigation from "./components/Navigation";
import { useStore } from 'vuex'


const route = useRoute()
const store = useStore()

const transitionName = computed({
	get () {
		return store.state.petsConfigurator.transitionName
	}
})

</script>