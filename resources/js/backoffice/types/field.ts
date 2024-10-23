import { OptionType } from "./option";

interface FieldType {
	id: number;
	type: number;
	name: { fr?: string; en?: string } | any;
	label: { fr?: string; en?: string } | any;
	tooltip: { fr?: string; en?: string } | any;
	has_multiple_choices: boolean;
	is_required: boolean;
	prefix: string;
	suffix: string;
	model_reference: number;
	is_and: boolean;
	is_shown: boolean;
	with_label: boolean;
	options: [OptionType];
}

export type { FieldType };
