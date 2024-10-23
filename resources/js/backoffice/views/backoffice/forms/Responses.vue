<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div class="mx-10">
		<div class="flex mb-20 justify-between">
			<div class="flex items-center">
				<h1 class="mr-6 text-5xl uppercase font-title">Réponses</h1>

				<Button severity="secondary" @click.prevent="handleExport()">
					Export
				</Button>
			</div>

			<Search @search="handleGlobalSearch" />
		</div>

		<DataTable
			:value="responses"
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
			<template #empty> Aucune réponse pour l'instant </template>

			<Column header="ID" field="id" :sortable="false" />

			<Column #body="slotProps" header="Date de création" field="created_at">
				{{
					new Intl.DateTimeFormat("fr-BE").format(
						new Date(slotProps.data.created_at),
					)
				}}
			</Column>

			<Column header="Email" field="user.email" :sortable="false" />

			<Column header="Prénom" field="user.firstname" :sortable="false" />

			<Column header="Nom" field="user.lastname" :sortable="false" />

			<Column header="Total (€)" field="sum" :sortable="false" />

			<Column header="Numéro de commande" field="order_id" :sortable="false" />

			<Column #body="slotProps" header="Statut" field="created_at">
				{{ formResponseStatuses.labels[slotProps.data.status] }}
			</Column>

			<Column key="actions" header="Action(s)">
				<template #body="slotProps">
					<div class="flex items-center gap-2">
						<Button
							v-if="slotProps.data.order_id"
							severity="secondary"
							size="small"
							class="mr-2"
							@click.prevent="handleDownloadOrder(slotProps.data)"
						>
							Bon de commande
						</Button>

						<Button
							v-if="
								String(slotProps.data.status) ===
									formResponseStatuses.values.PAID.description && slotProps.data.order_id
							"
							severity="secondary"
							size="small"
							class="mr-2"
							@click.prevent="handleDownloadInvoices(slotProps.data)"
						>
							Facture
						</Button>

						<Button
							v-if="
								String(slotProps.data.status) ===
								formResponseStatuses.values.WAITING.description
							"
							severity="secondary"
							size="small"
							class="mr-2"
							@click.prevent="
								handleChangeStatus(
									slotProps.data,
									formResponseStatuses.values.PAID.description,
								)
							"
						>
							Payer
						</Button>

						<Button
							v-if="
								String(slotProps.data.status) ===
								formResponseStatuses.values.WAITING.description
							"
							severity="danger"
							size="small"
							class="mr-2"
							@click.prevent="
								handleChangeStatus(
									slotProps.data,
									formResponseStatuses.values.CANCELED.description,
								)
							"
						>
							Annuler
						</Button>

						<Button
							v-tooltip.top="{ value: 'Voir', class: 'tooltip-normal' }"
							severity="secondary"
							size="small"
							class="mr-2"
							@click.prevent="handleShowResponse(slotProps.data)"
						>
							<i class="pi pi-eye" />
						</Button>
						<Button
							v-tooltip.top="{ value: 'Supprimer', class: 'tooltip-normal' }"
							label="Supprimer"
							severity="danger"
							size="small"
							class="mr-2"
							@click.prevent="handleDeleteResponse(slotProps.data)"
						>
							<i class="pi pi-trash" />
						</Button>
					</div>
				</template>
			</Column>
		</DataTable>
	</div>
</template>

<script setup lang="ts">
import { ref, onBeforeMount, computed } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import { useConfigsStore } from "../../../store/configs";
import {useFormsStore } from "../../../store/forms"
import {useResponsesStore} from "../../../store/responses"
import { storeToRefs } from "pinia";
import { useRoute, useRouter } from "vue-router";
import { useConfirm } from "primevue/useconfirm";
import FORM_RESPONSE_STATUSES from "../../../enums/form-response-statuses";
import { ResponseType } from "../../../types/response";

import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";
import Search from "../../../components/partials/backoffice/search.vue";
import useDatatableActions from "../../../composables/datatable-actions";

const route = useRoute();
const router = useRouter();
const confirm = useConfirm();

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const formResponseStatuses = ref(FORM_RESPONSE_STATUSES);

const formsStore = useFormsStore();
const formsRefs = storeToRefs(formsStore);
const form = ref(formsRefs.single);

const responsesStore = useResponsesStore();
const responsesRefs = storeToRefs(responsesStore);
const pagination = responsesRefs.pagination;
const isFetchListPending = responsesRefs.isFetchListPending;
const responses = ref(responsesRefs.list);

const breadCrumbsFirstItem = computed(() => {
	return { label: "Formulaire(s)", to: "/admin/forms" };
});

const breadCrumbsItems = computed(() => {
	let items: { label: string; to?: { name: string; params?: any } }[] = [];

	if (form?.value?.id) {
		items.push({
			label: form?.value?.name[locale.value] || "N/A",
			to: { name: "forms" },
		});
	}

	items.push({ label: "Réponse(s)" });

	return items;
});

const queryParams = ref({
	search: {
		form_id: route.params.id,
		search: null,
	},
	includes: ["user"],
	sort_by: null,
	desc: false,
});

const { handlePageChange, handleSortChange, handleGlobalSearch } =
	useDatatableActions(pagination, queryParams, responsesStore.getItems);

onBeforeMount(async () => {
	await formsStore.getItem({ id: String(route.params.id) });
	await responsesStore.getItems(queryParams.value);
});

const handleExport = () => {
	formsStore.linkToExport(form.value.id).then((data) => {
		window.location.href = data.url;
	});
};

const handleDownloadInvoices = (response: ResponseType) => {
	responsesStore.linkToInvoicesPDF(response).then((data) => {
		window.location.href = data.url;
	});
};

const handleDownloadOrder = (response: ResponseType) => {
	responsesStore.linkToOrderPDF(response).then((data) => {
		window.location.href = data.url;
	});
};

const handleChangeStatus = (response: ResponseType, status: string) => {
	confirm.require({
		message:
			"Êtes vous sur de vouloir changer le statut en " +
			formResponseStatuses.value.labels[status] +
			" ?",
		header: "Confirmation",
		icon: "pi pi-exclamation-triangle",
		acceptLabel: "Confirmer",
		rejectLabel: "Annuler",
		acceptClass: "p-button-danger",
		accept: () => responsesStore.changeStatus(response, Number(status)),
	});
};

const handleDeleteResponse = (response: ResponseType) => {
	confirm.require({
		message: "Êtes vous sur de vouloir supprimer ?",
		header: "Confirmation",
		icon: "pi pi-exclamation-triangle",
		acceptLabel: "Supprimer",
		rejectLabel: "Annuler",
		acceptClass: "p-button-danger",
		accept: () => responsesStore.deleteItem(response.id),
	});
};

const handleShowResponse = (response: ResponseType) => {
	router.push({ name: "response-show", params: { response_id: response.id } });
};
</script>
