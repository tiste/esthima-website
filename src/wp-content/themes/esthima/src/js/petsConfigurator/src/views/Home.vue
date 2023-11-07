<template>
  <div>
	<form @submit="submit">
		<img
		src="/wp-content/themes/esthima/images/configurateur/configurateur-cadre-chien.png"
		alt=""
		/>
		<h1>
		Lorem ipsum dolor sit amet consectetur. Volutpat pellentesque interdum
		dignissim.
		</h1>
		<p>
		Lorem ipsum dolor sit amet consectetur. Commodo felis enim mus placerat
		amet risus dapibus vestibulum in. Nunc et sed faucibus quam. Ornare
		adipiscing sit sed viverra ornare morbi risus lectus ultricies. Diam a
		laoreet magna a consectetur velit.
		</p>
		<button type="submit">Commencer</button>
	</form>
  </div>
</template>

<script>
import { request } from "../helpers/request";
import { mapFields } from "vuex-map-fields";

export default {
  name: "Home",
  data() {
    return {};
  },
  methods: {
	submit() {
		this.$router.push({ name: 'InfoAnimal' })
	}
  },
  computed: {},
  mounted() {},
  created() {},
};
</script>