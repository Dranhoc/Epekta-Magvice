interface CategoryType {
	id: number;
	name: { fr?: string; en?: string } | any;
	slug: string;
	created_at: any;
	updated_at: any;
	categories: CategoryType[];
}

export type { CategoryType };
