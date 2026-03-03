<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import ToggleButton from 'primevue/togglebutton';
import Calendar from 'primevue/calendar';
import Card from 'primevue/card';
import Editor from 'primevue/editor';
import { Upload, Plus, Trash2, ArrowLeft, Image as ImageIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';

const props = defineProps({
    activity: Object,
});

const isEdit = !!props.activity.id;
const toast = useToast();
const isUploading = ref(false);

const form = useForm({
    title: props.activity.title || '',
    slug: props.activity.slug || '',
    excerpt: props.activity.excerpt || '',
    content: props.activity.content || '',
    date: props.activity.date ? new Date(props.activity.date) : new Date(),
    is_published: props.activity.is_published ?? true,
    cover_image: props.activity.cover_image || null,
});

const submit = () => {
    // Format date for backend
    const dataToSubmit = { ...form.data() };
    if (dataToSubmit.date) {
        const d = new Date(dataToSubmit.date);
        dataToSubmit.date = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
    }

    if (isEdit) {
        form.transform(() => dataToSubmit).put(route('activities.update', props.activity.id));
    } else {
        form.transform(() => dataToSubmit).post(route('activities.store'));
    }
};

const getImageUrl = (path) => path ? `/storage/${path}` : null;

// Image Upload Handling
const onImageSelect = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    isUploading.value = true;
    try {
        const formData = new FormData();
        formData.append('file', file);

        const response = await axios.post(route('files.store'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        
        form.cover_image = response.data.path;
        toast.add({ severity: 'success', summary: 'Sukses', detail: `Cover berhasil diunggah`, life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Terdapat kesalahan saat mengunggah foto', life: 3000 });
        console.error(err);
    } finally {
        isUploading.value = false;
        event.target.value = ''; // Reset input
    }
};

const removeImage = () => {
    form.cover_image = null;
};
</script>

<template>
    <AppLayout>
        <InertiaHead :title="isEdit ? 'Edit Kegiatan' : 'Tambah Kegiatan Baru'" />

        <div class="flex items-center gap-4 mb-6">
            <Link :href="route('activities.index')">
                <Button icon="pi pi-arrow-left" text rounded severity="secondary" aria-label="Kembali" class="!w-10 !h-10 !p-0" />
            </Link>
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ isEdit ? 'Edit Kegiatan' : 'Tambah Kegiatan Baru' }}
            </h2>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form Area -->
                <div class="lg:col-span-2 space-y-6">
                    <Card>
                        <template #content>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Judul Kegiatan <span class="text-red-500">*</span></label>
                                    <InputText v-model="form.title" class="w-full text-lg font-medium" placeholder="Cth: Pelatihan Mengolah Sampah Organik" :class="{ 'p-invalid': form.errors.title }" />
                                    <small class="p-error" v-if="form.errors.title">{{ form.errors.title }}</small>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Ringkasan (Excerpt)</label>
                                    <Textarea v-model="form.excerpt" rows="3" class="w-full" placeholder="Ringkasan singkat yang akan muncul di daftar kegiatan utama..." />
                                    <small class="p-error" v-if="form.errors.excerpt">{{ form.errors.excerpt }}</small>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Isi Artikel</label>
                                    <!-- Using PrimeVue Editor (Quill based) -->
                                    <Editor v-model="form.content" editorStyle="height: 400px" />
                                    <small class="p-error" v-if="form.errors.content">{{ form.errors.content }}</small>
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>

                <!-- Sidebar Settings Area -->
                <div class="lg:col-span-1 space-y-6">
                    <Card>
                        <template #title>Pengaturan</template>
                        <template #content>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Status Publikasi</label>
                                    <ToggleButton v-model="form.is_published" onLabel="Publik" offLabel="Draft" onIcon="pi pi-eye" offIcon="pi pi-eye-slash" class="w-full" />
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Publikasi</label>
                                    <Calendar v-model="form.date" dateFormat="dd/mm/yy" class="w-full" showIcon />
                                    <small class="p-error" v-if="form.errors.date">{{ form.errors.date }}</small>
                                </div>
                            </div>
                        </template>
                    </Card>

                    <Card>
                        <template #title>Sampul Artikel (Cover)</template>
                        <template #content>
                            <div class="space-y-4">
                                <!-- Existing Image -->
                                <div v-if="form.cover_image" class="aspect-video relative rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 group/img">
                                    <img :src="getImageUrl(form.cover_image)" class="w-full h-full object-cover" />
                                    
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center">
                                        <Button type="button" @click="removeImage" severity="danger" rounded class="!p-2 shadow-lg" v-tooltip.top="'Hapus Foto'">
                                            <Trash2 class="w-4 h-4" />
                                        </Button>
                                    </div>
                                </div>

                                <!-- Upload Button (Replaces cover if already exists, else shows add button) -->
                                <label :class="[
                                    'aspect-video flex flex-col items-center justify-center rounded-lg border-2 border-dashed transition-colors',
                                    isUploading ? 'border-sky-300 bg-sky-50 dark:bg-sky-900/20' : 'border-slate-300 dark:border-slate-600 hover:border-sky-400 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer',
                                    form.cover_image ? 'mt-4' : ''
                                ]">
                                    <div v-if="isUploading" class="flex flex-col items-center text-sky-600">
                                        <Upload class="w-6 h-6 animate-bounce mb-2" />
                                        <span class="text-xs font-semibold">Mengunggah...</span>
                                    </div>
                                    <div v-else class="flex flex-col items-center text-slate-400 dark:text-slate-500 hover:text-sky-500">
                                        <Plus class="w-8 h-8 mb-1" />
                                        <span class="text-xs font-medium text-center px-2">{{ form.cover_image ? 'Ganti Sampul' : 'Tambah Sampul' }}</span>
                                    </div>
                                    <input :disabled="isUploading" type="file" class="hidden" accept="image/*" @change="onImageSelect" />
                                </label>
                                <small class="text-slate-500 text-xs text-center block" v-if="!form.cover_image">Rekomendasi ukuran: 1200x630 (Rasio 16:9)</small>
                            </div>
                        </template>
                    </Card>

                    <div class="flex flex-col gap-3">
                        <Button type="submit" :label="isEdit ? 'Simpan Perubahan' : 'Terbitkan Kegiatan'" :loading="form.processing" icon="pi pi-check" size="large" />
                        <Link :href="route('activities.index')" class="w-full">
                            <Button label="Batal" severity="secondary" outlined class="w-full" />
                        </Link>
                    </div>
                </div>

            </div>
        </form>
    </AppLayout>
</template>
