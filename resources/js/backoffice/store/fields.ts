import { defineStore, storeToRefs } from "pinia";
import { BaseStore } from "./base";
import { FieldType } from "../types/field";
import { BaseStoreType } from "../types/base-store";

export const useFieldsStore = defineStore("fields", () => {
	const resourceName = "fields";
	const baseUrl = "/api/formFields";

	const baseStore: BaseStoreType = new BaseStore<FieldType>({
		resourceName,
		baseUrl,
		useStore: useFieldsStore(),
	});

	return {
		...baseStore,
	};
});
