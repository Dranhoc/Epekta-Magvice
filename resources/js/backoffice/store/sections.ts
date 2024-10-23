import { defineStore, storeToRefs } from "pinia";
import { BaseStore } from "./base";
import { SectionType } from "../types/section";
import { BaseStoreType } from "../types/base-store";
import { ref } from "vue";
import { useConfigsStore } from "../store/configs";
import Axios from "axios";
import { useFormsStore } from "./forms";
import { StepType } from "../types/step";

export const useSectionsStore = defineStore("sections", () => {
	const resourceName = "sections";
	const baseUrl = "/api/formSections";

	const baseStore: BaseStoreType = new BaseStore<SectionType>({
		resourceName,
		baseUrl,
		useStore: useSectionsStore(),
	});

	const isAddFieldPending = ref<boolean>(false);
	const isSyncFieldsPending = ref<boolean>(false);

	const addField = (section: SectionType) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		isAddFieldPending.value = true;

		return Axios.post(
			configRefs.appUrl.value + baseUrl + "/" + section.id + "/addField",
			{ include: "fields" },
		)
			.then((response) => {
				const index = useFormsStore()
					.single.steps.find((step: StepType) => step.id === section.form_step_id)
					.sections.findIndex((item: any) => item.id === section.id);
				if (index !== -1)
					useFormsStore().single.steps.find(
						(step: StepType) => step.id === section.form_step_id,
					).sections[index] = response.data.data;
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
				isAddFieldPending.value = false;
			});
	};

	const syncFields = (section: SectionType) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		isSyncFieldsPending.value = true;

		return Axios.post(
			configRefs.appUrl.value + baseUrl + "/" + section.id + "/syncFields",
			{ fields: section.fields.map((field) => field.id), include: "fields" },
		)
			.then((response) => {
				// toast if moved
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
				isSyncFieldsPending.value = false;
			});
	};

	return {
		...baseStore,
		addField,
		isAddFieldPending,
		syncFields,
		isSyncFieldsPending,
	};
});
