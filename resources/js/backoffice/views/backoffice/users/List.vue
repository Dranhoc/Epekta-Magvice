<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div class="mx-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">Utilisateurs</h1>

				<Button @click="handleCreateOrEditUser"> + Ajouter un utilisateur </Button>
			</div>

			<Search @search="handleGlobalSearch" />
		</div>

		<DataTable
			:value="users"
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
			<template #empty>
				<p class="flex items-center justify-center p-5 text-lg font-bold">
					Aucun résultats
				</p>
			</template>

			<template #header>
				<div class="flex mb-4">
					<Button
						link
						class="py-3 pb-4 px-4 rounded-none outline-none"
						:pt="{
							root: {
								class:
									queryParams.search.role === null
										? 'border-0 border-b border-b-2 border-b-primary-400 text-primary-400'
										: 'border-none',
							},
						}"
						@click.prevent="handleChangeRole(null)"
					>
						Toutes
					</Button>

          <template
            v-for="(label, id) in USER_ROLES.labels"
            :key="id"
          >
            <Button
              link
              class="py-3 pb-4 px-4 rounded-none outline-none"
              :pt="{root: {class: queryParams.search.role === id ? 'border-0 border-b border-b-2 border-b-primary-400 text-primary-400' : 'border-none'}}"
              @click.prevent="handleChangeRole(id)"
            >
              {{ label }}
            </Button>
          </template>
        </div>
      </template>

        <Column header="Nom" field="name" :sortable="true" sort-field="name" />

        <Column header="Email" field="email" :sortable="true" sort-field="email" />

			<Column #body="slotProps" header="Action(s)" class="w-1/4">
				<div class="flex items-center gap-2">
                    <Button
                        v-tooltip="{ value: 'Éditer', class: 'tooltip-normal' }"
                        v-if="authStore.isRoot() || slotProps.data.role !== 1"
                        link
                        label="Modifier"
                        @click.prevent="handleCreateOrEditUser(slotProps.data)"
                    >
                        <i class="pi pi-pencil" />
                    </Button>
                    <Button
                        v-tooltip="{ value: 'Supprimer', class: 'tooltip-normal' }"
                        v-if="authStore.isRoot() || slotProps.data.role !== 1"
                        link
                        label="Supprimer"
                        @click.prevent="handleDeleteUser(slotProps.data)"
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

import USER_ROLES from "../../../enums/user-role";

import { useRouter } from "vue-router";
import { useConfirm } from "primevue/useconfirm";

import { storeToRefs } from "pinia";
import { useUsersStore } from "../../../store/users";

import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";
import Search from "../../../components/partials/backoffice/search.vue";

import useDatatableActions from "../../../composables/datatable-actions";

import { UserType } from "../../../types/user";

const router = useRouter();
const confirm = useConfirm();

const usersStore = useUsersStore();
const usersRefs = storeToRefs(usersStore);
const pagination = usersRefs.pagination;

const isFetchListPending = usersRefs.isFetchListPending;
const users = usersRefs.list;

const breadCrumbsFirstItem = computed(() => {
	return { label: "Accueil", route: "/admin" };
});
const breadCrumbsItems = computed(() => [{ label: "Utilisateurs" }]);

const queryParams = ref({
	search: {
		search: null,
		role: null,
	},
	includes: [],
	sort_by: null,
	desc: false,
});

const {
	handlePageChange,
	handleSortChange,
	handleGlobalSearch,
	handleChangeRole,
} = useDatatableActions(pagination, queryParams, usersStore.getItems);

onBeforeMount(() => {
	usersStore.getItems();
});

const handleDeleteUser = (user: UserType) => {
	confirm.require({
		message: "Êtes vous sur de vouloir supprimer ?",
		header: "Confirmation",
		icon: "pi pi-exclamation-triangle",
		acceptLabel: "Supprimer",
		rejectLabel: "Annuler",
		acceptClass: "p-button-danger",
		accept: () => {
			usersStore.deleteItem(user.id);
		},
	});
};

const handleCreateOrEditUser = (user: UserType) => {
	usersRefs.single.value = null;
	router.push({ name: "user-save", params: user ? { id: user.id } : {} });
};
</script>
