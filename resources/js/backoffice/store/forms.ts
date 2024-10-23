import { defineStore, storeToRefs } from "pinia";
import { BaseStore } from "./base";
import { FormType } from "../types/form";
import { BaseStoreType } from "../types/base-store";
import { useConfigsStore } from "../store/configs";
import Axios from "axios";
import { ref } from "vue";

export const useFormsStore = defineStore("forms", () => {
	const resourceName = "forms";
	const baseUrl = "/api/forms";

	const baseStore: BaseStoreType = new BaseStore<FormType>({
		resourceName,
		baseUrl,
		useStore: useFormsStore(),
	});

	const isAddStepPending = ref<boolean>(false);

	const addStep = (form_id: number) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		isAddStepPending.value = true;

		return Axios.post(
			configRefs.appUrl.value + baseUrl + "/" + form_id + "/addStep",
			{ include: "steps,steps.sections" },
		)
			.then((response) => {
				useFormsStore().single = response.data.data;
			})
			.catch((error) => {
				console.warn(error);
				if (error.response.status === 404) {
					configStore.addToast({
						severity: "warn",
						summary: "Oups...",
						detail: "Resource(s) non trouvée",
					});
				}
				if (error.response.status === 400) {
					console.warn(error.response);
					configStore.addToast({
						severity: "error",
						summary: "Erreur",
						detail: error.response.data.message,
					});
				}
			})
			.finally(() => {
				isAddStepPending.value = false;
			});
	};

	const linkToExport = (form_id:number) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		return Axios.post(
			configRefs.appUrl.value + baseUrl + "/" + form_id + "/export",
		)
			.then((response) => {
				configStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "L'export va se télécharger !",
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
		addStep,
		linkToExport,
		isAddStepPending,
	};
});
