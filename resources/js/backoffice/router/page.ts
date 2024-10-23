import Save from "../views/backoffice/pages/Save.vue";
import List from "../views/backoffice/pages/List.vue";

import { RouteRecordRaw } from "vue-router";

const module: Array<RouteRecordRaw> = [
	{
		path: "/admin/pages",
		children: [
			{
				path: "",
				name: "pages",
				component: List,
			},
			{
				path: "/admin/pages/:id?/save",
				name: "page-save",
				component: Save,
			},
		],
	},
];

export default module;
