<template>
    <div class="progressbar">
      <span class="progressbar__info" :style="barInfoStyle">{{ animatedValue }}%</span>
      <div class="progressbar__background">
        <div :class="barClass" :style="barStyle" class="progressbar__bar">
          <slot />
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, watch, onMounted } from 'vue'
  
  // Props
  const props = defineProps({
    value: {
      type: Number,
      default: 0,
    },
    barClass: {
      type: String,
      default: '',
    },
    origin: {
      type: String,
      default: 'left',
    },
    scale: {
      type: String,
      default: 'X',
      validator: v => ['X', 'Y'].includes(v),
    },
  })
  
  const ready = ref(false)
  const animatedValue = ref(props.value)
  
  
  const animateValueChange = (start, end, duration) => {
    let startTime
    const step = timestamp => {
      if (!startTime) startTime = timestamp
      const progress = Math.min((timestamp - startTime) / duration, 1)
      animatedValue.value = Math.floor(progress * (end - start) + start)
      if (progress < 1) {
        window.requestAnimationFrame(step)
      }
    }
    window.requestAnimationFrame(step)
  }
  
  
  watch(() => props.value, (newValue, oldValue) => {
    animateValueChange(oldValue, newValue, 500)
  })
  
  const barStyle = computed(() => {
    if (!ready.value) {
      return { transform: `scale${props.scale}(0)` }
    }
    return {
      transform: `scale${props.scale}(${animatedValue.value * 0.01})`,
      transformOrigin: `${props.origin}`,
    }
  })
  
  const barInfoStyle = computed(() => ({
    marginLeft: `${animatedValue.value / 2}%`,
  }))
  
  onMounted(() => {
    setTimeout(() => {
      ready.value = true
    }, 0)
  })
  </script>
  