import Save from "../views/backoffice/posts/Save.vue"
import List from "../views/backoffice/posts/List.vue"

import { RouteRecordRaw } from "vue-router";

const module: Array<RouteRecordRaw> = [
    {
        path: '/admin/posts',
        children: [
            {
                path: '',
                name: 'posts',
                component: List,
            },
            {
                path: '/admin/posts/:id?/save',
                name: 'post-save',
                component: Save,
            },
        ]
    }
];

export default module;
