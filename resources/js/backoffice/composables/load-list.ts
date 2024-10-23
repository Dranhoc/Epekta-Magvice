import Axios from "axios";
import { useConfigsStore } from "@/backoffice/store/configs";
import { storeToRefs } from "pinia";
import router from "../router";

interface LoadDataOptions {
	store: any;
	url: string;
	first: number;
	last: number;
	search: string;
}

export default ({ store, url, first, last, search }: LoadDataOptions) => {
	const configStore = useConfigsStore();
	const configRefs = storeToRefs(configStore);

	store.isLazyLoadPending = true;

	return Axios.get(
		configRefs.appUrl.value +
			url +
			"?first=" +
			first +
			"&last=" +
			last +
			"&search=" +
			search,
	)
		.then((response) => {
			store.list = response.data.data;
			store.total = response.data.total;

			if (response.data.status === "error") {
				configStore.addToast({
					severity: "error",
					summary: "Oups...",
					detail: "Impossible de charger cette selection",
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
			store.isLazyLoadPending = false;
		});
};
