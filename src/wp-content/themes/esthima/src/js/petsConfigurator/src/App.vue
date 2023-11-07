<template>
	<div class="grid contact">
		
		<div v-show="!isHome() && !isEndPage()" class="contact-breadcrumb">
			<button @click.prevent="goBack">Retour</button> 
			<div style="padding-left: 5px;padding-right: 5px;">|</div>
			<router-link :to="{name: 'Home'}">Accueil</router-link>
		</div>

		<transition-page>
    		<router-view></router-view>
		</transition-page>
	</div>
</template>

<script>
import TransitionPage from './transitions/TransitionPage.vue';
import { mapFields } from 'vuex-map-fields';
import { mapGetters } from 'vuex'


	export default {
		name: 'Main',
		components: {
			TransitionPage
		},
		data(){
			return {
			}
		},
		computed: {
		
		},
		methods: {
			hasHistory () { 
				return window.history.length > 2 
			},
			goBack() {
				if (this.hasHistory()) {
					this.$router.go(-1)
				} else {
					this.$router.push('/')
				}
			},
			isHome() {
        		return (this.$route.name == 'Home');
    		},
			isEndPage() {
        		return (this.$route.name == 'fin');
    		}
		}
		
	}
</script>