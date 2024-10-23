import Axios from "axios";
import { useConfigsStore } from "@/backoffice/store/configs";
import { storeToRefs } from "pinia";
import router from "../router";

interface FetchDataOptions {
	store: any;
	url: string;
	id: string | number;
}

export default ({ store, url, id }: FetchDataOptions) => {
	store.isDeletePending = id;

	const configStore = useConfigsStore();
	const configRefs = storeToRefs(configStore);

	return Axios.delete(configRefs.appUrl.value + url + "/" + id)
		.then((response) => {
			store.spliceItem(id);
			configStore.addToast({
				severity: "success",
				summary: "Bravo",
				detail: "Suppression réussie !",
			});
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
			store.isDeletePending = null;
		});
};
