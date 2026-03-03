<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Editor from 'primevue/editor';
import { useToast } from "primevue/usetoast";

import StrukturOrganisasiEditor from './meta-editors/StrukturOrganisasiEditor.vue';
import ProfilOrganisasiEditor from './meta-editors/ProfilOrganisasiEditor.vue';
import HomeEditor from './meta-editors/HomeEditor.vue';
import PokjaEditor from './meta-editors/PokjaEditor.vue';

const props = defineProps({
    page: Object,
});

const activeMetaEditor = computed(() => {
    switch (props.page.slug) {
        case 'struktur-organisasi': return StrukturOrganisasiEditor;
        case 'profil-organisasi': return ProfilOrganisasiEditor;
        case 'home': return HomeEditor;
        default: 
            if (props.page.slug?.startsWith('pokja-')) return PokjaEditor;
            return null;
    }
});

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'CMS Halaman', route: route('cms.index') },
    { label: `Edit: ${props.page.title}` }
];

const form = useForm({
    title: props.page.title,
    content: props.page.content || '',
    meta: props.page.meta || {},
});

const submitForm = () => {
    form.put(route('cms.update', props.page.id), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Halaman berhasil diperbarui', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Edit: ${page.title}`" />

        <div class="max-w-4xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Edit Halaman: {{ page.title }}</h3>
                    <p class="text-sm text-muted-color mt-1">Slug: <code class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-sm">{{ page.slug }}</code></p>
                </template>
                <template #content>
                    <form @submit.prevent="submitForm">
                        <div class="flex flex-col gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul Halaman <span class="text-red-500">*</span></label>
                                <InputText id="title" v-model="form.title" class="w-full" :class="{ 'p-invalid': form.errors.title }" />
                                <small v-if="form.errors.title" class="p-error">{{ form.errors.title }}</small>
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Konten Halaman</label>
                                <Editor v-model="form.content" editorStyle="height: 400px" />
                                <small v-if="form.errors.content" class="p-error">{{ form.errors.content }}</small>
                            </div>
                        </div>

                        <!-- Dynamic Meta Editor -->
                        <div class="mt-8 border-t pt-8">
                            <h3 class="text-xl font-bold text-slate-800 mb-6">Pengaturan Tambahan (Meta)</h3>
                            
                            <component 
                                :is="activeMetaEditor" 
                                v-if="activeMetaEditor"
                                v-model="form.meta" 
                            />
                            <div v-else class="p-4 bg-slate-50 rounded text-slate-500 text-sm">
                                Halaman ini tidak memiliki pengaturan meta khusus.
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-8">
                            <Link :href="route('cms.index')">
                                <Button type="button" label="Batal" severity="secondary" outlined />
                            </Link>
                            <Button type="submit" label="Simpan Perubahan" :loading="form.processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
