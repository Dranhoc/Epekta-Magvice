import Save from "../views/backoffice/forms/Save.vue";
import List from "../views/backoffice/forms/List.vue";
import Show from "../views/backoffice/forms/Show.vue";
import Responses from "../views/backoffice/forms/Responses.vue";

import { RouteRecordRaw } from "vue-router";

const module: Array<RouteRecordRaw> = [
	{
		path: "/admin/forms",
		children: [
			{
				path: "",
				name: "forms",
				component: List,
			},
			{
				path: "/admin/forms/:id?/save",
				name: "form-save",
				component: Save,
			},
			{
				path: "/admin/forms/:id/show",
				name: "form-steps",
				component: Show,
			},
			{
				path: "/admin/forms/:id/responses",
				name: "form-responses",
				component: Responses,
			},
		],
	},
];

export default module;
