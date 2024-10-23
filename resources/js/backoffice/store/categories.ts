import { defineStore } from "pinia";
import { BaseStore } from "./base";
import { CategoryType } from "../types/category";
import { BaseStoreType } from "../types/base-store";

export const useCategoriesStore = defineStore("categories", () => {
	const resourceName = "categories";
	const baseUrl = "/api/categories";

	const baseStore: BaseStoreType = new BaseStore<CategoryType>({
		resourceName,
		baseUrl,
		useStore: useCategoriesStore(),
	});

	return {
		...baseStore,
	};
});
