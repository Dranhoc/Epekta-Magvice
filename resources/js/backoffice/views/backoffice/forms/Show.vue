<template>
  <Breadcrumbs
    :bread-crumbs-first-item="breadCrumbsFirstItem"
    :bread-crumbs-items="breadCrumbsItems"
  />

  <div
    v-if="isFetchPending || isSavePending"
    class="h-[85.5vh] w-full flex items-center justify-center bg-black/75"
  >
    <ProgressSpinner />
  </div>

  <div
    v-else
    class="mx-10 mb-10 py-10"
  >
    <div class="flex mb-20 justify-between">
      <div class="flex">
        <h1 class="mr-2 text-5xl uppercase font-title font-bold">
          {{ form?.id ? 'Modifier' : 'Ajouter' }}
        </h1>
      </div>
    </div>

    <div class="flex gap-8 flex-row items-start">
      <TabView class="flex-1">
        <TabPanel
          v-for="step in form.steps"
          :key="step.id"
        >
          <template #header>
            <div class="flex gap-2 items-center">
              <span class="capitalize w-3/4">{{ step.name[locale] }}</span>
              <Button
                severity="secondary"
                icon="pi pi-pencil"
                size="small"
                class="h-10"
                @click.prevent="handleEditStep(step)"
              />
              <Button
                severity="danger"
                icon="pi pi-trash"
                size="small"
                class="h-10"
                @click.prevent="handleDeleteStep(step)"
              />
              <Dialog
                v-model:visible="isStepEditOpen"
                modal
                header="Header"
                :style="{ width: '50rem' }"
                :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
              >
                <div class="flex-col flex gap-6 mb-6">
                  <div class="flex-1 flex flex-col gap-2">
                    <label
                      for="name"
                      class="text-dark-slate-600 uppercase tracking-widest"
                    >Nom</label>
                    <InputText
                      id="label"
                      v-model="stepForm.name[locale]"
                      type="label"
                      name="label"
                      :class="stepForm.invalid('name') ? 'p-invalid' : ''"
                      @change="stepForm.validate('name')"
                    />
                    <small
                      v-if="stepForm.invalid('name')"
                      id="text-error"
                      class="p-error"
                    >
                      {{ stepForm.errors.name }}
                    </small>
                  </div>
                </div>

                <div class="flex flex-row gap-2">
                  <Button
                    label="Sauvegarder"
                    severity="primary"
                    size="small"
                    @click.prevent="handleUpdateStep"
                  >
                    <i class="pi pi-check mr-2" />Sauvegarder
                  </Button>
                </div>
              </Dialog>
            </div>
          </template>
          <div
            v-for="(section, index) in step.sections"
            :key="index"
            class="mb-8"
          >
            <div class="flex gap-2 items-center mb-4">
              <span class="capitalize text-xl">{{ section.name[locale] }}</span>
              <Button
                severity="secondary"
                icon="pi pi-pencil"
                size="small"
                class="h-10"
                @click.prevent="handleEditSection(section)"
              />
              <Button
                severity="danger"
                icon="pi pi-trash"
                size="small"
                class="h-12"
                @click.prevent="handleDeleteSection(section)"
              />
              <Dialog
                v-model:visible="isSectionEditOpen"
                modal
                header="Header"
                :style="{ width: '50rem' }"
                :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
              >
                <div class="flex-col flex gap-6 mb-6">
                  <div class="flex-1 flex flex-col gap-2">
                    <label
                      for="name"
                      class="text-dark-slate-600 uppercase tracking-widest"
                    >Nom</label>
                    <InputText
                      id="name"
                      v-model="sectionForm.name[locale]"
                      type="text"
                      name="name"
                      :class="sectionForm.invalid('name') ? 'p-invalid' : ''"
                      @change="sectionForm.validate('name')"
                    />
                    <small
                      v-if="sectionForm.invalid('name')"
                      id="text-error"
                      class="p-error"
                    >
                      {{ sectionForm.errors.name }}
                    </small>
                  </div>
                </div>

                <div class="flex flex-row gap-2">
                  <Button
                    label="Sauvegarder"
                    severity="primary"
                    size="small"
                    @click.prevent="handleUpdateSection"
                  >
                    <i class="pi pi-check mr-2" />Sauvegarder
                  </Button>
                </div>
              </Dialog>
            </div>
            <Draggable
              v-model="section.fields"
              class="grid grid-cols-6 gap-6 items-start mb-6"
              handle=".input-handle"
              :group="'sections'"
              item-key="id"
              @end="handleDragEnd"
            >
              <template #item="{element}">
                <div
                  :key="'field-'+element.id"
                  class="flex gap-2 items-end"
                  :class="'col-span-' + element.column"
                >
                  <Field
                    :key="'field-'+key"
                    :field="element"
                    :form="form"
                    :step="step"
                    :section="section"
                    @update="handleUpdateField"
                  />
                </div>
              </template>
            </Draggable>
            <div class="py-5 flex items-center">
              <Button @click.prevent="handleAddField(section)">
                + Field
              </Button>
            </div>
          </div>
          <div class="py-5 flex items-center">
            <Button @click.prevent="handleAddSection(step)">
              + Section
            </Button>
          </div>
        </TabPanel>
      </TabView>
      <div class="p-5 flex items-center">
        <Button @click.prevent="handleAddStep(form)">
          + Étape
        </Button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
    import ProgressSpinner from "primevue/progressspinner";
    import TabView from "primevue/tabview";
    import TabPanel from "primevue/tabpanel";
    import Button from "primevue/button";
    import Field from "../../../components/formsBuilder/Field.vue";

    import {computed, onBeforeMount, ref} from "vue";
    import { useConfigsStore } from "../../../store/configs";
    import { useFieldsStore } from "../../../store/fields"
    import { useFormsStore } from "../../../store/forms"
    import { useSectionsStore } from "../../../store/sections";
    import { useStepsStore } from "../../../store/steps";
    import {storeToRefs} from "pinia";
    import {useRoute} from "vue-router";
    import {StepType} from "../../../types/step";
    import {SectionType} from "../../../types/section";
    import {FormType} from "../../../types/form";
    import InputText from "primevue/inputtext";
    import Dialog from "primevue/dialog";
    import {useForm} from "laravel-precognition-vue";
    import {useToast} from "primevue/usetoast";

    import Draggable from 'vuedraggable'
    import Breadcrumbs from "../../../components/partials/backoffice/breadcrumbs.vue";

    const breadCrumbsFirstItem = computed( () => {
        return { label: 'Formulaires' , route: {name: 'forms'} }
    })

    const breadCrumbsItems = computed(() => {
        let items: { label: string, to?: { name: string, params?: any } } [] = [];

        if (form?.value?.id) {
            items.push({label: form?.value?.name[locale.value] || 'N/A'})
        }

        items.push({label: form?.value?.id ? 'Étape(s)' : ''})

        return items;
    });

    const route = useRoute();
    const toast = useToast();

    onBeforeMount( async () => {
        await formsStore.getItem({id: String(route.params.id), includes: ['steps', 'steps.sections', 'steps.sections.fields', 'steps.sections.fields.options', 'steps.sections.fields.rules', 'steps.sections.fields.rules.option']})
    })

    const formsStore = useFormsStore();
    const formsRefs = storeToRefs(formsStore);
    const isFetchPending = formsRefs.isFetchSinglePending;
    const isSavePending = formsRefs.isSavePending;
    const form = ref(formsRefs.single);

    const stepsStore = useStepsStore();
    const stepsRefs = storeToRefs(stepsStore);

    const sectionsStore = useSectionsStore();
    const sectionsRefs = storeToRefs(sectionsStore);

    const configsStore = useConfigsStore();
    const configsRefs = storeToRefs(configsStore);

    const locale = configsRefs.locale;

    const isStepEditOpen = ref(false);
    const currentStep = stepsRefs.single;
    let stepForm:any;

    const handleAddStep = (form:FormType) => {
        formsStore.addStep(form.id);
    }

    const handleEditStep = (step:StepType) => {
        stepsStore.single = step;
        isStepEditOpen.value = true;

        stepForm = useForm(
            'patch',
            '/api/formSteps/' + step.id + '?include=sections,sections.fields,fields.options',
            {
                ...step
            }
        );
    }

    const handleUpdateStep = () => {
        stepsRefs.isSavePending.value = true;

        let untouchedData = stepForm.data();

        stepForm
            .submit()
            .then( (response:any) => {
                toast.add({severity: 'success', summary: 'Bravo', detail: 'L\'étape a bien été modifié', life: 8000});

                isStepEditOpen.value = false;

                const index = useFormsStore().single.steps.findIndex( (item: StepType) => item.id === currentStep.value.id );

                if (index !== -1) {
                    useFormsStore().single.steps[index] = response.data.data;
                }
            })
            .catch( (error:any) => {
                if(error.response.status === 422) {
                    toast.add({'severity': 'warn', 'summary': 'Attention', 'detail': 'Il y a des erreurs dans le formulaire', life: 8000})
                }
                if(error.response.status === 500) {
                    toast.add({'severity': 'error', 'summary': 'Attention', 'detail': 'Il y a une erreur serveur', life: 8000})
                }
                stepForm.setData({...untouchedData});
            })
            .finally( () => {
                stepsRefs.isSavePending.value = false;
            })
    }

    const handleDeleteStep = (step:StepType) => {
        stepsStore.deleteItem(step.id).then( () => {
            const index = form.value.steps.findIndex( (item: any) => item.id === step.id );

            if (index !== -1) {
                form.value.steps.splice(index, 1);
            }
        })
    }

    const isSectionEditOpen = ref(false);
    const currentSection = sectionsRefs.single;
    let sectionForm:any;

    const handleAddSection = (step:StepType) => {
        stepsStore.addSection(step.id)
    }

    const handleEditSection = (section:SectionType) => {
        sectionsStore.single = section;
        isSectionEditOpen.value = true;

        sectionForm = useForm(
            'patch',
            '/api/formSections/' + section.id + '?include=fields,fields.options',
            {
                ...section
            }
        );
    }

    const handleUpdateSection = () => {
        sectionsRefs.isSavePending.value = true;

        let untouchedData = sectionForm.data();

        sectionForm
            .submit()
            .then( (response:any) => {
                toast.add({severity: 'success', summary: 'Bravo', detail: 'La section a bien été modifié', life: 8000});

                isSectionEditOpen.value = false;

                const index = useFormsStore().single.steps
                    .find( (step:StepType) => step.id === currentSection.value.form_step_id )
                    .sections
                    .findIndex( (item: any) => item.id === currentSection.value.id );

                if (index !== -1) {
                    useFormsStore().single.steps
                        .find( (step:StepType) => step.id === currentSection.value.form_step_id )
                        .sections[index] = response.data.data;
                }
            })
            .catch( (error:any) => {
                if(error.response.status === 422) {
                    toast.add({'severity': 'warn', 'summary': 'Attention', 'detail': 'Il y a des erreurs dans le formulaire', life: 8000})
                }
                if(error.response.status === 500) {
                    toast.add({'severity': 'error', 'summary': 'Attention', 'detail': 'Il y a une erreur serveur', life: 8000})
                }
                sectionForm.setData({...untouchedData});
            })
            .finally( () => {
                sectionsRefs.isSavePending.value = false;
            })
    }

    const handleDeleteSection = (section:SectionType) => {
        sectionsStore.deleteItem(section.id).then( () => {
            const index = form.value.steps.find( (step:StepType) => step.id === section.form_step_id).sections.findIndex( (item: any) => item.id === section.id );

            if (index !== -1) {
                form.value.steps.find( (step:StepType) => step.id === section.form_step_id).sections.splice(index, 1);
            }
        })
    }

    const handleAddField = (section:SectionType) => {
        sectionsStore.addField(section);
    }

    const key = ref(0);

    const handleUpdateField = () => {
        key.value++
    }

    const fieldsStore = useFieldsStore();

    const handleDragEnd = () => {
        form.value.steps.forEach( (step:StepType) => {
            step.sections.forEach( (section:SectionType) => {
                sectionsStore.syncFields(section);
                fieldsStore.sortList(section.fields);
            })
        })
    }
</script>
