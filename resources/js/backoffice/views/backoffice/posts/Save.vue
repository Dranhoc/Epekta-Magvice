<template>
    <Breadcrumbs
        :breadCrumbsFirstItem="breadCrumbsFirstItem"
        :breadCrumbsItems="breadCrumbsItems"
    />

    <div v-if="isFetchSinglePending || isSavePending" class="h-[85.5vh] w-full flex items-center justify-center bg-black/75">
        <ProgressSpinner />
    </div>

    <div v-else class="mx-10 mb-10 py-10">
        <div class="flex mb-20 justify-between">
            <div class="flex">
                <h1 class="mr-2 text-5xl uppercase font-title font-bold">
                    {{ post?.id ? 'Modifier un article' : 'Ajouter un article' }}
                </h1>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <label for="title" class="text-dark-slate-600 uppercase tracking-widest">Titre*</label>
                <InputText
                    id="title"
                    name="title"
                    required
                    v-model="form.title[locale]"
                    :invalid="form.invalid('title')"
                    @change="form.validate('title')"
                />
                <small v-if="form.invalid('title')" class="text-red-500"> {{ form.errors.title }} </small>
            </div>

            <div class="flex-1 flex flex-col gap-2">
                <label for="abstract" class="text-dark-slate-600 uppercase tracking-widest">Résumé</label>
                <AdvancedEditor
                    id="abstract"
                    name="abstract"
                    v-model="form.abstract[locale]"
                    :isInvalid="form.invalid('abstract')"
                />
                <small v-if="form.invalid('abstract')" class="p-error" id="text-error">
                    {{ form.errors.abstract }}
                </small>
            </div>

            <div class="flex-1 flex flex-col gap-2">
                <label for="body" class="text-dark-slate-600 uppercase tracking-widest">Contenu</label>
                <AdvancedEditor
                    id="body"
                    name="body"
                    v-model="form.body[locale]"
                    :isInvalid="form.invalid('body')"
                />
                <small v-if="form.invalid('body')" class="p-error" id="text-error">
                    {{ form.errors.body }}
                </small>
            </div>

            <div class="flex-1 flex flex-col gap-2">
                <label for="illustration" class="text-dark-slate-600 uppercase tracking-wider">Illustration</label>
                <FilePckr
                    id="illustration"
                    name="illustration"
                    v-model="form.illustration"
                    :invalid="form.invalid('illustration')"
                    @change="form.validate('illustration')"
                    :current-url="post?.illustration?.url"
                    @startLoad="handleStartLoad"
                    @endLoad="handleEndLoad"
                />
                <small v-if="form.invalid('illustration')" class="text-red-500"> {{ form.errors.name }} </small>
            </div>

            <div>
                <Button @click="handleSubmit" :disabled="isFilepondPending">{{ post?.id ? 'Modifier' : 'Ajouter' }}</Button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import {computed, onBeforeMount, ref} from "vue";

    import InputText from "primevue/inputtext";
    import Button from "primevue/button";
    import ProgressSpinner from "primevue/progressspinner";

    import { useRoute, useRouter } from "vue-router";
    import { useForm } from "laravel-precognition-vue";

    import { storeToRefs } from "pinia";
    import { useConfigsStore } from "@/backoffice/store/configs";
    import { usePostsStore } from "@/backoffice/store/posts";

    import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";
    import FilePckr from "../../../components/file-pckr.vue";

    import AdvancedEditor from "@/backoffice/components/advanced-editor.vue";

    const route = useRoute();
    const router = useRouter();

    const breadCrumbsFirstItem = computed( () => {
        return { label: 'Articles' , route: {name: 'posts'} }
    })

    const breadCrumbsItems = computed(() => {
        let items: {label: string, to?: {name: string, params?: any}} [] = [];

        if(post?.value?.id) {
            items.push({label: post?.value?.translatable?.title[locale.value] || 'N/A'})
        }

        items.push({label: post?.value?.id ? 'Modifier' : 'Ajouter'})

        return items;
    });

    const postsStore = usePostsStore();
    const { isFetchSinglePending, single:post, isSavePending } = storeToRefs(postsStore)

    onBeforeMount(async () => {
        if (route.params.id) {
            await postsStore.getItem({id: String(route.params.id), includes: ['illustration']})
        } else {
            post.value = {
                translatable: {
                    title: {
                        'fr': null,
                        'en': null
                    },
                    abstract: {
                        'fr': 'Lorem ipsum dolor sit amet',
                        'en': null
                    },
                    body: {
                        'fr': null,
                        'en': null
                    },
                },
                illustration: null
            }
        }

        form.setData({
            ...post?.value,
            title: post?.value?.translatable?.title?.fr ? post?.value?.translatable?.title : {fr: '', en: ''},
            abstract: post?.value?.translatable?.abstract?.fr ? post?.value?.translatable?.abstract : {fr: '', en: ''},
            body: post?.value?.translatable?.body?.fr ? post?.value?.translatable?.body : {fr: '', en: ''},
            illustration: null
        })
    })

    const form = useForm(
        route.params.id ? 'patch' : 'post',
        route.params.id
            ? '/api/posts/' + route.params.id
            : '/api/posts',
        {
            title: {
                'fr': null,
                'en': null
            },
            abstract: {
                'fr': null,
                'en': null
            },
            body: {
                'fr': null,
                'en': null
            },
            illustration: null,
        }
    );

    const configsStore = useConfigsStore();
    const { locale } = storeToRefs(configsStore);

    const handleSubmit = () => {
        isSavePending.value = true;

        let untouchedData = form.data();

        form
            .submit()
            .then( () => {
                if (route.params.id) {
                    configsStore.addToast({severity: 'success', summary: 'Bravo', detail: 'L\'article a bien été modifié'})
                } else {
                    configsStore.addToast({severity: 'success', summary: 'Bravo', detail: 'L\'article a bien été créé'})
                }

                return router.push({name: 'posts'});
            })
            .catch(error => {
                if (error.response.status === 422) {
                    configsStore.addToast({severity: 'warn', summary: 'Attention', detail: 'Il y a des erreurs dans le formulaire'})
                }
                if (error.response.status === 500) {
                    configsStore.addToast({severity: 'error', summary: 'Attention', detail: 'Il y a une erreur serveur'})
                }

                form.setData({...untouchedData});
            })
            .finally( () => {
                isSavePending.value = false;
            })
    }

    const isFilepondPending = ref(false);

    const handleStartLoad = ({files, id}: { files: [], id: number }) => {
        form.setData({[id]: files.map((file: { serverId: string }) => file.serverId)})
        isFilepondPending.value = true;
    }

    const handleEndLoad = ({files, id}: { files: [], id: number }) => {
        form.setData({[id]: files.map((file: { serverId: string }) => file.serverId)})
        isFilepondPending.value = false;
    }
</script>
