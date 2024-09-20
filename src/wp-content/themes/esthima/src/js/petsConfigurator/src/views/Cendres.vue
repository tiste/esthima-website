<template>
    <div
        class="petsconfigurator__content petsconfigurator__content--parcours petsconfigurator__content--cendres"
    >
        <div class="petsconfigurator__hero petsconfigurator__hero--pets">
            <img
                v-if="typeAnimal == 'chien'"
                :src="`${themeDirectoryUri}/images/configurateur/cendre-chien.png`"
                :class="{ petsconfigurator__hero__imgloaded: imgLoaded }"
                alt=""
            />
            <img
                v-else-if="typeAnimal == 'chat'"
                :src="`${themeDirectoryUri}/images/configurateur/cendre-chat.png`"
                :class="{ petsconfigurator__hero__imgloaded: imgLoaded }"
                alt=""
            />
            <img
                v-else-if="typeAnimal == 'nac'"
                :src="`${themeDirectoryUri}/images/configurateur/cendre-nac.png`"
                :class="{ petsconfigurator__hero__imgloaded: imgLoaded }"
                alt=""
            />
        </div>

        <div class="petsconfigurator__question">
            <form class="petsconfigurator__question__form">
                <span class="petsconfigurator__question__h1-sup">
                    Pour le garder près de moi
                </span>
                <span class="petsconfigurator__question__h1">
                    Je souhaite récupérer les cendres de {{ nameAnimal }}
                </span>
                <ul
                    class="petsconfigurator__question__list-radio petsconfigurator__question__list-radio--bool"
                >
                    <li>
                        <input
                            type="radio"
                            id="cendreTrue"
                            :value="true"
                            v-model="cendre"
                        />
                        <label for="cendreTrue">Oui</label>
                    </li>
                    <li>
                        <input
                            type="radio"
                            id="cendreFalse"
                            :value="false"
                            v-model="cendre"
                        />
                        <label for="cendreFalse">Non</label>
                    </li>
                </ul>
                <div
                    class="input-errors"
                    v-for="error of v$.cendre.$errors"
                    :key="error.$uid"
                >
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Cendres",
    inheritAttrs: false,
    customOptions: {},
};
</script>

<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import EventBus from "../EventBus";
import { useStore } from "vuex";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers } from "@vuelidate/validators";

const store = useStore();

const themeDirectoryUri = window.wpvar.themeDirectoryUri || "";

const imgLoaded = ref(0);

const cendre = computed({
    get() {
        return store.state.petsConfigurator.cendre;
    },
    set(value) {
        store.commit("petsConfigurator/updateCendre", value);
        if (value == false) {
            store.commit("petsConfigurator/updateCeremonieAdieu", false);
        }
    },
});

const nameAnimal = computed({
    get() {
        return store.state.petsConfigurator.nameAnimal;
    },
});

const typeAnimal = computed({
    get() {
        return store.state.petsConfigurator.typeAnimal;
    },
});

const rules = {
    cendre: {
        required: helpers.withMessage("Veuillez choisir une option", required),
    },
};

const v$ = useVuelidate(rules, {
    cendre,
});

const validate = async () => {
    const isFormCorrect = await v$.value.$validate();
    if (!isFormCorrect) return false;
};

onMounted(() => {
    EventBus.on("goNextStep", validate);
    setTimeout(() => {
        imgLoaded.value = true;
    }, 300);
});
onUnmounted(() => {
    EventBus.off("goNextStep", validate);
    imgLoaded.value = false;
});
</script>
