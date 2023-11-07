import Vue from 'vue'

Vue.directive('router-back', {
  bind(el) {
    el.addEventListener('click', (e) => {
      e.preventDefault()
      vm.$router.go(-1)
    })
  }
})

Vue.directive('maxchars', {
  bind: function (el, binding, vnode) {
    const max_chars = binding.expression
    const handler = function (e) {
        if (e.target.value.length > max_chars) {
          e.target.value = e.target.value.substr(0, max_chars)
        }
    }
    el.addEventListener('input', handler)
  },
})