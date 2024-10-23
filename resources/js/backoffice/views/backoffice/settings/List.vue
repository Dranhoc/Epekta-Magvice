<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div class="mx-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">Paramètre(s)</h1>
			</div>
		</div>

    <div
      v-for="(setting, index) in settings"
      :key="index"
      class="flex items-center mb-2"
    >
      <label
        :for="setting.key.toLowerCase()"
        class="mr-2 w-1/3"
      >{{ setting.key }}</label>
      <InputText
        :id="setting.key.toLowerCase()"
        v-model="setting.value"
        type="text"
        :name="setting.key.toLowerCase()"
        class="w-2/3"
        @blur="handleSave(setting)"
      />
    </div>
  </div>
    <div v-for="setting in settings" class="flex items-center mb-2">
        <label :for="setting.key.toLowerCase()" class="mr-2 w-1/3">{{
            setting.key
        }}</label>
        <InputText
            :id="setting.key.toLowerCase()"
            v-model="setting.value"
            type="text"
            :name="setting.key.toLowerCase()"
            class="w-2/3"
            @blur="handleSave(setting)"
        />
    </div>
</template>

<script lang="ts" setup>
import InputText from "primevue/inputtext";
import { computed, onBeforeMount, ref } from "vue";
import { SettingType } from "../../../types/setting";
import { storeToRefs } from "pinia";
import { useForm } from "laravel-precognition-vue";
import { useSettingsStore } from "../../../store/settings";
import { useToast } from "primevue/usetoast";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

const toast = useToast();

const breadCrumbsFirstItem = computed(() => {
	return { label: "Accueil", route: "/admin" };
});
const breadCrumbsItems = computed(() => [{ label: "Paramètres" }]);

const settingsStore = useSettingsStore();
const settingsRefs = storeToRefs(settingsStore);
const settings = ref(settingsRefs.list);

onBeforeMount(async () => {
	await settingsStore.getItems({ per_page: 100 });
});

const handleSave = (setting: SettingType) => {
	const form = useForm("patch", "/api/settings/" + setting.id, {
		key: null,
		value: null,
	});

	form
		.setData({ ...setting })
		.submit()
		.then(() => {
			toast.add({
				severity: "success",
				summary: "Bravo",
				detail: "Le paramètre a bien été modifié",
				life: 8000,
			});
		})
		.catch((error) => {
			if (error.response.status === 422) {
				toast.add({
					severity: "warn",
					summary: "Attention",
					detail: "Il y a des erreurs dans le formulaire",
					life: 8000,
				});
			}
			if (error.response.status === 500) {
				toast.add({
					severity: "error",
					summary: "Attention",
					detail: "Il y a une erreur serveur",
					life: 8000,
				});
			}
		})
		.finally(() => {
			settingsRefs.isSavePending.value = false;
		});
};
</script>
