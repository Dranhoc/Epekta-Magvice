import { defineStore } from "pinia";
import { BaseStore } from "./base";
import { BaseStoreType } from "../types/base-store";
import { UserType } from "../types/user";

export const useUsersStore = defineStore("users", () => {
	const resourceName = "users";
	const baseUrl = "/api/users";

	const baseStore: BaseStoreType = new BaseStore<UserType>({
		resourceName,
		baseUrl,
		useStore: useUsersStore(),
	});

	return {
		...baseStore,
	};
});
