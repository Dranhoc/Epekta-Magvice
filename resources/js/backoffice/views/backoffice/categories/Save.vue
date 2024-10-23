<template>
	<div
		v-if="isFetchPending || isSavePending"
		class="h-[85.5vh] w-full flex items-center justify-center bg-black/75"
	>
		<ProgressSpinner />
	</div>

	<template v-else>
		<Breadcrumbs
			:bread-crumbs-first-item="breadCrumbsFirstItem"
			:bread-crumbs-items="breadCrumbsItems"
		/>

		<div class="flex mb-20 justify-between mx-20 my-5">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">
					{{ category?.id ? "Modifier" : "Ajouter" }}
				</h1>
			</div>
		</div>

		<div class="flex flex-col gap-4 mx-20">
			<div class="flex flex-col gap-2">
				<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
					>Nom</label
				>
				<InputText
					id="name"
					v-model="form.name"
					type="name"
					name="name"
					:class="form.invalid('name') ? 'p-invalid' : ''"
					@change="form.validate('name')"
				/>
				<small v-if="form.invalid('name')" id="text-error" class="p-error">
					{{ form.errors.name }}
				</small>
			</div>

			<div class="flex flex-col gap-2 mb-6">
				<label for="type" class="text-dark-slate-600 uppercase"
					>Catégorie parente</label
				>
				<Select
					v-model="form.category"
					:options="categoriesOptions"
					option-label="name"
					placeholder="Choisissez une catégorie"
					:class="form.invalid('category') ? 'p-invalid' : ''"
				/>
				<small v-if="form.invalid('category')" id="text-error" class="p-error">
					{{ form.errors.category }}
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
	</template>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, onBeforeUnmount, ref } from "vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import ProgressSpinner from "primevue/progressspinner";
import Select from "primevue/select";

import { useForm } from "laravel-precognition-vue";
import { useCategoriesStore } from "../../../store/categories";
import { useConfigsStore } from "../../../store/configs"
import { storeToRefs } from "pinia";
import { useToast } from "primevue/usetoast";
import { useRoute, useRouter } from "vue-router";

import { CategoryType } from "../../../types/category";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

const toast = useToast();
const route = useRoute();
const router = useRouter();

const breadCrumbsFirstItem = ref({
	label: "Catégorie(s)",
	to: { name: "categories" },
});

const breadCrumbsItems = computed(() => {
	let items: { label: string; to?: { name: string; params?: any } }[] = [];

	if (category.value) {
		items.push({ label: category?.value?.name || "" });
	}

	items.push({ label: category?.value !== null ? "Modifier" : "Ajouter" });

	return items;
});

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const categoriesStore = useCategoriesStore();
const categoriesRefs = storeToRefs(categoriesStore);
const isFetchPending = categoriesRefs.isFetchSinglePending;
const isSavePending = categoriesRefs.isSavePending;
const category = categoriesRefs.single;
const categoriesOptions = ref<{ name: string; id: number }[]>([]);

const form = useForm(
	route.params.category_id ? "patch" : "post",
	route.params.category_id
		? "/api/categories/" + route.params.category_id
		: "/api/categories",
	{
		name: null,
		category: <{ label: string; id: number } | null>null,
	},
);

onBeforeMount(async () => {
	if (route.params.category_id) {
		categoriesStore.getItem({ id: String(route.params.category_id) });
	} else {
		category.value = null;
	}

	await categoriesStore.getItems({ includes: ["categories"] });
	categoriesOptions.value = categoriesRefs.list.value.map(
		(category: CategoryType) => {
			return { name: category.name[locale.value], id: category.id };
		},
	);

	form.setData({
		name: category?.value?.name || null,
		category: categoriesOptions.value?.find(
			(parent_category) =>
				Number(parent_category.id) == Number(category?.value?.category_id),
		),
	});
});

const handleSubmit = () => {
	categoriesRefs.isSavePending.value = true;

	let untouchedData = form.data();

	form
		.setData({
			category: untouchedData?.category?.id || null,
		})
		.submit()
		.then(() => {
			if (route.params.category_id) {
				toast.add({
					severity: "success",
					summary: "Bravo",
					detail: "La catégorie a bien été modifié",
					life: 8000,
				});
			} else {
				toast.add({
					severity: "success",
					summary: "Bravo",
					detail: "La catégorie a bien été créé",
					life: 8000,
				});
			}

			return router.push({ name: "configuration" });
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
			form.setData({ ...untouchedData });
		})
		.finally(() => {
			categoriesRefs.isSavePending.value = false;
		});
};

onBeforeUnmount(() => {
	categoriesRefs.single.value = null;
});
</script>
