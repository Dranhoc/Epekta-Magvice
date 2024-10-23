import { StepType } from "./step";

interface FormType {
	id: number;
	name: { fr?: string; en?: string } | any;
	slug: { fr?: string; en?: string } | any;
	steps: [StepType];
}

export type { FormType };
