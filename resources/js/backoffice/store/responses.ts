import { defineStore, storeToRefs } from "pinia";
import { BaseStore } from "./base";
import { ResponseType } from "../types/response";
import { BaseStoreType } from "../types/base-store";
import { useConfigsStore } from "../store/configs";
import Axios from "axios";

export const useResponsesStore = defineStore("responses", () => {
	const resourceName = "responses";
	const baseUrl = "/api/formResponses";

	const baseStore: BaseStoreType = new BaseStore<ResponseType>({
		resourceName,
		baseUrl,
		useStore: useResponsesStore(),
	});

	const changeStatus = (formResponse: ResponseType, status: number) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		return Axios.post(
			configRefs.appUrl.value + baseUrl + "/" + formResponse.id + "/status",
			{ status: status },
		)
			.then((response) => {
				formResponse.status = response.data.data.status;
				formResponse.order_id = response.data.data.order_id;
				configStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "Changement de statut réussi !",
				});
			})
			.catch((error) => {
				if (error.response.status === 404) {
					configStore.addToast({
						severity: "warn",
						summary: "Oups...",
						detail: "Resource(s) non trouvée",
					});
				}
				if (error.response.status === 400) {
					configStore.addToast({
						severity: "error",
						summary: "Erreur",
						detail: error.response.data.message,
					});
				}
			})
			.finally(() => {});
	};

	const linkToInvoicesPDF = (formResponse: ResponseType) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		return Axios.post(
			configRefs.appUrl.value + baseUrl + "/" + formResponse.id + "/invoices",
		)
			.then((response) => {
				configStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "La facture va se télécharger !",
				});
				return new Promise((resolve, reject) => {
					resolve(response.data.data);
				});
			})
			.catch((error) => {
				if (error.response.status === 404) {
					configStore.addToast({
						severity: "warn",
						summary: "Oups...",
						detail: "Resource(s) non trouvée",
					});
				}
				if (error.response.status === 400) {
					configStore.addToast({
						severity: "error",
						summary: "Erreur",
						detail: error.response.data.message,
					});
				}
			})
			.finally(() => {});
	};

	const linkToOrderPDF = (formResponse: ResponseType) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		return Axios.post(
			configRefs.appUrl.value + baseUrl + "/" + formResponse.id + "/order",
		)
			.then((response) => {
				configStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "Le bon de commande va se télécharger !",
				});
				return new Promise((resolve, reject) => {
					resolve(response.data.data);
				});
			})
			.catch((error) => {
				if (error.response.status === 404) {
					configStore.addToast({
						severity: "warn",
						summary: "Oups...",
						detail: "Resource(s) non trouvée",
					});
				}
				if (error.response.status === 400) {
					configStore.addToast({
						severity: "error",
						summary: "Erreur",
						detail: error.response.data.message,
					});
				}
			})
			.finally(() => {});
	};

	return {
		...baseStore,
		changeStatus,
		linkToInvoicesPDF,
		linkToOrderPDF,
	};
});
