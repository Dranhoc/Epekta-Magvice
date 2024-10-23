import { defineStore } from "pinia";
import { BaseStore } from "./base";
import { ContentType } from "../types/content";
import { BaseStoreType } from "../types/base-store";

export const useContentsStore = defineStore("contents", () => {
	const resourceName = "contents";
	const baseUrl = "/api/contents";

	const baseStore: BaseStoreType = new BaseStore<ContentType>({
		resourceName,
		baseUrl,
		useStore: useContentsStore(),
	});

	return {
		...baseStore,
	};
});
