import {defineStore} from 'pinia'
import {BaseStore} from "./base";
import {PostType} from "../types/post";
import {BaseStoreType} from "../types/base-store";

export const usePostsStore = defineStore('posts', () => {
    const resourceName = 'posts';
    const baseUrl = '/api/posts';

    const baseStore:BaseStoreType = new BaseStore<PostType>({
        resourceName,
        baseUrl,
        useStore: usePostsStore()
    });

    return {
        ...baseStore,
    };
});
