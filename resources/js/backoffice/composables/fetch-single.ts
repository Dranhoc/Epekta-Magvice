import Axios from "axios";
import { useConfigsStore } from "@/backoffice/store/configs";
import { storeToRefs } from "pinia";
import router from "../router";

interface FetchDataOptions {
	store: any;
	url: string;
	id: string | number;
	includes?: string[];
}

export default ({ store, url, id, includes = [] }: FetchDataOptions) => {
	const configStore = useConfigsStore();
	const configRefs = storeToRefs(configStore);

	store.isFetchSinglePending = true;

	return Axios.get(configRefs.appUrl.value + url + "/" + id, {
		params: {
			...(includes.length > 0 && { include: includes.join(",") }),
			translatable: 1,
		},
	})
		.then((response) => {
			store.single = response.data.data;
		})
		.catch((error) => {
			console.warn(error);
			if (error?.response?.status === 404) {
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
			if (error?.response?.status === 400) {
				configStore.addToast({
					severity: "error",
					summary: "Erreur",
					detail: error.response.data.message,
				});
			}
			if (error?.code === "ERR_NETWORK") {
				configStore.addToast({
					severity: "error",
					summary: "Erreur",
					detail: "Erreur serveur",
				});
			}
		})
		.finally(() => {
			store.isFetchSinglePending = false;
		});
};
