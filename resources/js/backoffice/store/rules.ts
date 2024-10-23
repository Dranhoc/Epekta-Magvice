import { defineStore } from "pinia";
import { BaseStore } from "./base";
import { RuleType } from "../types/rule";
import { BaseStoreType } from "../types/base-store";

export const useRulesStore = defineStore("rules", () => {
	const resourceName = "rules";
	const baseUrl = "/api/fieldRules";

	const baseStore: BaseStoreType = new BaseStore<RuleType>({
		resourceName,
		baseUrl,
		useStore: useRulesStore(),
	});

	return {
		...baseStore,
	};
});
