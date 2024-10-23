<template>
	<form
		method="POST"
		class="w-full flex items-center justify-center h-screen"
		@submit.prevent="handleLogin"
	>
		<fieldset class="w-[450px]">
			<div class="flex items-center justify-center mb-24">
				<IconLogo class="w-3/5" />
			</div>

			<div class="flex flex-col gap-2 mb-6">
				<label for="email">Email</label>
				<InputText
					id="email"
					v-model="credentials.email"
					type="email"
					name="email"
					placeholder="info@mail.eu"
					:class="errors.email && errors.email.length > 0 ? 'p-invalid' : ''"
				/>
				<small
					v-if="errors.email && errors.email.length > 0"
					id="text-error"
					class="text-red-600"
				>
					{{ errors.email.join(", ") || "&nbsp;" }}
				</small>
			</div>

			<div class="flex flex-col gap-2 mb-6">
				<label for="email">Mot de passe</label>
				<InputText
					id="password"
					v-model="credentials.password"
					type="password"
					name="password"
					placeholder="********"
					:class="errors.password && errors.password.length > 0 ? 'p-invalid' : ''"
				/>
				<small
					v-if="errors.password && errors.password.length > 0"
					id="text-error"
					class="text-red-600"
				>
					{{ errors.password.join(", ") || "&nbsp;" }}
				</small>
			</div>

			<div class="flex items-center mb-6">
				<Checkbox
					v-model="credentials.remember"
					input-id="remember"
					name="remember"
					value="true"
				/>
				<label for="remember" class="ml-2"> Rester connecté </label>
			</div>

			<div class="mb-4">
				<Button
					type="submit"
					label="Se connecter"
					:loading="isLoginPending"
					class="w-full"
				/>
			</div>

			<router-link
				class="mx-auto block text-center text-cyan-500 hover:opacity-75 transition-opacity"
				:to="{ name: 'forgot-password' }"
			>
				Mot de passe oublié ?
			</router-link>
		</fieldset>
	</form>
</template>

<script setup>
import { ref } from "vue";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import InputText from "primevue/inputtext";
import { useAuthStore } from "../../../store/auth";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import IconLogo from "../../../../../svg/backoffice/epekta.svg?component";

const route = useRoute();

let credentials = ref({ email: null, password: null, remember: false });

const authStore = useAuthStore();
const authRefs = storeToRefs(authStore);

let isLoginPending = authRefs.isLoginPending;
let errors = authRefs.errors;

const handleLogin = () => {
	authStore.login(credentials.value);
	isLoginPending.value = true;
};
</script>
