<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Upload, Trash } from 'lucide-vue-next';
import axios from 'axios';
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

const isUploadingMainImage = ref(false);

const onMainImageSelect = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    isUploadingMainImage.value = true;
    try {
        const response = await axios.post(route('files.store'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        
        form.meta.main_image = response.data.path;
        toast.add({ severity: 'success', summary: 'Sukses', detail: 'Gambar Utama berhasil diunggah', life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal mengunggah Gambar Utama', life: 3000 });
        console.error(err);
    } finally {
        isUploadingMainImage.value = false;
        event.target.value = '';
    }
};

const removeMainImage = () => {
    delete form.meta.main_image;
};

const getImageUrl = (path) => {
    if (!path) return null;
    return `/storage/${path}`;
};

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

                            <!-- Gambar Utama Section -->
                            <div class="border border-slate-200 dark:border-slate-700 p-4 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Gambar Utama (Featured Image)</label>
                                <div class="flex flex-col sm:flex-row gap-6">
                                    <div class="w-full sm:w-64 h-40 bg-slate-200 dark:bg-slate-700 rounded-lg overflow-hidden border border-slate-300 dark:border-slate-600 flex items-center justify-center relative group shrink-0 shadow-inner">
                                        <img v-if="form.meta.main_image" :src="getImageUrl(form.meta.main_image)" class="w-full h-full object-cover" />
                                        <span v-else class="text-slate-400 dark:text-slate-500 text-sm">Belum ada gambar</span>
                                        
                                        <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                            <Upload class="w-6 h-6 mb-1" />
                                            <span class="text-xs font-semibold ml-2" v-if="isUploadingMainImage">Mengunggah...</span>
                                            <input :disabled="isUploadingMainImage" type="file" class="hidden" accept="image/*" @change="onMainImageSelect" />
                                        </label>
                                    </div>
                                    <div class="flex flex-col justify-center gap-2">
                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                            Gambar ini akan digunakan sebagai banner utama di halaman publik.
                                        </p>
                                        <div v-if="form.meta.main_image">
                                            <Button @click="removeMainImage" type="button" size="small" text severity="danger" class="p-0 text-xs">
                                                <Trash class="w-4 h-4 mr-1" /> Hapus Gambar
                                            </Button>
                                        </div>
                                    </div>
                                </div>
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
