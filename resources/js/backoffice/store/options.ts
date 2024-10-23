import { defineStore } from "pinia";
import { BaseStore } from "./base";
import { OptionType } from "../types/option";
import { BaseStoreType } from "../types/base-store";

export const useOptionsStore = defineStore("options", () => {
	const resourceName = "options";
	const baseUrl = "/api/fieldOptions";

	const baseStore: BaseStoreType = new BaseStore<OptionType>({
		resourceName,
		baseUrl,
		useStore: useOptionsStore(),
	});

	return {
		...baseStore,
	};
});
