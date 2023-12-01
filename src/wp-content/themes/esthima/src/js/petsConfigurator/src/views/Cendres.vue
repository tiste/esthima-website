<template>
	<div>
		cendre
	</div>
</template>

<script>
export default {
	name: 'Cendres',
	inheritAttrs: false,
	customOptions: {}
}
</script>

<script setup>
	import { onMounted, onUnmounted } from 'vue'
	import EventBus from '../EventBus';

	const testde = () => {
		alert('cendreeeeeeeeeeeeeee')
	}

	onMounted(() => {
  		EventBus.on('goNextStep', testde);
	})
	onUnmounted(() => {
		EventBus.off('goNextStep', testde);
	})
</script>
