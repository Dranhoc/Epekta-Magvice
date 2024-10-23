import Save from "../views/backoffice/categories/Save.vue";
import List from "../views/backoffice/categories/List.vue";

import { RouteRecordRaw } from "vue-router";

const module: Array<RouteRecordRaw> = [
	{
		path: "/admin/categories",
		children: [
			{
				path: "",
				name: "categories",
				component: List,
				meta: {
					authorize: 1,
				},
			},
			{
				path: "/admin/categories/:id?/save",
				name: "category-save",
				component: Save,
				meta: {
					authorize: 1,
				},
			},
		],
	},
];

export default module;
