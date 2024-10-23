<template>
	<form
		method="POST"
		class="w-full flex items-center justify-center h-screen"
		@submit.prevent="handleResetPassword"
	>
		<fieldset class="w-[450px]">
			<div class="flex items-center justify-center">
				<IconLogo class="w-3/5 mb-12" />
			</div>
			<h1 class="mb-24 text-3xl text-center text-slate-500">
				Réinitialiser le mot de passe
			</h1>

			<div class="flex flex-col gap-2 mb-6">
				<label for="email">Email</label>
				<InputText
					id="email"
					v-model="email"
					type="email"
					name="email"
					placeholder="info@mail.eu"
					:class="errors.email && errors.email.length > 0 ? 'p-invalid' : ''"
				/>
				<small
					v-if="errors.email && errors.email.length > 0"
					id="text-error"
					class="text-red-500"
				>
					{{ errors.email.join(", ") || "&nbsp;" }}
				</small>
			</div>

			<div class="flex flex-col gap-2 mb-6">
				<label for="email">Mot de passe</label>
				<InputText
					id="password"
					v-model="password"
					type="password"
					name="password"
					placeholder="********"
					:class="errors.password && errors.password.length > 0 ? 'p-invalid' : ''"
				/>
				<small
					v-if="errors.password && errors.password.length > 0"
					id="text-error"
					class="text-red-500"
				>
					{{ errors.password.join(", ") || "&nbsp;" }}
				</small>
			</div>

			<div class="flex flex-col gap-2 mb-6">
				<label for="email">Confirmation du mot de passe</label>
				<InputText
					id="password_confirmation"
					v-model="password_confirmation"
					type="password"
					name="password_confirmation"
					placeholder="********"
					:class="
						errors.password_confirmation && errors.password_confirmation.length > 0
							? 'p-invalid'
							: ''
					"
				/>
				<small
					v-if="
						errors.password_confirmation && errors.password_confirmation.length > 0
					"
					id="text-error"
					class="text-red-500"
				>
					{{ errors.password_confirmation.join(", ") || "&nbsp;" }}
				</small>
			</div>

			<div class="mb-4">
				<Button
					type="submit"
					label="Réinitialiser"
					:loading="isResetPasswordPending"
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
const email = ref(route.query.email);
const password = ref("");
const password_confirmation = ref("");

const authStore = useAuthStore();
const authRefs = storeToRefs(authStore);

let isResetPasswordPending = authRefs.isResetPasswordPending;
let errors = authRefs.errors;

const handleResetPassword = () => {
	authStore.resetPassword(
		email.value,
		route.query.token,
		password.value,
		password_confirmation.value,
	);
};
</script>
