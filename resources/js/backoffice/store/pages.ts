import { defineStore, storeToRefs } from "pinia";
import { BaseStore } from "./base";
import { PageType } from "../types/page";
import { BaseStoreType } from "../types/base-store";
import { useConfigsStore } from "../store/configs";
import Axios from "axios";
import { ref } from "vue";

export const usePagesStore = defineStore("pages", () => {
	const resourceName = "pages";
	const baseUrl = "/api/pages";

	const baseStore: BaseStoreType = new BaseStore<PageType>({
		resourceName,
		baseUrl,
		useStore: usePagesStore(),
	});

	const isMoveSliderPending = ref<boolean>(false);

	const moveSlider = (movedFields: [] = []) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		isMoveSliderPending.value = true;

		return Axios.post(configRefs.appUrl.value + baseUrl + "/moveSlider", {
			ids: movedFields.map((field: any) => field.id),
		})
			.then((response) => {
				if (response.data.status === "error") {
					configStore.addToast({
						severity: "warn",
						summary: "Oups...",
						detail: "Resource can't be moved",
					});
				} else {
					configStore.addToast({
						severity: "success",
						summary: "Bravo",
						detail: "Resource moved",
					});
				}
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
				isMoveSliderPending.value = false;
			});
	};

	const deleteSlider = (uuid: string) => {
		const configStore = useConfigsStore();
		const configRefs = storeToRefs(configStore);

		isMoveSliderPending.value = true;

		return Axios.post(configRefs.appUrl.value + baseUrl + "/deleteSlider", {
			uuid: uuid,
		})
			.then((response) => {
				if (response.data.status === "error") {
					configStore.addToast({
						severity: "warn",
						summary: "Oups...",
						detail: "Resource can't be deleted",
					});
				} else {
					configStore.addToast({
						severity: "success",
						summary: "Bravo",
						detail: "Resource deleted",
					});
				}
				if (
					usePagesStore().single.slider.data.findIndex(
						(media: any) => media.uuid === response.data.uuid,
					) !== -1
				) {
					usePagesStore().single.slider.data.splice(
						usePagesStore().single.slider.data.findIndex(
							(media: any) => media.uuid === response.data.uuid,
						),
						1,
					);
				}
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
				isMoveSliderPending.value = false;
			});
	};

	return {
		...baseStore,
		isMoveSliderPending,
		moveSlider,
		deleteSlider,
	};
});
