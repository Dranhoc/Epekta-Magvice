<template>
	<form
		method="POST"
		class="w-full flex items-center justify-center h-screen"
		@submit.prevent="handleSendResetLink"
	>
		<fieldset class="w-[450px]">
			<div class="flex items-center justify-center">
				<IconLogo class="w-3/5 mb-12" />
			</div>
			<h1 class="mb-24 text-3xl text-center text-slate-500">
				Demander un lien de réinitialisation
			</h1>

			<div class="flex flex-col gap-2 mb-6">
				<label for="email">Email</label>
				<InputText
					id="email"
					v-model="email"
					type="email"
					name="email"
					placeholder="info@mail.eu"
					:class="
						errors && errors?.email && errors?.email?.length > 0 ? 'p-invalid' : ''
					"
				/>
				<small
					v-if="errors?.email && errors?.email?.length > 0"
					id="text-error"
					class="text-red-500"
				>
					{{ errors.email.join(", ") || "&nbsp;" }}
				</small>
			</div>

			<div class="mb-4">
				<Button
					type="submit"
					label="Réinitialiser"
					:loading="isResetLinkPending"
					class="w-full"
				/>
			</div>
		</fieldset>
	</form>
</template>

<script setup>
import { ref } from "vue";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import { useAuthStore } from "../../../store/auth";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import IconLogo from "../../../../../svg/logo.svg?component";

const route = useRoute();
const email = ref();

const authStore = useAuthStore();
const authRefs = storeToRefs(authStore);

const errors = authRefs.errors;
const isResetLinkPending = authRefs.isResetLinkPending;

const handleSendResetLink = () => {
	authStore.sendResetLink(email.value);
};
</script>
