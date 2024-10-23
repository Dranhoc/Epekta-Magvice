<template>
	<div
		:class="{
			'sm:border-t sm:border-gray-200 sm:py-5': withBorder,
			'space-y-1 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-4': isInline,
			'h-48': currentUrl && !hasUpload,
		}"
	>
		<label
			v-if="label"
			:for="id"
			:class="{
				'block text-sm font-medium text-gray-900': true,
				'mb-2': !isInline,
				'sm:mt-px sm:pt-2': isInline,
			}"
		>
			{{ label }} {{ required ? "*" : "" }}
		</label>

		<div
			:class="isInline ? 'sm:col-span-2 relative' : 'w-full'"
			class="flex flex-col"
		>
			<template v-if="currentUrl && !hasUpload">
				<div class="cursor-pointer relative group h-48 overflow-hidden">
					<span
						class="group-hover:opacity-100 opacity-0 transition-all absolute text-5xl text-gray-300 uppercase flex items-center justify-center w-full h-full bg-black/50"
						@click.prevent="handleTriggerFilepond"
						>Cliquer pour modifier</span
					>
					<img :src="currentUrl" alt="" class="h-full w-full object-contain" />
				</div>
			</template>

			<div
				v-show="!currentUrl || hasUpload"
				:class="mode === 'avatar' ? 'w-48 m-auto' : 'w-full'"
			>
				<FilePond
					:id="id"
					ref="pond"
					:name="name"
					class-name="vue-filepond"
					:server="options.server"
					:allow-multiple="multiple && mode !== 'avatar'"
					:allow-file-type-validation="withValidation"
					:accepted-file-types="acceptedFileTypes"
					v-bind="options[mode]"
					:files="files"
					:chunk-uploads="chunkUploads"
					:chunk-size="1000000"
					@addfilestart="handleStartUpload"
					@processfiles="handleEndUpload"
					@removefile="handleRemoveFile"
				/>
			</div>

			<div v-if="tooltip" class="flex flex-col justify-between mt-2">
				<p v-if="tooltip" class="text-sm text-gray-500">
					{{ tooltip }}
				</p>
			</div>
		</div>
	</div>
</template>

<script lang="ts" setup>
import vueFilePond from "vue-filepond";

import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import { ref } from "vue";

const FilePond = vueFilePond(
	FilePondPluginFileValidateType,
	FilePondPluginImagePreview,
);

const props = defineProps({
    id: {
        type: String,
        default: null
    },
    name: {
        type: String,
        default: null
    },
    label: {
        type: String,
        default: null
    },
    labelIdle: {
        type: String,
        default: null
    },
    multiple: Boolean,
    withValidation: Boolean,
    acceptedFileTypes: {
        type: String,
        default: null
    },
    tooltip: {
        type: String,
        default: null
    },
    withBorder: Boolean,
    isInline: Boolean,
    required: Boolean,
    mode: {
        type: String,
        default: 'classic'
    },
    currentUrl: {
        type: String,
        default: null
    },
    chunkUploads: Boolean,
    modelValue: [String, Array, null],
})

const emit = defineEmits(["startLoad", "endLoad"]);

const pond = ref();

const files = ref([]);
const hasUpload = ref(false);

const options = {
	server: {
		url: "/api/filepond",
		headers: {
			"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').attributes.content.value,
		},
	},
	avatar: {
		labelIdle: "Drag & Drop your file",
		imagePreviewHeight: "170",
		imageCropAspectRatio: "1:1",
		imageResizeTargetWidth: "200",
		imageResizeTargetHeight: "200",
		stylePanelLayout: "compact circle",
		styleLoadIndicatorPosition: "center bottom",
		styleProgressIndicatorPosition: "right bottom",
		styleButtonRemoveItemPosition: "left bottom",
		styleButtonProcessItemPosition: "right bottom",
		imageResizeMode: "cover",
	},
	classic: {
		labelIdle:
			'Faites glisser vos fichiers ou <span class = "filepond--label-action"> Parcourir </span>',
		labelInvalidField: "Le champ contient des fichiers invalides",
		labelFileWaitingForSize: "En attente de taille",
		labelFileSizeNotAvailable: "Taille non disponible",
		labelFileLoading: "Chargement",
		labelFileLoadError: "Erreur durant le chargement",
		labelFileProcessing: "Traitement",
		labelFileProcessingComplete: "Traitement effectué",
		labelFileProcessingAborted: "Traitement interrompu",
		labelFileProcessingError: "Erreur durant le traitement",
		labelFileProcessingRevertError: "Erreur durant la restauration",
		labelFileRemoveError: "Erreur durant la suppression",
		labelTapToCancel: "appuyer pour annuler",
		labelTapToRetry: "appuyer pour réessayer",
		labelTapToUndo: "appuyer pour revenir en arrière",
		labelButtonRemoveItem: "Retirer",
		labelButtonAbortItemLoad: "Annuler",
		labelButtonRetryItemLoad: "Recommencer",
		labelButtonAbortItemProcessing: "Annuler",
		labelButtonUndoItemProcessing: "Revenir en arrière",
		labelButtonRetryItemProcessing: "Recommencer",
		labelButtonProcessItem: "Transférer",
		labelMaxFileSizeExceeded: "Le fichier est trop volumineux",
		labelMaxFileSize: "La taille maximale de fichier est {filesize}",
		labelMaxTotalFileSizeExceeded: "Taille totale maximale dépassée",
		labelMaxTotalFileSize:
			"La taille totale maximale des fichiers est {filesize}",
		labelFileTypeNotAllowed: "Fichier non valide",
		fileValidateTypeLabelExpectedTypes: "Attendu {allButLastType} ou {lastType}",
		imageValidateSizeLabelFormatError: "Type d'image non pris en charge",
		imageValidateSizeLabelImageSizeTooSmall: "L'image est trop petite",
		imageValidateSizeLabelImageSizeTooBig: "L'image est trop grande",
		imageValidateSizeLabelExpectedMinSize:
			"La taille minimale est {minWidth} × {minHeight}",
		imageValidateSizeLabelExpectedMaxSize:
			"La taille maximale est {maxWidth} × {maxHeight}",
		imageValidateSizeLabelImageResolutionTooLow: "La résolution est trop faible",
		imageValidateSizeLabelImageResolutionTooHigh: "La résolution est trop élevée",
		imageValidateSizeLabelExpectedMinResolution:
			"La résolution minimale est {minResolution}",
		imageValidateSizeLabelExpectedMaxResolution:
			"La résolution maximale est {maxResolution}",
	},
};

const handleStartUpload = () => {
	emit("startLoad", { files: pond.value.getFiles(), id: props.id });
	hasUpload.value = true;
};

const handleEndUpload = () => {
	emit("endLoad", { files: pond.value.getFiles(), id: props.id });
};

const handleRemoveFile = () => {
	emit("endLoad", { files: pond.value.getFiles(), id: props.id });
};

const handleTriggerFilepond = () => {
	// maybe we lost drag and drop file loading
	pond.value.browse();
};
</script>

<style lang="scss">
.vue-filepond {
	.filepond--drop-label {
		cursor: pointer;
		& > label {
			cursor: pointer;
		}
		&:hover {
			background-color: #eee;
		}
	}
}
.filepond--root {
	margin-bottom: 0;
}
</style>
