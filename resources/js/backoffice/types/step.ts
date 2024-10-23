import { SectionType } from "./section";

interface StepType {
	id: number;
	name: { fr?: string; en?: string };
	form_id: number;
	sections: [SectionType];
}

export type { StepType };
