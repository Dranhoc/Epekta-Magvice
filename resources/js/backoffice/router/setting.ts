import List from "../views/backoffice/settings/List.vue";

import { RouteRecordRaw } from "vue-router";

const module: Array<RouteRecordRaw> = [
	{
		path: "/admin/settings",
		name: "settings",
		component: List,
		meta: {
			authorize: 1,
		},
	},
];

export default module;
