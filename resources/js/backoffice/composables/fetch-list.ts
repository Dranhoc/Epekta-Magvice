import Axios from "axios";
import { useConfigsStore } from "@/backoffice/store/configs";
import { storeToRefs } from "pinia";
import router from "../router";

interface FetchDataOptions {
	store: any;
	url: string;
	resourceName: string;
	search?: Record<string, any>;
	desc?: boolean;
	sort_by?: string | null;
	includes?: string[];
	fields?: string[];
	appends?: string[];
	list?: boolean;
}

export default ({
	store,
	url,
	resourceName,
	search = {},
	desc = false,
	sort_by = null,
	includes = [],
	fields = [],
	appends = [],
	list = false,
}: FetchDataOptions) => {
	const configStore = useConfigsStore();
	const configRefs = storeToRefs(configStore);

	store.isFetchListPending = true;

	const filters: Record<string, any> = {};

	Object.entries(search).forEach((filter) => {
		filters[`filter[${filter[0]}]`] = filter[1] === null ? "null" : filter[1];
	});

	return Axios.get(configRefs.appUrl.value + url, {
		params: {
			page: store?.pagination?.current_page,
			per_page: store?.pagination?.per_page,
			...filters,
			...(sort_by !== null && { sort: `${desc ? "-" : ""}${sort_by}` }),
			...(includes.length > 0 && { include: includes.join("|") }),
			...(fields.length > 0 && { [`fields[${resourceName}]`]: fields.join(",") }),
			...(appends.length > 0 && { append: appends.join(",") }),
			list: list,
			translatable: 1,
			locale: configRefs.locale.value,
		},
	})
		.then((response) => {
			store.list = response.data.data;
			store.pagination = response.data.meta;
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
				console.warn(error.response);
				configStore.addToast({
					severity: "error",
					summary: "Erreur",
					detail: error.response.data.message,
				});
			}
		})
		.finally(() => {
			store.isFetchListPending = false;
		});
};
