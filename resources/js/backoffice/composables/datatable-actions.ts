import { watch } from "vue";

export default (pagination: any, queryParams: any, fetchAction: Function) => {
	const handlePageChange = async (event: any) => {
		pagination.value.per_page = event.rows;
		pagination.value.current_page = event.page + 1;

		await fetchAction({
			...queryParams.value,
			search: Object.fromEntries(
				Object.entries(queryParams.value.search).filter(([_, v]) => v != null),
			),
		});
	};

	const handleSortChange = (event: any) => {
		queryParams.value.sort_by = event.sortField;
		queryParams.value.desc = event.sortOrder === 1;
	};

	const handleGlobalSearch = (value: string) => {
		queryParams.value.search.search = value;
	};

	const handleChangeStatus = (newStatus: any) => {
		queryParams.value.search.status = newStatus;
	};

	const handleChangeRole = (newRole: any) => {
		queryParams.value.search.role = newRole;
	};

	watch(
		() => queryParams,
		async () => {
			await fetchAction({
				...queryParams.value,
				search: Object.fromEntries(
					Object.entries(queryParams.value.search).filter(([_, v]) => v != null),
				),
			});
		},
		{ deep: true },
	);

	return {
		handlePageChange,
		handleSortChange,
		handleGlobalSearch,
		handleChangeStatus,
		handleChangeRole,
	};
};
