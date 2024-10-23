import { defineStore, storeToRefs } from "pinia";
import { BaseStore } from "./base";
import { StepType } from "../types/step";
import { BaseStoreType } from "../types/base-store";
import { ref } from "vue";
import { useConfigsStore } from "../store/configs";
import Axios from "axios";
import { useFormsStore } from "./forms";

export const useStepsStore = defineStore("steps", () => {
	const resourceName = "steps";
	const baseUrl = "/api/formSteps";

	const baseStore: BaseStoreType = new BaseStore<StepType>({
		resourceName,
		baseUrl,
		useStore: useStepsStore(),
	});

	const isAddSectionPending = ref<boolean>(false);

	const addSection = (step_id: number) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		isAddSectionPending.value = true;

		return Axios.post(
			configRefs.appUrl.value +
				baseUrl +
				"/" +
				step_id +
				"/addSection?include=sections,sections.fields",
			{ include: "sections" },
		)
			.then((response) => {
				const index = useFormsStore().single.steps.findIndex(
					(item: any) => item.id === response.data.data.id,
				);
				if (index !== -1) useFormsStore().single.steps[index] = response.data.data;
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
				isAddSectionPending.value = false;
			});
	};

	return {
		...baseStore,
		addSection,
		isAddSectionPending,
	};
});
