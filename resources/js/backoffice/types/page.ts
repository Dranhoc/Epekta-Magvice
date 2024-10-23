interface PageType {
	id: number;
	url: string;
	title: string;
	seo_description: { fr?: string; en?: string };
	content: { fr?: string; en?: string };
}

export type { PageType };
