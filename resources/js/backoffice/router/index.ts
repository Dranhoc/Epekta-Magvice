import { createWebHistory, createRouter } from "vue-router";

import { useAuthStore } from "../store/auth";
import { storeToRefs } from "pinia";
import Landing from "../views/backoffice/Landing.vue";

const routeModules = import.meta.glob("./!(index).ts", { eager: true });

const routes = Object.values(routeModules).flatMap(
	(module) => (module as { default: any }).default,
);

const router = createRouter({
	history: createWebHistory(),
	scrollBehavior(to, from, savedPosition) {
		return {
			top: 0,
			behavior: "smooth",
		};
	},
	routes: [
		{
			path: "/admin",
			name: "admin",
			component: Landing,
		},
		...routes,
	],
});

router.beforeEach(async (to, from, next) => {
	const authStore = useAuthStore();
	const authRefs = storeToRefs(authStore);

	const authUser = authRefs.authUser;

	if (to.meta.allowAnonymous && to.path !== "/admin/login") {
		return next();
	}

	if (!authUser.value || !authUser.value.email) {
		await authStore
			.getAuthUser()
			.then(() => {
				if (!authUser.value || !authUser.value.email) {
					window.location.replace("/admin/login");
					return next("/admin/login");
				}

				if (to.path === "/admin/login") {
					return next();
				}

				if (to.meta.authorize && Array.isArray(to.meta.authorize)) {
					if (to.meta.authorize.includes(authUser.value.role)) {
						return next();
					} else {
						return next({ path: "/admin" });
					}
				}

				return next();
			})
			.catch(() => {
				if (to.path !== "/admin/login") {
					window.location.replace("/admin/login");
					return next("/admin/login");
				}
				return next();
			});
	} else {
		return next();
	}
});

export default router;
