<template>
    <Breadcrumbs
        :breadCrumbsFirstItem="breadCrumbsFirstItem"
        :breadCrumbsItems="breadCrumbsItems"
    />

    <div class="mx-10">
        <div class="flex mb-20 justify-between">
            <div class="flex">
                <h1 class="mr-2 text-5xl uppercase font-title font-bold">
                    Articles
                </h1>

                <Button @click.prevent="handleCreateOrEditPost">+ Écrire un article</Button>
            </div>

            <Search @search="handleGlobalSearch" />
        </div>

        <DataTable
            :value="posts"
            :loading="isFetchListPending ||isDeletePending"
            :rows="pagination?.per_page"
            :rowsPerPageOptions="[5, 10, 15, 20]"
            :totalRecords="pagination?.total"
            @page="handlePageChange($event)"
            @sort="handleSortChange($event)"
            lazy paginator showGridlines stripedRows removableSort
            currentPageReportTemplate="{currentPage}/{totalPages}"
            paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
            :pt="{
                header: {class: 'text-surface-600 font-bold text-sm'},
                mask: 'absolute z-50 flex items-center justify-center w-full h-full bg-black/50',
                loadingIcon: 'text-primary-200 animate-spin h-20 w-20'
            }"
        >
            <template #empty> Aucun articles pour l'instant </template>

            <Column header="Titre" #body="slotProps">
                {{ slotProps?.data?.translatable?.title[locale] }}
            </Column>

            <Column header="Résumé" #body="slotProps">
                <div v-html="slotProps?.data?.translatable?.abstract[locale]"></div>
            </Column>

            <Column header="Action(s)" class="w-1/4" #body="slotProps">
                <div class="flex items-center gap-2">
                    <Button
                        label="Modifier"
                        @click.prevent="handleCreateOrEditPost(slotProps.data)"
                        size="small"
                        v-tooltip.top="{value: 'Éditer', class: 'tooltip-normal'}">
                        <i class="pi pi-pencil"></i>
                    </Button>
                    <Button
                        label="Supprimer"
                        @click.prevent="handleDeletePost(slotProps.data)"
                        severity="danger"
                        size="small"
                        v-tooltip.top="{value: 'Supprimer', class: 'tooltip-normal'}">
                        <i class="pi pi-trash"></i>
                    </Button>
                </div>
            </Column>
        </DataTable>
    </div>
</template>

<script setup lang="ts">
import {computed, onBeforeMount, ref} from "vue";

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";

import {useRouter} from "vue-router";
import {useConfirm} from "primevue/useconfirm";

import {storeToRefs} from "pinia";
import { useConfigsStore } from "@/backoffice/store/configs";
import { usePostsStore } from "@/backoffice/store/posts";

import {PostType} from "../../../types/post";
import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";
import Search from "../../../components/partials/backoffice/search.vue";

import useDatatableActions from "../../../composables/datatable-actions"

const router = useRouter();
const confirm = useConfirm()

const postsStore = usePostsStore();
const { pagination, isFetchListPending, list:posts, single:post, isDeletePending } = storeToRefs(postsStore)

const configsStore = useConfigsStore();
const { locale } = storeToRefs(configsStore);

const breadCrumbsFirstItem = computed( () => { return { label: 'Accueil' , route: '/admin' } });
const breadCrumbsItems = computed(() => [{label: 'Articles'}]);

const queryParams = ref({
    search: {
        search: null,
    },
    includes: [],
    sort_by: null,
    desc: false,
})

const { handlePageChange, handleSortChange, handleGlobalSearch } = useDatatableActions(pagination, queryParams, postsStore.getItems)

onBeforeMount(() => {
    postsStore.getItems();
})

const handleDeletePost = (post:PostType) => {
    confirm.require({
        message: 'Êtes vous sur de vouloir supprimer ?',
        header: 'Confirmation',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Supprimer',
        rejectLabel: 'Annuler',
        acceptClass: 'p-button-danger',
        accept: () => postsStore.deleteItem(post.id).then( () => console.warn(posts))
    })
}

const handleCreateOrEditPost = (editedPost:PostType) => {
    post.value = null
    router.push({name: 'post-save',  params: (editedPost ? {id: editedPost.id} : {}) });
}
</script>
