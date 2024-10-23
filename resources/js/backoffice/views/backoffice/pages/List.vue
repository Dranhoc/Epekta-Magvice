<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div class="mx-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">Pages</h1>

				<Button @click.prevent="handleCreateOrEditPage">
					+ Ajouter une page
				</Button>
			</div>

			<Search @search="handleGlobalSearch" />
		</div>

		<DataTable
			:value="pages"
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

			<Column header="ID" field="id" />

            <Column
                header="ID"
                field="id"
            />

            <Column
                header="Titre"
                field="title"
                :sortable="true"
                :pt="{ columnheadercontent: 'flex items-center' }"
            />

			<Column #body="slotProps" header="Action(s)" class="w-1/4">
				<div class="flex items-center gap-2">
					<Button
						v-tooltip.top="{ value: 'Voir', class: 'tooltip-normal' }"
						label="Modifier"
						size="small"
						@click.prevent="handleShowPage(slotProps.data)"
					>
						<i class="pi pi-eye" />
					</Button>
					<Button
						v-tooltip.top="{ value: 'Éditer', class: 'tooltip-normal' }"
						label="Modifier"
						size="small"
						@click.prevent="handleCreateOrEditPage(slotProps.data)"
					>
						<i class="pi pi-pencil" />
					</Button>
					<Button
						v-tooltip.top="{ value: 'Supprimer', class: 'tooltip-normal' }"
						label="Supprimer"
						severity="danger"
						size="small"
						@click.prevent="handleDeletePage(slotProps.data)"
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
    import { usePagesStore } from "../../../store/pages";

    import { PageType } from "../../../types/page";
    import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";
    import Search from "../../../components/partials/backoffice/search.vue";

    import useDatatableActions from "../../../composables/datatable-actions";

    const router = useRouter();
    const confirm = useConfirm();

    const pagesStore = usePagesStore();
    const pagesRefs = storeToRefs(pagesStore);
    const pagination = pagesRefs.pagination;
    const isFetchListPending = pagesRefs.isFetchListPending;
    const pages = pagesRefs.list;

    const breadCrumbsFirstItem = computed(() => {
        return { label: "Accueil", route: "/admin" };
    });
    const breadCrumbsItems = computed(() => [{ label: "Pages" }]);

    const queryParams = ref({
        search: {
            search: null,
        },
        includes: [],
        sort_by: null,
        desc: false,
    });

    const { handlePageChange, handleSortChange, handleGlobalSearch } =
        useDatatableActions(pagination, queryParams, pagesStore.getItems);

    onBeforeMount(() => {
        pagesStore.getItems();
    });

    const handleDeletePage = (page: PageType) => {
        confirm.require({
            message: "Êtes vous sur de vouloir supprimer ?",
            header: "Confirmation",
            icon: "pi pi-exclamation-triangle",
            acceptLabel: "Supprimer",
            rejectLabel: "Annuler",
            acceptClass: "p-button-danger",
            accept: () => pagesStore.deleteItem(page.id),
        });
    };

    const handleCreateOrEditPage = (page: PageType) => {
        pagesRefs.single.value = null;
        router.push({ name: "page-save", params: page ? { id: page.id } : {} });
    };

    const handleShowPage = (page: PageType) => {
        window.open(page.url);
    };
</script>
