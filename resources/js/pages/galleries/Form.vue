<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import ToggleButton from 'primevue/togglebutton';
import Calendar from 'primevue/calendar';
import Card from 'primevue/card';
import { Upload, Plus, Trash, ArrowLeft, Image as ImageIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';

const props = defineProps({
    gallery: Object,
});

const isEdit = !!props.gallery.id;
const toast = useToast();
const isUploading = ref(false);

const form = useForm({
    title: props.gallery.title || '',
    description: props.gallery.description || '',
    date: props.gallery.date ? new Date(props.gallery.date) : new Date(),
    is_published: props.gallery.is_published ?? true,
    images: Array.isArray(props.gallery.images) ? props.gallery.images : [],
});

const submit = () => {
    // Format date for backend
    const dataToSubmit = { ...form.data() };
    if (dataToSubmit.date) {
        const d = new Date(dataToSubmit.date);
        dataToSubmit.date = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
    }

    if (isEdit) {
        form.transform(() => dataToSubmit).put(route('galleries.update', props.gallery.id));
    } else {
        form.transform(() => dataToSubmit).post(route('galleries.store'));
    }
};

const getImageUrl = (path) => path ? `/storage/${path}` : null;

// Image Upload Handling
const onImageSelect = async (event) => {
    const files = event.target.files;
    if (!files.length) return;

    isUploading.value = true;
    try {
        for(let i = 0; i < files.length; i++) {
            const formData = new FormData();
            formData.append('file', files[i]);

            const response = await axios.post(route('files.store'), formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            
            form.images.push(response.data.path);
        }
        toast.add({ severity: 'success', summary: 'Sukses', detail: `${files.length} foto berhasil diunggah`, life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Terdapat kesalahan saat mengunggah foto', life: 3000 });
        console.error(err);
    } finally {
        isUploading.value = false;
        event.target.value = ''; // Reset input
    }
};

const removeImage = (index) => {
    form.images.splice(index, 1);
};
</script>

<template>
    <AppLayout>
        <InertiaHead :title="isEdit ? 'Edit Galeri' : 'Tambah Galeri Baru'" />

        <div class="flex items-center gap-4 mb-6">
            <Link :href="route('galleries.index')">
                <Button icon="pi pi-arrow-left" text rounded severity="secondary" aria-label="Kembali" class="!w-10 !h-10 !p-0" />
            </Link>
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ isEdit ? 'Edit Galeri' : 'Tambah Galeri Baru' }}
            </h2>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <Card>
                <template #title>Informasi Galeri</template>
                <template #content>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="col-span-1 md:col-span-2 space-y-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Judul Kegiatan <span class="text-red-500">*</span></label>
                            <InputText v-model="form.title" class="w-full" placeholder="Cth: Sosialisasi Pokja I" :class="{ 'p-invalid': form.errors.title }" />
                            <small class="p-error" v-if="form.errors.title">{{ form.errors.title }}</small>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Kegiatan</label>
                            <Calendar v-model="form.date" dateFormat="dd/mm/yy" class="w-full" showIcon />
                            <small class="p-error" v-if="form.errors.date">{{ form.errors.date }}</small>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Status Publikasi</label>
                            <ToggleButton v-model="form.is_published" onLabel="Publik" offLabel="Draft" onIcon="pi pi-eye" offIcon="pi pi-eye-slash" class="w-full sm:w-auto" />
                        </div>

                        <div class="col-span-1 md:col-span-2 space-y-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi Singkat</label>
                            <Textarea v-model="form.description" rows="3" class="w-full" placeholder="Keterangan singkat tentang kegiatan ini..." />
                            <small class="p-error" v-if="form.errors.description">{{ form.errors.description }}</small>
                        </div>

                    </div>
                </template>
            </Card>

            <Card>
                <template #title>
                    <div class="flex items-center justify-between">
                        <span>Foto Kegiatan</span>
                        <span class="text-sm font-normal text-slate-500">{{ form.images.length }} Foto</span>
                    </div>
                </template>
                <template #content>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        
                        <!-- Existing Images -->
                        <div v-for="(img, index) in form.images" :key="index" class="aspect-square relative group/img rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800">
                            <img :src="getImageUrl(img)" class="w-full h-full object-cover" />
                            
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center">
                                <Button type="button" @click="removeImage(index)" severity="danger" rounded class="!p-2 shadow-lg" v-tooltip.top="'Hapus Foto'">
                                    <Trash class="w-4 h-4" />
                                </Button>
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <label :class="[
                            'aspect-square flex flex-col items-center justify-center rounded-lg border-2 border-dashed transition-colors',
                            isUploading ? 'border-sky-300 bg-sky-50 dark:bg-sky-900/20' : 'border-slate-300 dark:border-slate-600 hover:border-sky-400 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer'
                        ]">
                            <div v-if="isUploading" class="flex flex-col items-center text-sky-600">
                                <Upload class="w-6 h-6 animate-bounce mb-2" />
                                <span class="text-xs font-semibold">Mengunggah...</span>
                            </div>
                            <div v-else class="flex flex-col items-center text-slate-400 dark:text-slate-500 group-hover:text-sky-500">
                                <Plus class="w-8 h-8 mb-1" />
                                <span class="text-xs font-medium text-center px-2">Tambah Foto<br>(Bisa Pilih Banyak)</span>
                            </div>
                            <input :disabled="isUploading" type="file" multiple class="hidden" accept="image/*" @change="onImageSelect" />
                        </label>

                    </div>
                    <small class="p-error block mt-2" v-if="form.errors.images">{{ form.errors.images }}</small>
                </template>
            </Card>

            <div class="flex items-center justify-end gap-4">
                <Link :href="route('galleries.index')">
                    <Button label="Batal" severity="secondary" text />
                </Link>
                <Button type="submit" :label="isEdit ? 'Simpan Perubahan' : 'Tambah Galeri'" :loading="form.processing" icon="pi pi-save" />
            </div>

        </form>
    </AppLayout>
</template>
