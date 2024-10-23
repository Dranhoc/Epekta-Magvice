<template>
	<Dialog
		:visible="props.isEditOpen"
		maximizable
		modal
		header="Modifier"
		:style="{ width: '50rem' }"
		:breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
		@update:visible="handleCloseDialog"
	>
		<TabView class="flex-1">
			<TabPanel>
				<template #header>
					<div class="flex gap-2 items-center">
						<span class="capitalize w-3/4">Champ</span>
					</div>
				</template>
				<div class="flex-col flex gap-6 mb-6">
					<div class="flex gap-6">
						<div class="flex-1 flex flex-col gap-2">
							<label for="type" class="text-dark-slate-600 uppercase tracking-wider"
								>Type</label
							>
							<Dropdown
								id="type"
								v-model="form.type"
								:options="typeOptions"
								option-label="name"
								placeholder="Choisissez un type"
								:class="form.invalid('type') ? 'p-invalid' : ''"
							/>
							<small v-if="form.invalid('type')" id="text-error" class="p-error">
								{{ form.errors.type }}
							</small>
						</div>

						<div class="flex-1 flex flex-col gap-2">
							<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
								>Label</label
							>
							<InputText
								id="label"
								v-model="form.label[locale]"
								type="label"
								name="label"
								:class="form.invalid('label') ? 'p-invalid' : ''"
								@change="form.validate('label')"
							/>
							<small v-if="form.invalid('label')" id="text-error" class="p-error">
								{{ form.errors.label }}
							</small>
						</div>
					</div>

					<div class="flex gap-6">
						<div class="flex-1 flex flex-col gap-2">
							<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
								>Placeholder</label
							>
							<InputText
								id="placeholder"
								v-model="form.placeholder[locale]"
								type="placeholder"
								name="placeholder"
								:class="form.invalid('placeholder') ? 'p-invalid' : ''"
								@change="form.validate('placeholder')"
							/>
							<small
								v-if="form.invalid('placeholder')"
								id="text-error"
								class="p-error"
							>
								{{ form.errors.placeholder }}
							</small>
						</div>

						<div class="flex-1 flex flex-col gap-2">
							<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
								>Tooltip</label
							>
							<InputText
								id="tooltip"
								v-model="form.tooltip[locale]"
								type="tooltip"
								name="tooltip"
								:class="form.invalid('tooltip') ? 'p-invalid' : ''"
								@change="form.validate('tooltip')"
							/>
							<small v-if="form.invalid('tooltip')" id="text-error" class="p-error">
								{{ form.errors.tooltip }}
							</small>
						</div>
					</div>

					<div class="flex gap-6">
						<div class="flex-1 flex flex-col gap-2">
							<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
								>Reference</label
							>
							<Dropdown
								id="model_reference"
								v-model="form.model_reference"
								type="model_reference"
								name="model_reference"
								:options="referenceOptions"
								option-label="name"
								filter
								show-clear
								:class="form.invalid('model_reference') ? 'p-invalid' : ''"
								@change="form.validate('model_reference')"
							>
								<template #option="slotProps">
									<div
										:class="
											slotProps.option.disabled &&
											slotProps.option.id !== form.model_reference.id
												? 'p-disabled text-red-600'
												: ''
										"
									>
										{{ slotProps.option.name }}
										<template
											v-if="
												slotProps.option.disabled &&
												slotProps.option.id !== form.model_reference.id
											"
										>
											(Utilisée ailleurs)
										</template>
									</div>
								</template>
							</Dropdown>
							<small
								v-if="form.invalid('model_reference')"
								id="text-error"
								class="p-error"
							>
								{{ form.errors.model_reference }}
							</small>
						</div>

						<div class="flex-1 flex flex-col gap-2 mb-6">
							<label for="column" class="text-dark-slate-600 uppercase tracking-wider"
								>Columns</label
							>
							<InputNumber
								id="column"
								v-model="form.column"
								name="column"
								:min="1"
								:max="6"
								:class="form.invalid('column') ? 'p-invalid' : ''"
								@change="form.validate('column')"
							/>
							<small v-if="form.invalid('column')" id="text-error" class="p-error">
								{{ form.errors.column }}
							</small>
						</div>
					</div>

					<div class="flex-1 flex flex-col gap-2 mb-6">
						<label for="column" class="text-dark-slate-600 uppercase tracking-wider"
							>Is Required</label
						>

						<ToggleButton
							id="isRequired"
							v-model="form.is_required"
							name="isRequired"
							:class="form.invalid('is_required') ? 'p-invalid' : ''"
							@change="form.validate('is_required')"
						/>

						<small v-if="form.invalid('is_required')" id="text-error" class="p-error">
							{{ form.errors.is_required }}
						</small>
					</div>

					<div
						v-if="
							Number(field.type) === Number(types.values.SELECT.description) ||
							Number(field.type) === Number(types.values.CHECKLIST.description)
						"
						class="flex-1 flex flex-col gap-2 mb-6"
					>
						<label
							for="isMultiple"
							class="text-dark-slate-600 uppercase tracking-wider"
							>Is Multiple</label
						>

						<ToggleButton
							id="isMultiple"
							v-model="form.has_multiple_choices"
							name="isMultiple"
							:class="form.invalid('has_multiple_choices') ? 'p-invalid' : ''"
							@change="form.validate('has_multiple_choices')"
						/>

						<small
							v-if="form.invalid('has_multiple_choices')"
							id="text-error"
							class="p-error"
						>
							{{ form.errors.has_multiple_choices }}
						</small>
					</div>

					<div
						v-if="Number(field.type) === Number(types.values.NUMBER.description)"
						class="flex-1 flex flex-col gap-2 mb-6"
					>
						<label for="prefix" class="text-dark-slate-600 uppercase tracking-wider"
							>Prefix</label
						>

						<InputText
							id="prefix"
							v-model="form.prefix"
							type="prefix"
							name="prefix"
							:class="form.invalid('prefix') ? 'p-invalid' : ''"
							@change="form.validate('prefix')"
						/>

						<small v-if="form.invalid('prefix')" id="text-error" class="p-error">
							{{ form.errors.prefix }}
						</small>
					</div>

					<div
						v-if="Number(field.type) === Number(types.values.NUMBER.description)"
						class="flex-1 flex flex-col gap-2 mb-6"
					>
						<label for="suffix" class="text-dark-slate-600 uppercase tracking-wider"
							>Suffix</label
						>

						<InputText
							id="suffix"
							v-model="form.suffix"
							type="suffix"
							name="suffix"
							:class="form.invalid('suffix') ? 'p-invalid' : ''"
							@change="form.validate('suffix')"
						/>

						<small v-if="form.invalid('suffix')" id="text-error" class="p-error">
							{{ form.errors.suffix }}
						</small>
					</div>
				</div>
			</TabPanel>
			<TabPanel>
				<template #header>
					<div class="flex gap-2 items-center">
						<span class="capitalize w-3/4">Rules</span>
					</div>
				</template>
				<div class="flex-col flex gap-6 mb-6">
					<div class="flex items-center mb-8">
						<ToggleButton
							id="is_shown"
							v-model="form.is_shown"
							name="is_shown"
							:class="form.invalid('is_shown') ? 'p-invalid' : ''"
							on-label="Montrer"
							off-label="Cacher"
							on-icon="pi pi-eye"
							off-icon="pi pi-eye-slash"
							@change="form.validate('is_shown')"
						/>

						<span class="mx-2">seulement si</span>

						<ToggleButton
							id="is_and"
							v-model="form.is_and"
							name="is_and"
							:class="form.invalid('is_and') ? 'p-invalid' : ''"
							on-label="toutes"
							off-label="une"
							@change="form.validate('is_and')"
						/>

						<span class="mx-2">de ces valeurs correspondent</span>
					</div>

					<div v-for="(rule, index) in form.rules" class="flex flex-col gap-6">
						<Button
							icon="pi pi-trash"
							severity="danger"
							@click.prevent="handleDeleteRule(rule, index)"
						/>

						<div class="flex gap-6">
							<div class="flex-1 flex flex-col gap-2">
								<label for="field" class="text-dark-slate-600 uppercase tracking-wider"
									>Champ</label
								>
								<Dropdown
									:id="'field-' + rule.id"
									v-model="rule.field"
									:options="fieldOptions"
									option-label="name"
									placeholder="Choisissez un champ"
									:class="form.invalid('rule.field') ? 'p-invalid' : ''"
								/>
								<small
									v-if="form.invalid('rule.field')"
									id="text-error"
									class="p-error"
								>
									{{ form.errors.rule }}
								</small>
							</div>

							<div class="flex-1 flex flex-col gap-2">
								<label
									for="operator"
									class="text-dark-slate-600 uppercase tracking-wider"
									>Type de comparaison</label
								>
								<Dropdown
									:id="'operator-' + rule.id"
									v-model="rule.operator"
									:options="operatorOptions"
									option-label="name"
									placeholder="Choisissez un champ"
									:class="form.invalid('rule.operator') ? 'p-invalid' : ''"
								/>
								<small
									v-if="form.invalid('rule.operator')"
									id="text-error"
									class="p-error"
								>
									{{ form.errors.rule }}
								</small>
							</div>

							<div class="flex-1 flex flex-col gap-2">
								<label for="option" class="text-dark-slate-600 uppercase tracking-wider"
									>Valeur</label
								>
								<Dropdown
									:id="'option-' + rule.id"
									v-model="rule.option"
									:options="
										rule.field?.options.map((option: any) => {
											return { id: option.id, name: option.label[locale] };
										}) || []
									"
									option-label="name"
									placeholder="Choisissez un champ"
									:class="form.invalid('rule.option') ? 'p-invalid' : ''"
								/>
								<small
									v-if="form.invalid('rule.option')"
									id="text-error"
									class="p-error"
								>
									{{ form.errors.rule }}
								</small>
							</div>
						</div>
					</div>
					<Button
						icon="pi pi-plus"
						severity="secondary"
						@click.prevent="handleAddRule"
					/>
				</div>
			</TabPanel>
			<TabPanel
				v-if="
					Number(field.type) === Number(types.values.SELECT.description) ||
					Number(field.type) === Number(types.values.CHECKLIST.description)
				"
			>
				<template #header>
					<div class="flex gap-2 items-center">
						<span class="capitalize w-3/4">Options</span>
					</div>
				</template>
				<div
					v-if="
						Number(field.type) === Number(types.values.SELECT.description) ||
						Number(field.type) === Number(types.values.CHECKLIST.description)
					"
					class="flex-1 flex flex-col gap-2 mb-6"
				>
					<h3 class="text-dark-slate-600 uppercase tracking-wider">Option(s)</h3>
					<Draggable
						v-model="field.options"
						class="flex flex-col gap-4"
						handle=".input-handle"
						:group="'sections'"
						item-key="id"
						@end="handleDragEnd"
					>
						<template #item="{ element, index }">
							<div class="flex justify-between">
								<span class="input-handle cursor-move flex-row flex items-center">
									<IconDraggableDots class="h-6 w-6 fill-cyan-700" />
								</span>
								<InputText
									:id="'label-' + element.id"
									v-model="element.label[locale]"
								/>
								<InputNumber
									:id="'price-' + element.id"
									v-model="element.price"
									:input-id="'price-' + element.id"
									placeholder="Ex.: 5"
									locale="fr-BE"
									mode="currency"
									currency="EUR"
								/>
								<InputNumber
									:id="'amount-' + element.id"
									v-model="element.amount"
									:input-id="'amount-' + element.id"
									:min="0"
									required
									placeholder="Ex.: 5"
									locale="fr-BE"
								/>
								<Button
									icon="pi pi-trash"
									severity="danger"
									@click.prevent="handleDeleteOption(element, index)"
								/>
							</div>
						</template>
					</Draggable>
					<Button
						icon="pi pi-plus"
						severity="secondary"
						@click.prevent="handleAddOption"
					/>
				</div>
			</TabPanel>
		</TabView>

		<div class="flex flex-row gap-2">
			<Button
				label="Annuler"
				severity="danger"
				size="small"
				@click.prevent="handleCloseDialog"
			>
				<i class="pi pi-times mr-2" />Annuler
			</Button>
			<Button
				label="Sauvegarder"
				severity="primary"
				size="small"
				@click.prevent="handleSubmit"
			>
				<i class="pi pi-check mr-2" />Sauvegarder
			</Button>
		</div>
	</Dialog>
