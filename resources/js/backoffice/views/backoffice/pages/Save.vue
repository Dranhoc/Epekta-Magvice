<template>
	<Breadcrumbs
		:bread-crumbs-first-item="breadCrumbsFirstItem"
		:bread-crumbs-items="breadCrumbsItems"
	/>

	<div
		v-if="isFetchPending || isSavePending"
		class="h-[85.5vh] w-full flex items-center justify-center bg-black/75"
	>
		<ProgressSpinner />
	</div>

	<div v-else class="mx-10 mb-10 py-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-2 text-5xl uppercase font-title font-bold">
					{{ page?.id ? "Modifier" : "Ajouter" }}
				</h1>
			</div>
		</div>

		<div class="flex flex-col gap-4">
			<fieldset class="flex-col flex gap-8 mb-6">
				<h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">
					Informations générales
				</h3>
				<div class="flex-1 flex flex-col gap-2">
					<label for="title" class="text-dark-slate-600 uppercase tracking-widest"
						>Titre</label
					>
					<InputText
						id="title"
						v-model="form.title[locale]"
						type="text"
						name="title"
						:class="form.invalid('title') ? 'p-invalid' : ''"
						@change="form.validate('title')"
					/>
					<small v-if="form.invalid('title')" id="text-error" class="p-error">
						{{ form.errors.title }}
					</small>
				</div>

				<div class="flex-1 flex flex-col gap-2">
					<label for="slug" class="text-dark-slate-600 uppercase tracking-widest"
						>Slug</label
					>
					<InputText
						id="slug"
						v-model="form.slug[locale]"
						type="text"
						name="slug"
						:disabled="form.slug[locale] === 'home'"
						:class="form.invalid('slug') ? 'p-invalid' : ''"
						@change="form.validate('slug')"
					/>
					<small v-if="form.invalid('slug')" id="text-error" class="p-error">
						{{ form.errors.slug }}
					</small>
				</div>

				<div class="flex-1 flex flex-col gap-2">
					<label for="method" class="text-dark-slate-600 uppercase tracking-widest">Méthode</label >
					<InputText
						id="method"
						v-model="form.method"
						type="text"
						name="method"
						:class="form.invalid('method') ? 'p-invalid' : ''"
						@change="form.validate('method')"
					/>
					<small v-if="form.invalid('method')" id="text-error" class="p-error">
						{{ form.errors.method }}
					</small>
				</div>

				<div class="flex-1 flex flex-col gap-2">
					<label for="template" class="text-dark-slate-600 uppercase tracking-widest"
						>Template</label
					>
					<InputText
						id="template"
						v-model="form.template"
						type="text"
						name="template"
						:class="form.invalid('template') ? 'p-invalid' : ''"
						@change="form.validate('template')"
					/>
					<small v-if="form.invalid('template')" id="text-error" class="p-error">
						{{ form.errors.template }}
					</small>
				</div>
			</fieldset>

			<fieldset class="flex-col flex gap-8 mb-6">
				<h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">SEO</h3>

				<div class="flex-1 flex flex-col gap-2">
					<label for="seo_type" class="text-dark-slate-600 uppercase tracking-widest"
						>Type</label
					>
					<InputText
						id="seo_type"
						v-model="form.seo_type"
						type="text"
						name="seo_type"
						:class="form.invalid('seo_type') ? 'p-invalid' : ''"
						@change="form.validate('seo_type')"
					/>
					<small v-if="form.invalid('seo_type')" id="text-error" class="p-error">
						{{ form.errors.seo_type }}
					</small>
				</div>

				<div class="flex-1 flex flex-col gap-2">
					<label
						for="seo_title"
						class="text-dark-slate-600 uppercase tracking-widest"
						>Titre</label
					>
					<InputText
						id="seo_title"
						v-model="form.seo_title[locale]"
						type="text"
						name="seo_title"
						:class="form.invalid('seo_title') ? 'p-invalid' : ''"
						@change="form.validate('seo_title')"
					/>
					<small v-if="form.invalid('seo_title')" id="text-error" class="p-error">
						{{ form.errors.seo_title }}
					</small>
				</div>

				<div class="flex-1 flex flex-col gap-2">
					<label
						for="seo_description"
						class="text-dark-slate-600 uppercase tracking-widest"
						>Description</label
					>
					<Textarea
						id="seo_description"
						v-model="form.seo_description[locale]"
						name="seo_description"
						:class="form.invalid('seo_description') ? 'p-invalid' : ''"
						@change="form.validate('seo_description')"
					/>
					<small
						v-if="form.invalid('seo_description')"
						id="text-error"
						class="p-error"
					>
						{{ form.errors.seo_description }}
					</small>
				</div>

				<div class="flex-1 flex flex-col gap-2">
					<label for="seo_image" class="text-dark-slate-600 uppercase tracking-wider"
						>Illustration</label
					>
					<FilePckr
						id="seo_image"
						v-model="form.seo_image"
						name="seo_image"
						:current-url="form.seo_image?.original_url"
						@start-load="handleStartLoad"
						@end-load="handleEndLoad"
					/>
					<small v-if="form.invalid('seo_image')" id="text-error" class="p-error">
						{{ form.errors.seo_image }}
					</small>
				</div>
			</fieldset>

			<fieldset class="flex-col flex gap-8 mb-6">
				<h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Contenu</h3>

				<div class="flex-1 flex flex-col gap-2">
					<label for="content" class="text-dark-slate-600 uppercase tracking-widest"
						>Texte</label
					>
					<Editor
						id="content"
						v-model="form.content[locale]"
						name="content"
						:class="form.invalid('content') ? 'p-invalid' : ''"
						editor-style="height: 320px"
						@change="form.validate('content')"
					>
						<template #toolbar>
							<span class="ql-formats">
								<select class="ql-header">
									<option selected value="0">Paragraphe</option>
									<option value="1">Titre 1</option>
									<option value="2">Titre 2</option>
									<option value="3">Titre 3</option>
									<option value="4">Titre 4</option>
									<option value="5">Titre 5</option>
								</select>
							</span>
							<span class="ql-formats">
								<select class="ql-font">
									<option />
									<option value="serif" />
									<option value="monospace" />
								</select>
							</span>
							<span class="ql-formats">
								<button class="ql-bold" />
								<button class="ql-italic" />
								<button class="ql-underline" />
								<button class="ql-strike" />
							</span>
							<span class="ql-formats">
								<button class="ql-list" value="ordered" />
								<button class="ql-list" value="bullet" />
							</span>
							<span class="ql-formats">
								<select class="ql-align">
									<option selected />
									<option value="center" />
									<option value="right" />
									<option value="justify" />
								</select>
							</span>
							<span class="ql-formats">
								<button class="ql-clean" />
								<button class="ql-link" />
								<button class="ql-image" />
							</span>
						</template>
					</Editor>
					<small v-if="form.invalid('content')" id="text-error" class="p-error">
						{{ form.errors.content }}
					</small>
				</div>

				<div class="flex-1 flex flex-col gap-2">
					<label for="type" class="text-dark-slate-600 uppercase">Formulaire</label>
					<Select
						v-model="form.form"
						:options="formOptions"
						option-label="name"
						placeholder="Choisissez un formulaire"
						:class="form.invalid('form') ? 'p-invalid' : ''"
						@change="form.validate('form')"
					/>
					<small v-if="form.invalid('form')" id="text-error" class="p-error">
						{{ form.errors.form }}
					</small>
				</div>

				<h2 class="text-xl font-bold mb-6 flex flex-row items-center">Slider</h2>

				<div class="flex-1 flex flex-col gap-2">
					<label for="slider" class="text-dark-slate-600 uppercase tracking-wider"
						>Slider</label
					>
					<FilePckr
						id="slider"
						name="slider"
						:chunk-uploads="true"
						multiple
						@start-load="handleStartLoad"
						@end-load="handleEndLoad"
					/>
				</div>

				<div v-if="page.slider?.data">
					<Draggable
						v-model="page.slider.data"
						class="grid grid-cols-3 gap-2 mb-4"
						handle=".input-handle"
						item-key="id"
						@end="handleDragEnd"
					>
						<template #item="{ element, index }">
							<div class="relative input-handle cursor-move">
								<template
									v-if="
										['video/mp4', 'video/ogg', 'video/x-msvideo'].includes(element.type)
									"
								>
									<video controls width="360">
										<source :src="`${element.url}#t=0.1`" :type="element.mime_type" />
									</video>
								</template>
								<template v-else>
									<img :src="element.url" alt="" />
								</template>

								<button
									type="button"
									class="bg-red-700 absolute top-1 left-1 hover:bg-red-400 transition-colors"
									@click="handleDeleteImage(element.uuid)"
								>
									<IconTimes class="w-4 h-4 fill-white" />
								</button>
							</div>
						</template>
					</Draggable>
				</div>
			</fieldset>

			<div class="flex flex-row gap-2">
				<Button
					label="Annuler"
					severity="danger"
					size="small"
					@click.prevent="router.go(-1)"
				>
					<i class="pi pi-times mr-2" />Annuler
				</Button>
				<Button label="Sauvegarder" size="small" @click.prevent="handleSubmit">
					<i class="pi pi-check mr-2" />Sauvegarder
				</Button>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, onBeforeUnmount, ref } from "vue";

