import Axios from "axios";
import { useConfigsStore } from "../store/configs";
import { storeToRefs } from "pinia";
import router from "../router";

interface ReorderDataOptions {
	store: any;
	url: string;
	list: any[];
}

export default ({ store, url, list }: ReorderDataOptions) => {
	const configStore = useConfigsStore();
	const configRefs = storeToRefs(configStore);

	store.isMovePending = true;

	return Axios.post(configRefs.appUrl.value + url, {
		ids: list.map((item) => item.id),
	})
		.then((response) => {
			store.single = response.data.data;

			if (response.data.status === "error") {
				configStore.addToast({
					severity: "error",
					summary: "Oups...",
					detail: "Resource indéplaçable",
				});
			} else {
				configStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "Resource déplacée",
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
			if (error.response.status === 403) {
				configStore.addToast({
					severity: "warn",
					summary: "Oups...",
					detail: "Action non autorisée",
				});
			}
			if (error.response.status === 401) {
				console.warn(error.response);
				configStore.addToast({
					severity: "error",
					summary: "Erreur",
					detail: "Vous n'avez pas accès",
				});
				router.go(0);
			}
			if (error.response.status === 400) {
				configStore.addToast({
					severity: "error",
					summary: "Erreur",
					detail: error.response.data.message,
				});
			}
		})
		.finally(() => {
			store.isMovePending = false;
		});
};