</template>

<script lang="ts" setup>
import { computed, onMounted, ref, watch } from "vue";

import { useConfigsStore } from "@/backoffice/store/configs";
import { useFieldsStore } from "@/backoffice/store/fields";
import { useFormsStore } from "@/backoffice/store/forms";
import { useOptionsStore } from "@/backoffice/store/options";
import { useRulesStore } from "@/backoffice/store/rules";

import { storeToRefs } from "pinia";
import { useForm } from "laravel-precognition-vue";
import { useRoute, useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";

import InputNumber from "primevue/inputnumber";
import TabView from "primevue/tabview";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import TabPanel from "primevue/tabpanel";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import ToggleButton from "primevue/togglebutton";

import FIELD_TYPES from "../../enums/field-types";
import MODEL_REFERENCES from "../../enums/model-references";

import { FieldType } from "../../types/field";
import { StepType } from "../../types/step";
import { SectionType } from "../../types/section";
import { OptionType } from "../../types/option";
import { RuleType } from "../../types/rule";

import Draggable from "vuedraggable";

import IconDraggableDots from "../../../../svg/backoffice/draggabledots.svg?component";

const router = useRouter();
const route = useRoute();
const toast = useToast();

const props = defineProps(["field", "isEditOpen", "step", "section", "form"]);

const field = props.field;

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const types = ref(FIELD_TYPES);

const typeOptions = ref(
	Object.entries(types.value.labels).map((type) => {
		return { id: type[0], name: type[1] };
	}),
);

const references = ref(MODEL_REFERENCES);

const referenceOptions = computed(() => {
	let selectedReferences = props.form.steps
		.map((step: any) => step.sections.map((section: any) => section.fields))
		.flat(2)
		.map((field: any) => field.model_reference)
		.filter((model_reference: string) => model_reference);

	return Object.entries(references.value.labels)
		.map((reference) => {
			if (
				!selectedReferences.includes(reference[0]) ||
				reference[0] === field.model_reference
			) {
				return { id: reference[0], name: reference[1] };
			}
		})
		.filter((value) => value);
});

const operatorOptions = ref([
	{ id: "=", name: "égal" },
	{ id: "!=", name: "différent" },
]);

const optionOptions = computed(() => {
	if (form?.rules[0]?.field) {
		return form?.rules[0]?.field?.options.map((option: any) => {
			return { id: option.id, name: option.label[locale.value] };
		});
	}

	return [];
});

const fieldOptions = computed(() => {
	return props.form.steps
		.map((step: any) => step.sections.map((section: any) => section.fields))
		.flat(2)
		.filter((field: FieldType) => field.options && field.options.length > 0)
		.map((field: FieldType) => {
			return { ...field, name: field.label[locale.value] };
		});
});

const parseRules = () => {
	form.setData({
		rules: field.rules.map((rule: any) => {
			let ruleField = fieldOptions.value.find(
				(field: any) => Number(field.id) === rule.option.form_field_id,
			);
			let ruleOption =
				ruleField && ruleField.options
					? ruleField.options.find(
							(option: any) => Number(option.id) === rule.field_option_id,
						)
					: null;

			return {
				id: rule.id,
				field: ruleField,
				operator: operatorOptions.value.find(
					(operator: any) => operator.id === rule.operator,
				),
				option: ruleOption
					? { id: ruleOption.id, name: ruleOption.label[locale.value] }
					: {},
			};
		}),
	});
};

watch(fieldOptions, (before, after) => {
	if (field.rules?.length > 0 && fieldOptions.value.length > 0) {
		parseRules();
	}
});

onMounted(() => {
	if (field.rules?.length > 0 && fieldOptions.value.length > 0) {
		parseRules();
	}
});

const form = useForm(
	"patch",
	"/api/formFields/" + field.id + "?include=options,rules,rules.option",
	{
		...field,
		type: typeOptions.value.find(
			(type: any) => Number(type.id) == Number(field.type),
		),
		model_reference: referenceOptions.value.find(
			(model_reference: any) => model_reference.id === field.model_reference,
		),
	},
);

const fieldsStore = useFieldsStore();
const fieldsRefs = storeToRefs(fieldsStore);

const optionsStore = useOptionsStore();

const handleAddOption = () => {
	field.options.push({
		label: {
			fr: "option " + (field.options.length + 1),
			en: "option " + (field.options.length + 1),
		},
		price: 0,
		amount: 0,
	});
};

const handleDeleteOption = (option: OptionType, index: number | string) => {
	if (option.id) {
		optionsStore.deleteItem(option.id).then(() => {
			field.options.splice(index, 1);
		});
	} else {
		field.options.splice(index, 1);
	}
};

const emits = defineEmits(["update", "closeDialog"]);

const handleSubmit = () => {
	fieldsRefs.isSavePending.value = true;

	let untouchedData = form.data();

	if (!untouchedData.model_reference) {
		toast.add({
			severity: "warn",
			summary: "Attention",
			detail: "La référence n'est pas sélectionnée",
			life: 8000,
		});
	}

	form
		.setData({
			type: form.type ? form.type.id : null,
			model_reference: form.model_reference ? form.model_reference.id : null,
			options: field.options
				? field.options.map((option: any) =>
						option.amount === null ? { ...option, amount: 0 } : option,
					)
				: null,
		})
		.submit()
		.then((response: any) => {
			toast.add({
				severity: "success",
				summary: "Bravo",
				detail: "Le champ a bien été modifié",
				life: 8000,
			});
			emits("closeDialog");

			const index = useFormsStore()
				.single.steps.find((step: StepType) => step.id === props.step.id)
				.sections.find((section: SectionType) => section.id === props.section.id)
				.fields.findIndex((item: any) => item.id === field.id);

			if (index !== -1) {
				useFormsStore()
					.single.steps.find((step: StepType) => step.id === props.step.id)
					.sections.find(
						(section: SectionType) => section.id === props.section.id,
					).fields[index] = response.data.data;

				emits("update");
			}
		})
		.catch((error: any) => {
			if (error.response.status === 422) {
				toast.add({
					severity: "warn",
					summary: "Attention",
					detail: "Il y a des erreurs dans le formulaire",
					life: 8000,
				});
			}
			if (error.response.status === 500) {
				toast.add({
					severity: "error",
					summary: "Attention",
					detail: "Il y a une erreur serveur",
					life: 8000,
				});
			}
			form.setData({ ...untouchedData });
		})
		.finally(() => {
			fieldsRefs.isSavePending.value = false;
		});
};

const handleCloseDialog = () => {
	emits("closeDialog");
};

const handleAddRule = () => {
	form.rules.push({
		field: null,
		option: null,
		operator: null,
	});
};

const rulesStore = useRulesStore();

const handleDeleteRule = (rule: RuleType, index: number | string) => {
	if (rule.id) {
		rulesStore.deleteItem(rule.id).then(() => {
			form.rules.splice(index, 1);
		});
	} else {
		form.rules.splice(index, 1);
	}
};

const handleDragEnd = () => {
	optionsStore.sortList(field.options);
};
</script>