import InputText from "primevue/inputtext";
import Button from "primevue/button";
import ProgressSpinner from "primevue/progressspinner";
import Editor from "primevue/editor";
import Textarea from "primevue/textarea";
import FilePckr from "../../../components/file-pckr.vue";
import Select from "primevue/select";

import IconTimes from "../../../../../svg/backoffice/times.svg?component";

import Draggable from "vuedraggable";

import { useForm } from "laravel-precognition-vue";
import { useConfigsStore } from "../../../store/configs";
import { usePagesStore } from "../../../store/pages"
import { useFormsStore } from "../../../store/forms"
import { storeToRefs } from "pinia";
import { useRoute, useRouter } from "vue-router";
import { FormType } from "../../../types/form";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

const route = useRoute();
const router = useRouter();

const breadCrumbsFirstItem = computed(() => {
	return { label: "Pages", route: { name: "pages" } };
});

const breadCrumbsItems = computed(() => {
	let items: { label: string; to?: { name: string; params?: any } }[] = [];

	if (page?.value?.id) {
		items.push({ label: page?.value?.title || "N/A" });
	}

	items.push({ label: page?.value?.id ? "Modifier" : "Ajouter" });

	return items;
});

const pagesStore = usePagesStore();
const pagesRefs = storeToRefs(pagesStore);
const isFetchPending = pagesRefs.isFetchSinglePending;
const isSavePending = pagesRefs.isSavePending;
const page = ref(pagesRefs.single);

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const formsStore = useFormsStore();
const formsRefs = storeToRefs(formsStore);

