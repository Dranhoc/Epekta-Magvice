<template>
	<nav class="menu">
		<div class="flex items-center justify-center py-2 h-[74px] border-b">
			<h1 class="hidden">Armarius - Administration</h1>
			<IconLogo class="mr-4" />
			<IconBurger class="menu-closer" @click.prevent="handleCloseMenu" />
		</div>
		<!--TODO: menu filtering-->

		<template v-if="authStore.isAdmin()">
			<h2 class="menu-subtitle">CMS</h2>

			<router-link :to="{ name: 'categories' }" class="menu-link"> Catégories </router-link>
			<router-link :to="{ name: 'pages' }" class="menu-link"> Pages </router-link>
			<router-link :to="{ name: 'forms' }" class="menu-link"> Formulaires </router-link>
			<router-link :to="{ name: 'contents' }" class="menu-link"> Contenus </router-link>
			<router-link :to="{ name: 'users' }" class="menu-link"> Utilisateurs </router-link>
			<router-link :to="{ name: 'settings' }" class="menu-link"> Paramètres </router-link>
            <router-link :to="{name: 'posts'}" class="menu-link"> Articles </router-link>
		</template>

		<h2 class="menu-subtitle">CRUDs</h2>

		<div class="flex items-center justify-center py-8 mx-6">
			<a
				href="/"
				target="_blank"
				class="flex flex-row items-center justify-center gap-2 text-white hover:opacity-75 transition-opacity"
			>
				<IconLaptop class="fill-white w-1/3" />
				<span><strong class="text-bold">Accès à la</strong> Plateforme</span>
			</a>
		</div>
	</nav>
</template>

<script setup lang="ts">
    import IconBurger from "@icons/backoffice/burger.svg";
    import IconLogo from "@icons/backoffice/epekta.svg";
    import IconLaptop from "@icons/backoffice/laptop.svg";
    import { useAuthStore } from "@/backoffice/store/auth";

    const emit = defineEmits(["onCloseMenu"]);

    const authStore = useAuthStore();

    const handleCloseMenu = () => {
        emit("onCloseMenu");
    };
</script>
