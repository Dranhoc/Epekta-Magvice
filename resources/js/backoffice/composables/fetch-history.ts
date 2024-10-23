import Axios from "axios";
import { useConfigsStore } from "../store/configs";
import { storeToRefs } from "pinia";
import router from "../router";

interface FetchHistoryOptions {
	store: any;
	url: string;
	id: number;
}

export default ({ store, url, id }: FetchHistoryOptions) => {
	const configStore = useConfigsStore();
	const configRefs = storeToRefs(configStore);

	store.isFetchHistoryPending = true;

	return Axios.get(configRefs.appUrl.value + url + "/" + id + "?include=causer")
		.then((response) => {
			store.single.history = response.data.data;

			if (response.data.status === "error") {
				configStore.addToast({
					severity: "error",
					summary: "Oups...",
					detail: "Impossible de charger l'historique",
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
			store.isFetchHistoryPending = false;
		});
};
