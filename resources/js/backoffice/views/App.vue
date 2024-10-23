<template>
    <Toast />
    <DynamicDialog />
    <ConfirmDialog />

    <template v-if="isBackoffice">
        <div class="app-wrapper">
            <transition name="slide">
                <AppMenu v-if="isMenuOpen" @on-close-menu="handleCloseMenu" />
            </transition>

            <main class="main">
                <header v-if="route.name !== 'login'" class="header flex items-center justify-end">
                    <div class="px-2 flex items-center menu-opener">
                        <IconEpekta class="mr-4" />
                        <IconBurger class="cursor-pointer" @click.prevent="handleOpenMenu" />
                    </div>
                    <ul v-if="langs.length > 1" class="flex gap-2">
                        <li v-for="lang in langs" :key="lang">
                            <Button
                                class="font-bold border-0 uppercase px-1 rounded-md w-10 h-10 hover:bg-surface-300 hover:text-white transition-colors"
                                :class="lang === locale ? '' : 'bg-surface-400 text-white'"
                                @click.prevent="handleSwitchLang(lang)"
                            >
                                {{ lang }}
                            </Button>
                        </li>
                    </ul>
                    <div class="flex items-center p-10">
                        <!--                        <Avatar image="./../../img/default-user.png" class="mr-4 border-white border-2" size="large" shape="circle" />-->
                        <div class="text-white flex flex-row items-center justify-between">
                            <p>
                                <i class="mr-2 pi pi-shield text-yellow-200" />
                                {{ authUser?.firstname }} {{ authUser?.lastname }}
                            </p>
                            <p
                                class="flex items-center font-bold text-[14px] cursor-pointer text-black"
                                @click="handleOpenUserMenu"
                            >
                                Connecté
                                <i class="ml-2 pi pi-angle-down" />
                                <Menu id="overlay_menu" ref="menu" :model="items" :popup="true" />
                            </p>
                        </div>
                    </div>
                </header>
                <section>
                    <RouterView />
                </section>
            </main>

            <transition name="fade">
                <div
                    v-if="isMenuOpen"
                    class="menu-backdrop"
                    @click.prevent="handleCloseMenu"
                />
            </transition>
        </div>
    </template>
    <template v-else-if="isAnonymousHandlingAuth">
        <main>
            <section>
                <RouterView />
            </section>
        </main>
    </template>
</template>

<script setup lang="ts">
import Menu from "primevue/menu";
import Toast from "primevue/toast";
import DynamicDialog from "primevue/dynamicdialog";
import ConfirmDialog from "primevue/confirmdialog";
import Button from "primevue/button";

import AppMenu from "../components/partials/backoffice/menu.vue";

import IconBurger from "@icons/backoffice/burger.svg";
import IconEpekta from "@icons/backoffice/epekta.svg";

import { useRoute } from "vue-router";

import { onBeforeMount, onBeforeUnmount, ref } from "vue";
import { useAuthStore } from "../store/auth";
import { useConfigsStore } from "../store/configs"
import { storeToRefs } from "pinia";

const route = useRoute();

const authStore = useAuthStore();
const authRefs = storeToRefs(authStore);

const configStore = useConfigsStore();
const { locale, langs } = storeToRefs(configStore);

let isMenuOpen = ref(true);

const menu = ref();

const items = ref([
    {
        label: "Déconnexion",
        icon: "pi pi-sign-out",
        command: () => {
            authStore.logout();
        },
    },
]);

const handleOpenUserMenu = (event: Event) => {
    menu.value.toggle(event);
};

onBeforeMount(() => {
    if (window.innerWidth < 900) {
        isMenuOpen.value = false;
    }

    window.addEventListener("resize", () => {
        isMenuOpen.value = window.innerWidth >= 900;
    });

    configStore.getServerConfig();
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", () => {});
});

const handleOpenMenu = () => {
    console.warn("open menu");
    isMenuOpen.value = true;
};

const handleCloseMenu = () => {
    isMenuOpen.value = false;
};

const authUser = authRefs.authUser;

const isBackoffice = ref(
    route.path.startsWith("/admin") &&
    route.name !== "login" &&
    route.name !== "forgot-password" &&
    route.name !== "reset-password",
);
const isAnonymousHandlingAuth = ref(
    ["login", "forgot-password", "reset-password"].includes(route.name),
);

const handleSwitchLang = (lang: string) => {
    locale.value = lang;
};
</script>

<style>
.slide-enter-active {
    animation: slide-in 0.5s;
}
.slide-leave-active {
    animation: slide-in 0.5s reverse;
}
@keyframes slide-in {
    0% {
        transform: translateX(-300px);
    }
    100% {
        transform: translateX(0px);
    }
}

.fade-enter-active {
    animation: fade-in 0.5s;
}
.fade-leave-active {
    animation: fade-in 0.5s reverse;
}
@keyframes fade-in {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 0.5;
    }
}
</style>
