import { FieldType } from "./field";
interface SectionType {
	id: number;
	name: { fr?: string; en?: string };
	form_step_id: number;
	fields: [FieldType];
}

export type { SectionType };
