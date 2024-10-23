import List from "../views/backoffice/contents/List.vue";
import Save from "../views/backoffice/contents/Save.vue";

import { RouteRecordRaw } from "vue-router";

const module: Array<RouteRecordRaw> = [
	{
		path: "/admin/contents",
		children: [
			{
				path: "",
				name: "contents",
				component: List,
				meta: {
					authorize: 1,
				},
			},
			{
				path: "/admin/contents/:id?/save",
				name: "content-save",
				component: Save,
				meta: {
					authorize: 1,
				},
			},
		],
	},
];

export default module;
