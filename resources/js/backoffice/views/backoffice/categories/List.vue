<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div class="mx-20 mt-4 mb-4">
		<h2 class="mr-2 text-4xl text-dark-slate-800 font-semibold mb-6">
			Configuration
		</h2>
		<div class="flex items-center mb-4">
			<h3 class="text-2xl mr-6">Catégories</h3>
			<Button @click.prevent="handleCreateOrEditCategory">
				<i class="pi pi-plus-circle mr-2" />Ajouter
			</Button>
		</div>
		<template v-for="category in categories">
			<h4 class="capitalize text-lg mb-2">
				{{ category.name[locale] }} ({{ category.id }})
				<ProgressSpinner v-if="isCategoryDeletePending === category.id" />
				<Button
					v-tooltip.top="{ value: 'Éditer', class: 'tooltip-normal' }"
					label="Modifier"
					size="small"
					class="mr-2"
					@click.prevent="handleCreateOrEditCategory(category)"
				>
					<i class="pi pi-pencil" />
				</Button>
				<Button
					v-tooltip.top="{ value: 'Supprimer', class: 'tooltip-normal' }"
					label="Supprimer"
					severity="danger"
					size="small"
					class="mr-2"
					@click.prevent="handleDeleteCategory(category)"
				>
					<i class="pi pi-trash" />
				</Button>
			</h4>
			<ul class="list-disc pl-4 mb-6">
				<li v-for="subcategory in category.categories" class="capitalize mb-2">
					{{ subcategory.name[locale] }} ({{ subcategory.id }})
					<ProgressSpinner v-if="isCategoryDeletePending === subcategory.id" />
					<Button
						v-tooltip.top="{ value: 'Éditer', class: 'tooltip-normal' }"
						label="Modifier"
						size="small"
						class="mr-2"
						@click.prevent="handleCreateOrEditCategory(subcategory)"
					>
						<i class="pi pi-pencil" />
					</Button>
					<Button
						v-tooltip.top="{ value: 'Supprimer', class: 'tooltip-normal' }"
						label="Supprimer"
						severity="danger"
						size="small"
						class="mr-2"
						@click.prevent="handleDeleteCategory(subcategory)"
					>
						<i class="pi pi-trash" />
					</Button>
				</li>
			</ul>
		</template>
	</div>
</template>

<script lang="ts" setup>
import { useCategoriesStore } from '../../../store/categories'
import { useConfigsStore } from '../../../store/configs'
import { storeToRefs } from "pinia";
import { computed, onBeforeMount, ref } from "vue";
import Button from "primevue/button";
import { CategoryType } from "../../../types/category";
import { useRouter } from "vue-router";
import ProgressSpinner from "primevue/progressspinner";

import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

const router = useRouter();

const categoriesStore = useCategoriesStore();
const categoriesRefs = storeToRefs(categoriesStore);
const categories = categoriesRefs.list;
const isCategoryDeletePending = ref(categoriesRefs.isDeletePending);

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const breadCrumbsFirstItem = computed(() => {
	return { label: "Accueil", route: "/admin" };
});

const breadCrumbsItems = computed(() => [{ label: "Categorie(s)" }]);

onBeforeMount(() => {
	categoriesStore.getItems({ includes: ["categories"] });
});
const handleCreateOrEditCategory = (
	event: MouseEvent,
	category: CategoryType | null = null,
) => {
	categoriesRefs.single.value = null;
	router.push({
		name: "category-save",
		params: category ? { category_id: category.id } : {},
	});
};

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();

const handleDeleteCategory = (category: CategoryType) => {
	confirm.require({
		message: "Êtes vous sur de vouloir supprimer ?",
		header: "Confirmation",
		icon: "pi pi-exclamation-triangle",
		acceptLabel: "Supprimer",
		rejectLabel: "Annuler",
		accept: () => categoriesStore.deleteItem(category.id),
	});
};
</script>
