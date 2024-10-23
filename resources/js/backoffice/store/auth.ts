import { defineStore, storeToRefs } from "pinia";

import { ref } from "vue";
import Axios from "axios";

import { UserType } from "../types/user";

import { useConfigsStore } from "../store/configs";
import UserRole from "../enums/user-role";

export const useAuthStore = defineStore("auth", () => {
	const configStore = useConfigsStore();
	const configRefs = storeToRefs(configStore);

	const authUser = ref<UserType | null>();

	const isAuthPending = ref(false);
	const isLoginPending = ref(false);
	const isRegisterPending = ref(false);
	const isResetLinkPending = ref(false);
	const isResetPasswordPending = ref(false);

	const baseUrl = ref(configRefs.appUrl.value);
	const errors = ref([]);
	const token = ref<null | string | undefined>(undefined);
	const beforeLoginRoute = ref<string>();

	const getAuthUser = async () => {
		isAuthPending.value = true;

		const response = await Axios.get(`${baseUrl.value}/api/auth/user`);
		authUser.value = response.data.data;

		return response.data.data;
	};

	const login = async (credentials: {
		email: string;
		password: string;
		remember: boolean;
	}) => {
		errors.value = [];
		isLoginPending.value = true;

		return Axios.get("/sanctum/csrf-cookie")
			.then(() =>
				Axios.post(`${baseUrl.value}/login`, credentials)
					.then(() => {
						getAuthUser();
						// TODO: change regarding role
						window.location.replace("/admin");
					})
					.catch((error) => {
						if (error.response.status === 422) {
							errors.value = error.response.data.errors;
						}
					}) // mostly credentials didn't work
					.finally(() => {
						isLoginPending.value = false;
					}),
			)
			.catch((error) => console.warn(error));
	};

	const logout = async () => {
		isAuthPending.value = true;

		return Axios.post(`${baseUrl.value}/logout`)
			.then(() => {
				authUser.value = null;
				window.location.replace("/admin/login");
			})
			.catch((error) => console.warn(error))
			.finally(() => {
				isAuthPending.value = false;
			});
	};

	const sendResetLink = async (email: string) => {
		isResetLinkPending.value = true;

		return Axios.post(`${baseUrl.value}/forgot-password`, { email: email })
			.then((response) => {
				configStore.addToast({
					severity: "success",
					summary: "Bravo !",
					detail: response.data.message,
				});
			})
			.catch((error) => {
				if (error.response.status === 422) {
					console.warn(error.response.data.errors);
					errors.value = error.response.data.errors;
				}
			})
			.finally(() => {
				isResetLinkPending.value = false;
			});
	};

	const resetPassword = async (
		email: string,
		token: string,
		password: string,
		password_confirmation: string,
	) => {
		isResetPasswordPending.value = true;

		return Axios.post(`${baseUrl.value}/reset-password`, {
			token: token,
			email: email,
			password: password,
			password_confirmation: password_confirmation,
		})
			.then((response) => {
				configStore.addToast({
					severity: "success",
					summary: "Bravo !",
					detail: response.data.message,
				});
				window.location.replace("/admin");
			})
			.catch((error) => {
				if (error.response.status === 422) {
					console.warn(error.response.data.errors);
					errors.value = error.response.data.errors;
				}
			})
			.finally(() => {
				isResetPasswordPending.value = false;
			});
	};

	const isRoot = () => {
		return (
			Number(authUser?.value?.role) === Number(UserRole.values.ROOT.description)
		);
	};

	const isAdmin = () => {
		return (
			Number(authUser?.value?.role) <= Number(UserRole.values.ADMIN.description)
		);
	};

	const isModerator = () => {
		return (
			Number(authUser?.value?.role) <=
			Number(UserRole.values.MODERATOR.description)
		);
	};

	const isUser = () => {
		return (
			Number(authUser?.value?.role) <= Number(UserRole.values.USER.description)
		);
	};

	return {
		authUser,
		errors,
		isAuthPending,
		isLoginPending,
		isRegisterPending,
		isResetLinkPending,
		isResetPasswordPending,
		token,
		beforeLoginRoute,
		getAuthUser,
		login,
		logout,
		isRoot,
		isAdmin,
		isModerator,
		isUser,
		sendResetLink,
		resetPassword,
	};
});
