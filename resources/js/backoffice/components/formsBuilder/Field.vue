<template>
	<div
		:id="'field-' + field.id + '-container'"
		class="flex-1 flex flex-col gap-2"
	>
		<label
			for="name"
			class="text-dark-slate-600 uppercase tracking-widest flex items-center justify-between"
		>
			<span class="input-handle cursor-move flex-row flex items-center">
				<IconDraggableDots class="h-6 w-6 fill-cyan-700" />
				{{ field.label[locale] }}
			</span>
			<span class="flex gap-2">
				<Button
					severity="secondary"
					icon="pi pi-pencil"
					rounded
					size="small"
					@click.prevent="handleEditField"
				/>
				<Button
					severity="danger"
					icon="pi pi-trash"
					rounded
					size="small"
					@click.prevent="handleDeleteField"
				/>
			</span>
		</label>

		<InputText
			v-if="
				Number(field.type) === Number(types.values.TEXT.description) ||
				Number(field.type) === Number(types.values.EMAIL.description) ||
				Number(field.type) === Number(types.values.PASSWORD.description)
			"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			:placeholder="field.placeholder[locale]"
			:required="field.required"
			:type="getInputType()"
			class="w-full"
		/>

		<InputNumber
			v-if="field.type === Number(types.values.NUMBER.description)"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			:placeholder="field.placeholder[locale]"
			:required="field.required"
			:prefix="field.prefix + ' '"
			:suffix="' ' + field.suffix"
			type="number"
			class="w-full"
		/>

		<Textarea
			v-if="Number(field.type) === Number(types.values.TEXTAREA.description)"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			:placeholder="field.placeholder[locale]"
			:required="field.required"
			class="w-full"
		/>

		<Calendar
			v-if="
				Number(field.type) === Number(types.values.DATE.description) ||
				Number(field.type) === Number(types.values.TIME.description)
			"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			:placeholder="field.placeholder[locale]"
			:required="field.required"
			:time-only="Number(field.type) === Number(types.values.TIME.description)"
			date-format="dd/mm/yy"
			class="w-full"
		/>

		<Dropdown
			v-if="
				Number(field.type) === Number(types.values.SELECT.description) &&
				!field.has_multiple_choices
			"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			:placeholder="field.placeholder[locale]"
			:required="field.required"
			:options="
				field.options?.map((option) => {
					return {
						id: option.id,
						name:
							option.label[locale] +
							' (' +
							option.price +
							'€)' +
							' (' +
							option.amount +
							' max)',
					};
				})
			"
			option-label="name"
			class="w-full"
		/>

		<MultiSelect
			v-if="
				Number(field.type) === Number(types.values.SELECT.description) &&
				field.has_multiple_choices
			"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			:placeholder="field.placeholder[locale]"
			:required="field.required"
			:options="
				field.options?.map((option) => {
					return {
						id: option.id,
						name: option.label[locale] + ' (' + option.price + '€)',
					};
				})
			"
			option-label="name"
			class="w-full"
		/>

		<template
			v-if="
				Number(field.type) === Number(types.values.CHECKLIST.description) &&
				!field.has_multiple_choices
			"
		>
			<div class="flex flex-wrap gap-3">
				<div v-for="option in field.options" class="flex align-items-center">
					<RadioButton
						v-model="value"
						:input-id="'option-' + option.id"
						:name="'option-' + option.id"
						:value="'option-' + option.id"
					/>
					<label :for="'option-' + option.id" class="ml-2">{{
						option.label ? option.label[locale] + " (" + option.price + "€)" : ""
					}}</label>
				</div>
			</div>
		</template>

		<template
			v-if="
				Number(field.type) === Number(types.values.CHECKLIST.description) &&
				field.has_multiple_choices
			"
		>
			<div class="flex flex-wrap gap-3">
				<div v-for="option in field.options" class="flex align-items-center">
					<Checkbox
						v-model="value"
						:input-id="'option-' + option.id"
						:name="'option-' + option.id"
						:value="'option-' + option.id"
					/>
					<label :for="'option-' + option.id" class="ml-2">{{
						option.label ? option.label[locale] + " (" + option.price + "€)" : ""
					}}</label>
				</div>
			</div>
		</template>

		<Editor
			v-if="Number(field.type) === Number(types.values.EDITOR.description)"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			editor-style="height: 320px"
			class="w-full"
		/>

		<ToggleButton
			v-if="Number(field.type) === Number(types.values.SWITCH.description)"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			class="w-full"
		/>

		<FilePckr
			v-if="Number(field.type) === Number(types.values.FILEPCKR.description)"
			:id="'field-' + field.id"
			v-model="value"
			:name="field.name"
			:placeholder="field.placeholder[locale]"
			:required="field.required"
			class="w-full"
		/>

		<div v-if="Number(field.type) === Number(types.values.PHONE.description)">
			<div class="p-inputgroup">
				<Dropdown
					v-model="prefix"
					:options="prefixes"
					option-label="name"
					style="flex: 0 0 7rem"
					class="border-right-none"
				>
					<!-- the images can be updated with an api or a json file but we want to keep to codesandbox sample is simple -->
					<template #value="slotProps">
						<div v-if="slotProps.value" class="country-item country-item-value">
							<div>{{ slotProps.value.phone }}</div>
						</div>
						<span v-else>
							{{ slotProps.placeholder }}
						</span>
					</template>
					<template #option="slotProps">
						<div class="country-item">
							<div>
								{{ slotProps.option.name }}
								<span class="text-500">{{ slotProps.option.phone }}</span>
							</div>
						</div>
					</template>
				</Dropdown>
				<InputText v-model="phone" style="width: 8rem" type="text" />
			</div>
		</div>

		<small v-if="field.tooltip[locale]">{{ field?.tooltip[locale] }}</small>
	</div>

	<EditDialog
		:field="props.field"
		:is-edit-open="isEditOpen"
		:step="step"
		:section="section"
		:form="form"
		@update="handleUpdate"
		@close-dialog="handleCloseEditField"
	/>
