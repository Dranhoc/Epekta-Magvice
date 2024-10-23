<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div
		v-if="isFetchPending || isSavePending"
		class="h-[85.5vh] w-full flex items-center justify-center bg-black/75"
	>
		<ProgressSpinner />
	</div>

	<div v-else class="mx-10 mb-10 py-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">
					{{ form?.id ? "Modifier" : "Ajouter" }}
				</h1>
			</div>
		</div>

		<div class="flex flex-col gap-4">
			<div class="flex-1 flex flex-col gap-2">
				<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
					>Nom</label
				>
				<InputText
					id="name"
					v-model="precogForm.name[locale]"
					type="name"
					name="name"
					:class="precogForm.invalid('name') ? 'p-invalid' : ''"
					@change="precogForm.validate('name')"
				/>
				<small
					v-if="precogForm.invalid('name.' + locale)"
					id="text-error"
					class="p-error"
				>
					{{ precogForm.errors["name." + locale] }}
				</small>
			</div>

			<div class="flex-1 flex flex-col gap-2">
				<ToggleButton
					id="isSummable"
					v-model="precogForm.is_summable"
					name="isSummable"
					:class="precogForm.invalid('is_summable') ? 'p-invalid' : ''"
					on-label="Je veux un total"
					off-label="Je ne veux pas un total"
					@change="precogForm.validate('is_summable')"
				/>
				<small
					v-if="precogForm.invalid('is_summable')"
					id="text-error"
					class="p-error"
				>
					{{ precogForm.errors.is_summable }}
				</small>
			</div>

			<div class="flex flex-row gap-2">
				<Button
					label="Annuler"
					severity="danger"
					size="small"
					@click.prevent="router.go(-1)"
				>
					<i class="pi pi-times mr-2" />Annuler
				</Button>
				<Button label="Sauvegarder" size="small" @click.prevent="handleSubmit">
					<i class="pi pi-check mr-2" />Sauvegarder
				</Button>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, onBeforeUnmount, ref } from "vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";

import { useForm } from "laravel-precognition-vue";
import { useConfigsStore } from "../../../store/configs";
import { useFormsStore } from "../../../store/forms"
import { storeToRefs } from "pinia";
import { useToast } from "primevue/usetoast";
import { useRoute, useRouter } from "vue-router";
import ProgressSpinner from "primevue/progressspinner";
import ToggleButton from "primevue/togglebutton";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

const toast = useToast();
const route = useRoute();
const router = useRouter();

const breadCrumbsFirstItem = computed(() => {
	return { label: "Formulaires", route: { name: "forms" } };
});

const breadCrumbsItems = computed(() => {
	let items: { label: string; to?: { name: string; params?: any } }[] = [];

	if (form?.value?.id) {
		items.push({ label: form?.value?.name[locale.value] || "N/A" });
	}

	items.push({ label: form?.value?.id ? "Modifier" : "Ajouter" });

	return items;
});

const formsStore = useFormsStore();
const formsRefs = storeToRefs(formsStore);
const isFetchPending = formsRefs.isFetchSinglePending;
const isSavePending = formsRefs.isSavePending;
const form = ref(formsRefs.single);

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const precogForm = useForm(
	route.params.form_id ? "patch" : "post",
	route.params.form_id ? "/api/forms/" + route.params.form_id : "/api/forms",
	{
		name: { fr: "", en: "" },
		is_summable: false,
	},
);

onBeforeMount(async () => {
	if (route.params.id) {
		await formsStore.getItem({ id: String(route.params.id), includes: [] });
	} else {
		form.value = {
			name: {
				fr: "",
				en: "",
			},
			is_summable: false,
		};
	}

	precogForm.setData({
		name: form?.value?.name || {},
		is_summable: form?.value?.is_summable || false,
	});
});

const handleSubmit = () => {
	formsRefs.isSavePending.value = true;

	let untouchedData = precogForm.data();

	precogForm
		.setData({})
		.submit()
		.then(() => {
			if (route.params.form_id) {
				toast.add({
					severity: "success",
					summary: "Bravo",
					detail: "Le formulaire a bien été modifié",
					life: 8000,
				});
			} else {
				toast.add({
					severity: "success",
					summary: "Bravo",
					detail: "Le formulaire a bien été créé",
					life: 8000,
				});
			}

			return router.push({ name: "forms" });
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
			precogForm.setData({ ...untouchedData });
		})
		.finally(() => {
			formsRefs.isSavePending.value = false;
		});
};

onBeforeUnmount(() => {
	formsRefs.single.value = null;
});
</script>
