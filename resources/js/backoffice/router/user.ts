import { RouteRecordRaw } from "vue-router";

import List from "../views/backoffice/users/List.vue";
import Save from "../views/backoffice/users/Save.vue";

const module: Array<RouteRecordRaw> = [
	{
		path: "/admin/users",
		children: [
			{
				path: "",
				name: "users",
				component: List,
			},
			{
				path: "/admin/users/:id?/save",
				name: "user-save",
				component: Save,
			},
		],
	},
];

export default module;
