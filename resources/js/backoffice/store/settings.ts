import { defineStore } from "pinia";
import { BaseStore } from "./base";
import { SettingType } from "../types/setting";
import { BaseStoreType } from "../types/base-store";

export const useSettingsStore = defineStore("settings", () => {
	const resourceName = "settings";
	const baseUrl = "/api/settings";

	const baseStore: BaseStoreType = new BaseStore<SettingType>({
		resourceName,
		baseUrl,
		useStore: useSettingsStore(),
	});

	return {
		...baseStore,
	};
});