const formOptions = ref<{ name: string; id: number }[]>([]);

const form = useForm(
	route.params.id ? "patch" : "post",
	route.params.id ? "/api/pages/" + route.params.id : "/api/pages",
	{
		title: { fr: "", en: "" },
		slug: { fr: "", en: "" },
		content: { fr: "", en: "" },
		method: null,
		template: null,
		seo_type: null,
		seo_title: { fr: "", en: "" },
		seo_description: { fr: "", en: "" },
		seo_image: null,
		form: <{ label: string; id: number } | null>null,
		slider: Array<string>,
	},
);

onBeforeMount(async () => {
	if (route.params.id) {
		await pagesStore.getItem({
			id: String(route.params.id),
			includes: ["slider", "form", "seo_image"],
		});
	} else {
		page.value = {
			translatable: {
				title: {
					fr: "",
					en: "",
				},
			},
		};
	}

	await formsStore.getItems();

	formOptions.value = formsRefs.list.value.map((form: FormType) => {
		return { name: form?.name[locale.value], id: form.id };
	});

	form.setData({
		...page?.value,
		title: page?.value?.translatable?.title?.fr
			? page?.value?.translatable?.title
			: { fr: "", en: "" },
		slug: page?.value?.translatable?.slug?.fr
			? page?.value?.translatable?.slug
			: { fr: "", en: "" },
		content: page?.value?.translatable?.content?.fr
			? page?.value?.translatable?.content
			: { fr: "", en: "" },
		seo_title: page?.value?.translatable?.seo_title?.fr
			? page?.value?.translatable?.seo_title
			: { fr: "", en: "" },
		seo_description: page?.value?.translatable?.seo_description?.fr
			? page?.value?.translatable?.seo_description
			: { fr: "", en: "" },
		form:
			formOptions.value?.find(
				(form) => Number(form.id) == Number(page?.value?.form_id),
			) || null,
	});
});

const handleSubmit = () => {
	pagesRefs.isSavePending.value = true;

	let untouchedData = form.data();

	form
		.setData({
			form: untouchedData?.form?.id || null,
		})
		.submit()
		.then(() => {
			if (route.params.form_id) {
				configsStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "La page a bien été modifiée",
				});
			} else {
				configsStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "La page a bien été créée",
				});
			}

			return router.push({ name: "pages" });
		})
		.catch((error) => {
			if (error.response.status === 422) {
				configsStore.addToast({
					severity: "warn",
					summary: "Attention",
					detail: "Il y a des erreurs dans le formulaire",
				});
			}
			if (error.response.status === 500) {
				configsStore.addToast({
					severity: "error",
					summary: "Attention",
					detail: "Il y a une erreur serveur",
				});
			}

			form.setData({ ...untouchedData });
		})
		.finally(() => {
			pagesRefs.isSavePending.value = false;
		});
};

onBeforeUnmount(() => {
	pagesRefs.single.value = null;
});

const isFilepondPending = ref(false);

const handleStartLoad = ({ files, id }: { files: []; id: number }) => {
	form.setData({
		[id]: files.map((file: { serverId: string }) => file.serverId),
	});
	isFilepondPending.value = true;
};

const handleEndLoad = ({ files, id }: { files: []; id: number }) => {
	form.setData({
		[id]: files.map((file: { serverId: string }) => file.serverId),
	});
	isFilepondPending.value = false;
};

const handleDragEnd = () => {
	pagesStore.moveSlider(form?.slider?.data);
};

const handleDeleteImage = (uuid: string) => {
	pagesStore.deleteSlider(uuid);
};
</script>
