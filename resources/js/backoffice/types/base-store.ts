import { Ref } from "vue/dist/vue";

interface BaseStoreType {
	list: Ref;
	single: Ref;
	pagination: Ref<{
		current_page: number;
		total: number;
		last_page: number;
		per_page: number;
	}>;
	isFetchListPending: Ref<boolean>;
	isFetchSinglePending: Ref<boolean>;
	isSavePending: Ref<boolean>;
	isDeletePending: Ref<number | null>;
	isMovePending: Ref<boolean>;
	isLazyLoadPending: Ref<boolean>;
	isFetchHistoryPending: Ref<boolean>;
	isDuplicateSinglePending: Ref<boolean>;
	resourceName: Ref;
	baseUrl: Ref;
	useStore: any;
	getItems: Function;
	getItem: Function;
	deleteItem: Function;
	appendItem: Function;
	spliceItem: Function;
	sortList: Function;
	lazyLoadList: Function;
	getHistory: Function;
	duplicateItem: Function;
}

export type { BaseStoreType };
