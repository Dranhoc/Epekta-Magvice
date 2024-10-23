<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div class="mx-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">Formulaires</h1>

				<Button @click.prevent="handleCreateOrEditForm">
					+ Ajouter un formulaire
				</Button>
			</div>

			<Search @search="handleGlobalSearch" />
		</div>

		<DataTable
			:value="forms"
			:loading="isFetchListPending"
			:rows="pagination?.per_page"
			:rows-per-page-options="[5, 10, 15, 20]"
			:total-records="pagination?.total"
			lazy
			paginator
			show-gridlines
			striped-rows
			removable-sort
			current-page-report-template="{currentPage}/{totalPages}"
			paginator-template="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
			:pt="{
				header: { class: 'text-surface-600 font-bold text-sm' },
				mask:
					'absolute z-50 flex items-center justify-center w-full h-full bg-black/50',
				loadingIcon: 'text-primary-200 animate-spin h-20 w-20',
			}"
			@page="handlePageChange($event)"
			@sort="handleSortChange($event)"
		>
			<template #empty> Aucun conditionnement pour l'instant </template>

			<Column
				header="Nom"
				:field="`name.${locale}`"
				:sortable="true"
				:pt="{ columnheadercontent: 'flex items-center' }"
				filter-field="name"
			/>

			<Column #body="slotProps" header="Action(s)" class="w-1/4">
				<div class="flex items-center gap-2">
					<Button
						v-tooltip.top="{ value: 'Éditer', class: 'tooltip-normal' }"
						label="Modifier"
						size="small"
						@click.prevent="handleShowForm(slotProps.data)"
					>
						<i class="pi pi-eye" />
					</Button>
					<Button
						v-tooltip.top="{
							value: 'Éditer les paramètres',
							class: 'tooltip-normal',
						}"
						label="Éditer"
						size="small"
						@click.prevent="handleCreateOrEditForm(slotProps.data)"
					>
						<i class="pi pi-pencil" />
					</Button>
					<Button
						v-tooltip.top="{ value: 'Voir les réponses', class: 'tooltip-normal' }"
						label="Modifier"
						size="small"
						@click.prevent="handleShowResponses(slotProps.data)"
					>
						<i class="pi pi-book" />
					</Button>
					<Button
						v-tooltip.top="{ value: 'Supprimer', class: 'tooltip-normal' }"
						label="Supprimer"
						severity="danger"
						size="small"
						@click.prevent="handleDeleteForm(slotProps.data)"
					>
						<i class="pi pi-trash" />
					</Button>
				</div>
			</Column>
		</DataTable>
	</div>
</template>

<script setup lang="ts">
import { onBeforeMount, computed, ref } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import { useConfigsStore } from "../../../store/configs";
import { useFormsStore } from "../../../store/forms"
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { useConfirm } from "primevue/useconfirm";
import { FormType } from "../../../types/form";

import Search from "../../../components/partials/backoffice/search.vue";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

import useDatatableActions from "../../../composables/datatable-actions";

const router = useRouter();
const confirm = useConfirm();

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);
const locale = configsRefs.locale;

const formsStore = useFormsStore();
const formsRefs = storeToRefs(formsStore);
const pagination = formsRefs.pagination;
const isFetchListPending = formsRefs.isFetchListPending;
const forms = formsRefs.list;

const breadCrumbsFirstItem = computed(() => {
	return { label: "Accueil", route: "/admin" };
});
const breadCrumbsItems = computed(() => [{ label: "Formulaires" }]);

const queryParams = ref({
	search: {
		search: null,
	},
	includes: [],
	sort_by: null,
	desc: false,
});

const { handlePageChange, handleSortChange, handleGlobalSearch } =
	useDatatableActions(pagination, queryParams, formsStore.getItems);

onBeforeMount(() => {
	formsStore.getItems();
});

const handleDeleteForm = (form: FormType) => {
	confirm.require({
		message: "Êtes vous sur de vouloir supprimer ?",
		header: "Confirmation",
		icon: "pi pi-exclamation-triangle",
		acceptLabel: "Supprimer",
		rejectLabel: "Annuler",
		acceptClass: "p-button-danger",
		accept: () =>
			formsStore.deleteItem(form.id).then(() => formsStore.getItems()),
	});
};

const handleCreateOrEditForm = (form: FormType) => {
	formsRefs.single.value = null;
	router.push({ name: "form-save", params: form ? { id: form.id } : {} });
};

const handleShowForm = (form: FormType) => {
	router.push({ name: "form-steps", params: { id: form.id } });
};

const handleShowResponses = (form: FormType) => {
	router.push({ name: "form-responses", params: { id: form.id } });
};
</script>
