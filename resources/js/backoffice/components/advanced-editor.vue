<template>
    <Editor
        :id="props.id"
        :name="props.name"
        ref="editor"
        :modules="{ htmlEditButton: {}}"
        content-type="html"
        toolbar="full"
        v-model="localValue"
        @update:modelValue="handleInput"
        :class="props.isInvalid ? 'p-invalid' : ''"
        @load="handleLoadQuill"
    >
        <template v-slot:toolbar>
            <span class="ql-formats">
                <select class="ql-header">
                    <option selected value="0">Paragraphe</option>
                    <option value="1">Titre 1</option>
                    <option value="2">Titre 2</option>
                    <option value="3">Titre 3</option>
                    <option value="4">Titre 4</option>
                    <option value="5">Titre 5</option>
                </select>
            </span>
            <span class="ql-formats">
                <select class="ql-font">
                    <option></option>
                    <option value="serif"></option>
                    <option value="monospace"></option>
                </select>
            </span>
            <span class="ql-formats">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
                <button class="ql-strike"></button>
            </span>
            <span class="ql-formats">
                <select class="ql-color"></select>
                <select class="ql-background"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-list" value="ordered"></button>
                <button class="ql-list" value="bullet"></button>
                 <select class="ql-align">
                    <option selected></option>
                    <option value="center"></option>
                    <option value="right"></option>
                    <option value="justify"></option>
                </select>
            </span>
            <span class="ql-formats">
                <button class="ql-link"></button>
                <button class="ql-image"></button>
                <button class="ql-code-block"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-clean"></button>
            </span>
        </template>
    </Editor>
</template>
<script setup lang="ts">
    import Editor from "primevue/editor";
    import {ref, watch} from "vue";
    import Button from "primevue/button";
    import Select from "primevue/select";

    const props = defineProps(['id', 'name', 'modelValue', 'isInvalid']);
    const emits = defineEmits(['update:modelValue']);

    const localValue = ref(props.modelValue);

    const handleInput = (event: any) => {
        emits('update:modelValue', localValue.value);
    };

    const editor = ref()

    watch(editor, (editor:any) => {
        if (!editor) return
        // Hack needed for Quill v2: https://github.com/primefaces/primevue/issues/5606#issuecomment-2093536386
        editor.renderValue = function renderValue(value:any) {
            if (this.quill) {
                if (value) {
                    const delta = this.quill.clipboard.convert({ html: value })
                    this.quill.setContents(delta, 'silent')
                } else {
                    this.quill.setText('')
                }
            }
        }.bind(editor) // Bind needed for production build
    })

    watch(() => props.modelValue, (newValue) => {
        localValue.value = newValue;
    });

    const handleLoadQuill = ({instance}:{instance:any}) => {
        instance.on('text-change', () => {
            emits('update:modelValue', instance.root.innerHTML);
        });
    };
</script>
