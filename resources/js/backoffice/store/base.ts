import { ref, shallowRef } from "vue";

import useFetchList from "../composables/fetch-list";
import useFetchSingle from "../composables/fetch-single";
import useDeleteSingle from "../composables/delete-single";
import useSortList from "../composables/sort-list";
import useLoadList from "../composables/load-list";
import useFetchHistory from "../composables/fetch-history";
import useDuplicateSingle from "../composables/duplicate-single";

interface Identifiable {
	id: number | string;
}

interface BaseStoreOptions {
	resourceName: string;
	baseUrl: string;
	useStore: any;
}
export class BaseStore<T extends Identifiable> {
	list = shallowRef<T[]>([]);
	total = ref<number>(0);
	single = ref<T | null>(null);
	pagination = ref({
		current_page: 1,
		total: 1,
		last_page: 1,
		per_page: 10,
	});

	isFetchListPending = ref<boolean>(false);
	isFetchSinglePending = ref(false);
	isSavePending = ref(false);
	isDeletePending = ref(null);
	isMovePending = ref(false);
	isLazyLoadPending = ref(false);
	isFetchHistoryPending = ref(false);
	isDuplicateSinglePending = ref(false);

	resourceName = ref("");
	baseUrl = ref("");
	useStore: any;

	constructor(options: BaseStoreOptions) {
		this.resourceName = ref(options.resourceName);
		this.baseUrl = ref(options.baseUrl);
		this.useStore = options.useStore;
	}

	getItems = (options = {}) => {
		return useFetchList({
			store: this.useStore,
			url: this.baseUrl.value,
			resourceName: this.resourceName.value,
			...options,
		});
	};

	getItem = (options: { id: number | string; includes?: [] }) => {
		return useFetchSingle({
			store: this.useStore,
			url: this.baseUrl.value,
			...options,
		});
	};

	deleteItem = (id: number | string) => {
		return useDeleteSingle({
			store: this.useStore,
			url: this.baseUrl.value,
			id,
		});
	};

	appendItem = (item: T) => {
		// TODO: update list
		this.list.value.push(item);
	};

	spliceItem = (id: number) => {
		const index = this.list.value.findIndex((item: T) => item.id === id);
		if (index !== -1) {
			this.list.value.splice(index, 1);
		}
	};

	sortList = (list: T[]) => {
		return useSortList({
			store: this.useStore,
			url: "/api/sort/" + this.resourceName.value,
			list,
		});
	};

	lazyLoadList = (first: number, last: number, search: string) => {
		return useLoadList({
			store: this.useStore,
			url: "/api/list/" + this.resourceName.value,
			first: first,
			last: last,
			search: search,
		});
	};

	getHistory = (id: number) => {
		return useFetchHistory({
			store: this.useStore,
			url: "/api/activities/" + this.resourceName.value,
			id: id,
		});
	};

	duplicateItem = (options: { id: number | string; includes?: [] }) => {
		return useDuplicateSingle({
			store: this.useStore,
			url: this.baseUrl.value,
			...options,
		});
	};
}
