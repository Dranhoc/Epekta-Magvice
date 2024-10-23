<template>
	<div>
		<IconField :pt-options="{ position: 'left' }">
			<InputIcon class="pi pi-search" />
			<InputText
				placeholder="Recherche"
				@update:model-value="handleGlobalFilterChangeDebounced"
			/>
		</IconField>
	</div>
</template>
<script setup lang="ts">
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import useDebounce from "../../../composables/debounce";

console.log(IconField);

const emits = defineEmits(["search"]);

const handleGlobalFilterChangeDebounced = useDebounce((event: any) => {
	emits("search", event);
}, 1000);
</script>
