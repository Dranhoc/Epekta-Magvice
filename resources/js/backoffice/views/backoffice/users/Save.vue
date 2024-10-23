<template>
	<Breadcrumb
		:home="breadCrumbsFirstItem"
		:model="breadCrumbsItems"
		class="mb-6"
		:pt="{
			root: { class: 'bg-primary-200 py-5 px-10' },
			list: { class: 'flex' },
		}"
	>
		<template #item="{ item, props }">
			<router-link
				v-if="item.route"
				v-slot="{ href, navigate }"
				:to="item.route"
				custom
			>
				<a :href="href" v-bind="props.action" @click="navigate">
					<span :class="[item.icon, 'text-color']" />
					<span class="text-black font-bold">{{ item.label }}</span>
				</a>
			</router-link>
			<a v-else :href="item.url" :target="item.target" v-bind="props.action">
				<span class="text-color">{{ item.label }}</span>
			</a>
		</template>
	</Breadcrumb>

	<div
		v-if="isFetchPending"
		class="h-[85.5vh] w-full flex items-center justify-center bg-black/75"
	>
		<ProgressSpinner />
	</div>

	<div v-else class="mx-10 mb-10 py-10">
		<div class="flex mb-20 justify-between">
			<div class="flex">
				<h1 class="mr-6 text-5xl uppercase font-title">
					{{ user?.id ? "Modifier un utilisateur" : "Ajouter un utilisateur" }}
				</h1>
			</div>
		</div>

		<div class="flex flex-col gap-4">
			<div class="flex flex-col gap-2">
				<label for="name" class="text-dark-slate-600 uppercase tracking-widest"
					>Nom*</label
				>
				<InputText
					id="name"
					v-model="form.name"
					type="text"
					name="name"
					required
					:invalid="form.invalid('name')"
					@change="form.validate('name')"
				/>
				<small v-if="form.invalid('name')" class="text-red-500">
					{{ form.errors.name }}
				</small>
			</div>

			<div class="flex flex-col gap-2">
				<label for="email" class="text-dark-slate-600 uppercase tracking-widest"
					>Email*</label
				>
				<InputText
					id="email"
					v-model="form.email"
					type="email"
					name="email"
					required
					:invalid="form.invalid('email')"
					@change="form.validate('email')"
				/>
				<small v-if="form.invalid('email')" class="text-red-500">
					{{ form.errors.email }}
				</small>
			</div>

			<div class="flex-1 flex flex-col gap-2">
				<label for="role" class="text-dark-slate-600 uppercase tracking-wider"
					>Rôle*</label
				>
				<Select
					v-model="form.role"
					:options="roleOptions"
					option-label="name"
					placeholder="Choisissez un rôle"
					required
					:class="form.invalid('role') ? 'p-invalid' : ''"
					@change="form.validate('role')"
				/>
				<small v-if="form.invalid('role')" class="text-red-500">
					{{ form.errors.role }}
				</small>
			</div>

			<div class="flex-1 flex flex-col gap-2">
				<label for="password" class="text-dark-slate-600 uppercase tracking-wider"
					>Mot de passe</label
				>
				<InputText
					id="password"
					v-model="form.password"
					type="password"
					name="password"
					:class="form.invalid('password') ? 'p-invalid' : ''"
					@change="form.validate('password')"
				/>
				<small v-if="form.invalid('password')" class="text-red-500">
					{{ form.errors.password }}
				</small>
			</div>

			<div class="flex-1 flex flex-col gap-2">
				<label
					for="password_confirmation"
					class="text-dark-slate-600 uppercase tracking-wider"
					>Confirmer le mot de passe</label
				>
				<InputText
					id="password_confirmation"
					v-model="form.password_confirmation"
					type="password"
					name="password_confirmation"
					:class="form.invalid('password_confirmation') ? 'p-invalid' : ''"
					@change="form.validate('password_confirmation')"
				/>
				<small v-if="form.invalid('password_confirmation')" class="text-red-500">
					{{ form.errors.password_confirmation }}
				</small>
			</div>

			<div>
				<Button @click="handleSubmit">
					{{ user?.id ? "Modifier" : "Ajouter" }}
				</Button>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, ref } from "vue";

import InputText from "primevue/inputtext";
import Breadcrumb from "primevue/breadcrumb";
import Button from "primevue/button";
import ProgressSpinner from "primevue/progressspinner";
import Select from "primevue/select";

import { useRoute, useRouter } from "vue-router";
import { useForm } from "laravel-precognition-vue";

import { storeToRefs } from "pinia";
import { useConfigsStore } from "../../../store/configs";
import { useUsersStore } from "../../../store/users"

import USER_ROLES from "../../../enums/user-role";

const route = useRoute();
const router = useRouter();

const breadCrumbsFirstItem = computed(() => {
	return { label: "Utilisateurs", route: { name: "users" } };
});

const breadCrumbsItems = computed(() => {
	let items: { label: string; to?: { name: string; params?: any } }[] = [];

	if (user?.value?.id) {
		items.push({ label: user?.value?.name || "N/A" });
	}

	items.push({ label: user?.value?.id ? "Modifier" : "Ajouter" });

	return items;
});

const configsStore = useConfigsStore();

const usersStore = useUsersStore();
const usersRefs = storeToRefs(usersStore);
const user = usersRefs.single;
const isFetchPending = usersRefs.isFetchSinglePending;

const authStore = useAuthStore();

onBeforeMount(async () => {
	if (route.params.id) {
		await usersStore.getItem({ id: String(route.params.id) });
	} else {
		user.value = {
			name: null,
			email: null,
			role: null,
			password: null,
			password_confirmation: null,
		};
	}

	form.setData({
		...user?.value,
		role: roleOptions.value.find(
			(role) => Number(role.id) === Number(user.value.role),
		),
	});
});

const form = useForm(
	route.params.id ? "patch" : "post",
	route.params.id ? "/api/users/" + route.params.id : "/api/users",
	{
		name: null,
		email: null,
		role: <{ id: string; name: string } | null>null,
		password: null,
		password_confirmation: null,
	},
);

const roles = ref(USER_ROLES);

const roleOptions = ref(
    Object.entries(roles.value.labels).map((role) => {
        if(authStore.isRoot() || Number(role[0]) !== 1) {
            return { id: role[0], name: role[1] };
        }
    }),
);

const handleSubmit = () => {
	usersRefs.isSavePending.value = true;

	let untouchedData = form.data();

	form
		.setData({
			role: untouchedData?.role?.id,
		})
		.submit()
		.then(() => {
			if (route.params.id) {
				configsStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "L'utilisateur a bien été modifié",
				});
			} else {
				configsStore.addToast({
					severity: "success",
					summary: "Bravo",
					detail: "L'utilisateur a bien été créé",
				});
			}

			return router.push({ name: "users" });
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
			usersRefs.isSavePending.value = false;
		});
};
</script>
