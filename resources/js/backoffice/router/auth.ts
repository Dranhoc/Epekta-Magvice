import { RouteRecordRaw } from "vue-router";
import Login from "../views/backoffice/auth/Login.vue";
import ForgotPassword from "../views/backoffice/auth/ForgotPassword.vue";
import ResetPassword from "../views/backoffice/auth/ResetPassword.vue";

const module: Array<RouteRecordRaw> = [
	{
		path: "/admin/login",
		name: "login",
		component: Login,
		meta: {
			allowAnonymous: true,
		},
	},
	{
		path: "/admin/forgot-password",
		name: "forgot-password",
		component: ForgotPassword,
		meta: {
			allowAnonymous: true,
		},
	},
	{
		path: "/admin/reset-password",
		name: "reset-password",
		component: ResetPassword,
		meta: {
			allowAnonymous: true,
		},
	},
];

export default module;
