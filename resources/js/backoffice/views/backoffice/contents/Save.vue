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
					{{ content?.id ? "Modifier" : "Ajouter" }}
				</h1>
			</div>
		</div>

		<div class="flex-col flex gap-8 mb-6">
			<div class="flex-1 flex flex-col gap-2">
				<label for="type" class="text-dark-slate-600 uppercase">Type</label>
				<Select
					id="type"
					v-model="form.type"
					name="type"
					:options="typeOptions"
					option-label="name"
					placeholder="Choisissez un type"
					:class="form.invalid('type') ? 'p-invalid' : ''"
					@change="form.validate('type')"
				/>
				<small v-if="form.invalid('type')" id="text-error" class="p-error">
					{{ form.errors.type }}
				</small>
			</div>

			<div
				v-if="Number(form?.type?.id) === Number(CONTENT_TYPES.values.T.description)"
				class="flex-1 flex flex-col gap-2"
			>
				<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
					>Titre</label
				>
				<InputText
					id="title"
					v-model="form.title[locale]"
					type="text"
					name="title"
					label="Title"
					:class="form.invalid('title.' + locale) ? 'p-invalid' : ''"
					@change="form.validate('title')"
				/>
				<small
					v-if="form.invalid('title.' + locale)"
					id="text-error"
					class="p-error"
				>
					{{ form.errors["title." + locale] }}
				</small>
			</div>

			<div
				v-if="
					Number(form?.type?.id) === Number(CONTENT_TYPES.values.CONTENT.description)
				"
				class="flex-1 flex flex-col gap-2"
			>
				<label for="content" class="text-dark-slate-600 uppercase tracking-widest"
					>Contenu</label
				>
				<Editor
					id="content"
					ref="editorContentRef"
					v-model="form.content[locale]"
					name="content"
					:class="form.invalid('content.' + locale) ? 'p-invalid' : ''"
					@change="form.validate('content')"
				/>
				<small
					v-if="form.invalid('content.' + locale)"
					id="text-error"
					class="p-error"
				>
					{{ form.errors["content." + locale] }}
				</small>
			</div>

			<div
				v-if="
					Number(form?.type?.id) === Number(CONTENT_TYPES.values.IMAGE.description)
				"
				class="flex-1 flex flex-col gap-2"
			>
				<label for="image" class="text-dark-slate-600 uppercase tracking-wider"
					>Image</label
				>
				<FilePckr
					id="picture"
					v-model="form.picture"
					name="picture"
					:current-url="form?.picture?.url"
					:class="form.invalid('picture') ? 'p-invalid' : ''"
					@start-load="handleStartLoad"
					@end-load="handleEndLoad"
					@change="form.validate('picture')"
				/>
				<small v-if="form.invalid('picture')" id="text-error" class="p-error">
					{{ form.errors["picture"] }}
				</small>
			</div>
		</div>

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
</template>

<script setup lang="ts">
import { computed, onBeforeMount, onBeforeUnmount, ref, watch } from "vue";

import InputText from "primevue/inputtext";
import Select from "primevue/select";
import Button from "primevue/button";
import Editor from "primevue/editor";

import { useForm } from "laravel-precognition-vue";
import { useConfigsStore } from "../../../store/configs";
import { useContentsStore } from "../../../store/contents"
import { storeToRefs } from "pinia";
import { useToast } from "primevue/usetoast";
import { useRoute, useRouter } from "vue-router";

import ProgressSpinner from "primevue/progressspinner";
import FilePckr from "../../../components/file-pckr.vue";
import CONTENT_TYPES from "../../../enums/content-types";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

const toast = useToast();
const route = useRoute();
const router = useRouter();

const breadCrumbsFirstItem = computed(() => {
	return { label: "Contenus", route: { name: "contents" } };
});

const breadCrumbsItems = computed(() => {
	let items: { label: string; to?: { name: string; params?: any } }[] = [];

	if (content?.value?.id) {
		items.push({ label: content?.value?.title[locale.value] || "N/A" });
	}

	items.push({ label: content?.value?.id ? "Modifier" : "Ajouter" });

	return items;
});

const contentsStore = useContentsStore();
const contentsRefs = storeToRefs(contentsStore);
const isSavePending = contentsRefs.isSavePending;
const content = contentsRefs.single;
const isFetchPending = contentsRefs.isFetchSinglePending;

const configsStore = useConfigsStore();
const configsRefs = storeToRefs(configsStore);

const locale = configsRefs.locale;

const contentTypes = ref(CONTENT_TYPES);

const form = useForm(
	route.params.id ? "patch" : "post",
	route.params.id ? "/api/contents/" + route.params.id : "/api/contents",
	{
		title: { fr: "", en: "" },
		content: { fr: "", en: "" },
		picture_alt: { fr: "", en: "" },
		type: null,
		picture: null,
	},
);

const typeOptions = ref<{ name: string; id: number }[]>([]);

typeOptions.value = Object.entries(contentTypes.value.labels).map((content) => {
	return { id: content[0], name: content[1] };
});

onBeforeMount(async () => {
	if (route.params.id) {
		await contentsStore.getItem({
			id: String(route.params.id),
			includes: ["picture"],
		});
	} else {
		content.value = {
			name: null,
			title: { fr: "", en: "" },
			sur_title: { fr: "", en: "" },
			subtitle: { fr: "", en: "" },
			content: { fr: "", en: "" },
			picture_alt: { fr: "", en: "" },
			type: null,
			picture: null,
		};
	}

	form.setData({
		...content.value,
		type: typeOptions.value.find(
			(type) => Number(type.id) === Number(content.value.type),
		),
	});
});

const handleSubmit = () => {
	contentsRefs.isSavePending.value = true;

	let untouchedData = form.data();

	form
		.setData({
			type: untouchedData?.type?.id || null,
		})
		.submit()
		.then(() => {
			if (route.params.id) {
				toast.add({
					severity: "success",
					summary: "Bravo",
					detail: "Le content a bien été modifié",
					life: 8000,
				});
			} else {
				toast.add({
					severity: "success",
					summary: "Bravo",
					detail: "Le content a bien été créé",
					life: 8000,
				});
			}

			return router.push({ name: "contents" });
		})
		.catch((error) => {
			if (error.response.status === 422) {
				toast.add({
					severity: "warn",
					summary: "Attention",
					detail: "Il y a des erreurs dans le content",
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
			contentsRefs.isSavePending.value = false;
		});
};

onBeforeUnmount(() => {
	contentsRefs.single.value = null;
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

const editorContentRef = ref();

watch(editorContentRef, (editor) => {
	if (!editor) return;
	// Hack needed for Quill v2: https://github.com/primefaces/primevue/issues/5606#issuecomment-2093536386
	editor.renderValue = function renderValue(value) {
		if (this.quill) {
			if (value) {
				const delta = this.quill.clipboard.convert({ html: value });
				this.quill.setContents(delta, "silent");
			} else {
				this.quill.setText("");
			}
		}
	}.bind(editor); // Bind needed for production build
});
</script>
