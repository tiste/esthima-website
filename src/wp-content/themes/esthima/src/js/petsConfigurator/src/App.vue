<template>
  <section class="petsconfigurator">
    <router-view v-slot="{ Component }">
      <transition name="scale-slide">
        <component :is="Component" />
      </transition>
      <Navigation v-show="route.name != 'Home'" />
    </router-view>
  </section>
</template>

<script setup>
import { RouterView, useRoute } from "vue-router";
import Navigation from "./components/Navigation";

const route = useRoute()

</script>