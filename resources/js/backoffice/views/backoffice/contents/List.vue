<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div class="mx-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">Contenus</h1>

				<Button @click.prevent="handleCreateOrEditContent">
					+ Ajouter un contenu
				</Button>
			</div>

			<Search @search="handleGlobalSearch" />
		</div>

		<DataTable
			:value="contents"
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
			<template #empty> Aucun pour l'instant </template>

			<Column
				header="Contenu"
				field="summary"
				:sortable="false"
				:pt="{ columnheadercontent: 'flex items-center' }"
				sort-field="false"
			>
				<template #body="slotProps">
					<div v-html="slotProps.data.summary" />
				</template>
			</Column>
			<Column
				header="Fichier"
				field="source_file"
				:sortable="true"
				:pt="{ columnheadercontent: 'flex items-center' }"
				sort-field="source_file"
			/>

			<Column #body="slotProps" header="Action(s)" class="w-1/4">
				<div class="flex items-center gap-2">
					<Button
						v-tooltip.top="{ value: 'Éditer', class: 'tooltip-normal' }"
						label="Modifier"
						size="small"
						@click.prevent="handleCreateOrEditContent(slotProps.data)"
					>
						<i class="pi pi-pencil" />
					</Button>
					<Button
						v-tooltip.top="{ value: 'Supprimer', class: 'tooltip-normal' }"
						label="Supprimer"
						severity="danger"
						size="small"
						@click.prevent="handleDeleteContent(slotProps.data)"
					>
						<i class="pi pi-trash" />
					</Button>
				</div>
			</Column>
		</DataTable>
	</div>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, ref } from "vue";

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";

import { useRouter } from "vue-router";
import { useConfirm } from "primevue/useconfirm";

import { storeToRefs } from "pinia";
import { useContentsStore } from "../../../store/contents";
import { useConfigsStore } from "../../../store/configs"

import { ContentType } from "../../../types/content";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";
import Search from "../../../components/partials/backoffice/search.vue";

import useDatatableActions from "../../../composables/datatable-actions";

const router = useRouter();
const confirm = useConfirm();

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);
const locale = configsRefs.locale;

const contentsStore = useContentsStore();
const contentsRefs = storeToRefs(contentsStore);
const pagination = contentsRefs.pagination;

const isFetchListPending = contentsRefs.isFetchListPending;
const contents = contentsRefs.list;

const breadCrumbsFirstItem = computed(() => {
	return { label: "Accueil", route: "/admin" };
});

const breadCrumbsItems = computed(() => [{ label: "Contenu(s)" }]);

const queryParams = ref({
	search: {
		search: null,
	},
	includes: [],
	sort_by: null,
	desc: false,
});

const { handlePageChange, handleSortChange, handleGlobalSearch } =
	useDatatableActions(pagination, queryParams, contentsStore.getItems);

onBeforeMount(() => {
	contentsStore.getItems();
});

const handleDeleteContent = (form: ContentType) => {
	confirm.require({
		message: "Êtes vous sur de vouloir supprimer ?",
		header: "Confirmation",
		icon: "pi pi-exclamation-triangle",
		acceptLabel: "Supprimer",
		rejectLabel: "Annuler",
		acceptClass: "p-button-danger",
		accept: () => contentsStore.deleteItem(form.id),
	});
};

const handleCreateOrEditContent = (content: ContentType) => {
	contentsRefs.single.value = null;
	router.push({
		name: "content-save",
		params: content ? { id: content.id } : {},
	});
};
</script>
