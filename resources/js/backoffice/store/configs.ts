import { defineStore, storeToRefs } from "pinia";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import { ref } from "vue";
import Axios from "axios";

export const useConfigsStore = defineStore("configs", () => {
	const locale = ref("fr");
	const langs = ref(["fr", "en"]);
	const appUrl = ref("");
	const toast = useToast();
	const confirm = ref();
	const config = ref({});
	const isFetchConfigPending = ref(false);

	const addToast = ({
		severity,
		summary,
		detail,
	}: {
		severity: "success" | "info" | "warn" | "error";
		summary: string;
		detail: string;
	}) => {
		toast.add({
			severity: severity,
			summary: summary,
			detail: detail,
			life: 3000,
		});
	};

	const getServerConfig = () => {
		isFetchConfigPending.value = true;

		return Axios.get(appUrl.value + "/api/config")
			.then((response) => {
				config.value = response.data;
			})
			.catch((error) => {
				console.warn(error);
				if (error.response.status === 404) {
					addToast({
						severity: "warn",
						summary: "Oups...",
						detail: "Resource(s) non trouvée",
					});
				}
				if (error.response.status === 400) {
					console.warn(error.response);
					addToast({
						severity: "error",
						summary: "Erreur",
						detail: error.response.data.message,
					});
				}
			})
			.finally(() => {
				isFetchConfigPending.value = false;
			});
	};

	return {
		locale,
		langs,
		appUrl,
		config,
		addToast,
		getServerConfig,
		isFetchConfigPending,
	};
});
