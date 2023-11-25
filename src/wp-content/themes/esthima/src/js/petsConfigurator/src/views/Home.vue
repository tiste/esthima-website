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
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';

export default defineComponent({
  name: "Home",
  setup() {
    const router = useRouter();

    const submit = () => {
      router.push({ name: 'InfoAnimal' });
    };

    return {
      submit
    };
  }
});
</script>