</template>

<script lang="ts" setup>
import { useConfigsStore } from "../../store/configs";
import { useFieldsStore } from "../../store/fields"
import { storeToRefs } from "pinia";
import { ref } from "vue";
import FIELD_TYPES from "../../enums/field-types";

import EditDialog from "./Edit.vue";

import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputNumber from "primevue/inputnumber";
import Textarea from "primevue/textarea";
import Calendar from "primevue/calendar";
import MultiSelect from "primevue/multiselect";
import ToggleButton from "primevue/togglebutton";
import RadioButton from "primevue/radiobutton";
import Checkbox from "primevue/checkbox";

import FilePckr from "../file-pckr.vue";

import { useRoute, useRouter } from "vue-router";
import { StepType } from "../../types/step";
import { SectionType } from "../../types/section";
import { FieldType } from "../../types/field";
import Editor from "primevue/editor";

import IconDraggableDots from "../../../../svg/backoffice/draggabledots.svg?component";

const router = useRouter();
const route = useRoute();

const props = defineProps(["field", "form", "step", "section"]);

const field = props.field;

const value = ref();
const prefix = ref();
const phone = ref();

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const types = ref(FIELD_TYPES);

const fieldsStore = useFieldsStore();
const fieldsRefs = storeToRefs(fieldsStore);

const isEditOpen = ref(false);

const handleEditField = () => {
	fieldsRefs.single = field;
	isEditOpen.value = true;
};

const handleCloseEditField = () => {
	isEditOpen.value = false;
};

const key = ref(0);
const emits = defineEmits(["update"]);

const handleUpdate = () => {
	emits("update");
};

const getInputType = () => {
	if (Number(field.type) === Number(types.value.values.TEXT.description)) {
		return "text";
	}

	if (Number(field.type) === Number(types.value.values.EMAIL.description)) {
		return "email";
	}

	if (Number(field.type) === Number(types.value.values.PASSWORD.description)) {
		return "password";
	}
};

const handleDeleteField = () => {
	fieldsStore.deleteItem(field.id).then(() => {
		const index = props.form.steps
			.find((step: StepType) => step.id === props.step.id)
			.sections.find((section: SectionType) => section.id === props.section.id)
			.fields.findIndex((item: FieldType) => item.id === props.field.id);

		if (index !== -1) {
			props.form.steps
				.find((step: StepType) => step.id === props.step.id)
				.sections.find((section: SectionType) => section.id === props.section.id)
				.fields.splice(index, 1);
		}
	});
};

const prefixes = [
	{
		name: "Australia",
		code: "AU",
		phone: "+61",
		placeholder: "061 111 22 33",
	},
	{
		name: "Brazil",
		code: "BR",
		phone: "+55",
		placeholder: "055 111 22 33",
	},
	{
		name: "China",
		code: "CN",
		phone: "+86",
		placeholder: "086 111 22 33",
	},
	{
		name: "Egypt",
		code: "EG",
		phone: "+20",
		placeholder: "020 111 22 33",
	},
	{
		name: "France",
		code: "FR",
		phone: "+33",
		placeholder: "033 111 22 33",
	},
	{
		name: "Germany",
		code: "DE",
		phone: "+49",
		placeholder: "049 111 22 33",
	},
	{
		name: "India",
		code: "IN",
		phone: "+91",
		placeholder: "091 111 22 33",
	},
	{
		name: "Japan",
		code: "JP",
		phone: "+81",
		placeholder: "081 111 22 33",
	},
	{
		name: "Spain",
		code: "ES",
		phone: "+34",
		placeholder: "034 111 22 33",
	},
	{
		name: "United States",
		code: "US",
		phone: "+1",
		placeholder: "01 111 22 33",
	},
];
</script>
