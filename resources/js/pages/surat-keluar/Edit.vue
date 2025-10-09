<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';

// Impor komponen PrimeVue
import AppLayout from '@/layouts/AppLayout.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import DatePicker from 'primevue/datepicker';
import Chips from 'primevue/chips';
import FileUpload from 'primevue/fileupload';
import { useToast } from "primevue/usetoast";

// Impor Ikon (disamakan persis dengan file patokan Anda)
import { Save, X, Trash2, FileImage, FileType2, FileBadge, UploadCloud } from 'lucide-vue-next';

const props = defineProps({
    surat: Object,
});

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Keluar', route: route('surat-keluar.index') }, // Diubah
    { label: 'Edit Surat' }
];

const fileUploadRef = ref(null);
const existingFiles = ref(props.surat.files || []);
const isUploading = ref(false);

// Inisialisasi form disesuaikan untuk Surat Keluar
const form = useForm({
    _method: 'PUT',
    nomor_surat: props.surat.nomor_surat,
    tanggal_surat: new Date(props.surat.tanggal_surat),
    tujuan: props.surat.tujuan, // 'pengirim' diubah menjadi 'tujuan'
    perihal: props.surat.perihal,
    tembusan: props.surat.tembusan, // Kolom baru
    lampiran: [], // Akan diisi dengan ID file final
    tags: props.surat.tags ? props.surat.tags.map(tag => tag.name.en) : [],
});

// Fungsi untuk mengunggah file baru (SAMA PERSIS DENGAN FILE PATOKAN ANDA)
const uploadNewFiles = async () => {
    if (!fileUploadRef.value || !fileUploadRef.value.files || fileUploadRef.value.files.length === 0) {
        return [];
    }
    isUploading.value = true;
    const uploadPromises = fileUploadRef.value.files.map(file => {
        const formData = new FormData();
        formData.append('file', file);
        return axios.post(route('files.store'), formData); // Menggunakan files.store
    });
    try {
        const responses = await Promise.all(uploadPromises);
        toast.add({ severity: 'info', summary: 'Berhasil', detail: 'File baru telah diunggah.', life: 3000 });
        return responses.map(response => response.data.id);
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal mengunggah file baru.', life: 3000 });
        throw new Error("File upload failed");
    } finally {
        isUploading.value = false;
    }
};

// Fungsi untuk menghapus file yang sudah ada (SAMA PERSIS DENGAN FILE PATOKAN ANDA)
const removeExistingFile = async (fileToRemove) => {
    try {
        await axios.delete(route('files.destroy', fileToRemove.id));
        existingFiles.value = existingFiles.value.filter(file => file.id !== fileToRemove.id);
        toast.add({ severity: 'info', summary: 'Dihapus', detail: `File ${fileToRemove.original_name} dihapus.`, life: 3000 });
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal menghapus file.', life: 3000 });
    }
};


// Fungsi submit utama (SAMA PERSIS DENGAN FILE PATOKAN ANDA)
const submit = async () => {
    try {
        const newFileIds = await uploadNewFiles();
        const existingFileIds = existingFiles.value.map(file => file.id);
        form.lampiran = [...existingFileIds, ...newFileIds];

        form.post(route('surat-keluar.update', props.surat.id), { // Route diubah
            onSuccess: () => {
                toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Data surat keluar telah diperbarui', life: 3000 }); // Pesan diubah
            },
        });
    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Edit Surat: ${surat.nomor_surat}`" />

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <div class="lg:col-span-3">
                    <Card class="h-full">
                        <template #title>
                            <h3 class="text-lg font-semibold">Informasi Surat</h3>
                        </template>
                        <template #content>
                            <div class="flex flex-col gap-6">
                                <div>
                                    <label for="tujuan" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tujuan <span class="text-red-500">*</span></label>
                                    <InputText id="tujuan" v-model="form.tujuan" class="w-full" :invalid="!!form.errors.tujuan" />
                                    <small class="p-error">{{ form.errors.tujuan }}</small>
                                </div>
                                <div>
                                    <label for="nomor_surat" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Surat <span class="text-red-500">*</span></label>
                                    <InputText id="nomor_surat" v-model="form.nomor_surat" class="w-full" :invalid="!!form.errors.nomor_surat" />
                                    <small class="p-error">{{ form.errors.nomor_surat }}</small>
                                </div>
                                <div>
                                    <label for="tanggal_surat" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Surat <span class="text-red-500">*</span></label>
                                    <DatePicker id="tanggal_surat" v-model="form.tanggal_surat" class="w-full" inputClass="w-full" dateFormat="dd/mm/yy" :invalid="!!form.errors.tanggal_surat" />
                                    <small class="p-error">{{ form.errors.tanggal_surat }}</small>
                                </div>
                                <div>
                                    <label for="perihal" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Perihal / Subjek Surat <span class="text-red-500">*</span></label>
                                    <Textarea id="perihal" v-model="form.perihal" rows="4" class="w-full" :invalid="!!form.errors.perihal" />
                                    <small class="p-error">{{ form.errors.perihal }}</small>
                                </div>
                                <div>
                                    <label for="tembusan" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tembusan</label>
                                    <Textarea id="tembusan" v-model="form.tembusan" rows="3" class="w-full" :invalid="!!form.errors.tembusan" />
                                    <small class="p-error">{{ form.errors.tembusan }}</small>
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Lampiran</label>
                                        <FileUpload 
                                            ref="fileUploadRef"
                                            name="lampiran[]" 
                                            :multiple="true" 
                                            accept=".pdf,.doc,.docx,.jpg,.png,.zip" 
                                            :maxFileSize="2000000"
                                            :auto="false" 
                                            chooseLabel="Tambah File Baru"
                                            :showUploadButton="false"
                                            :showCancelButton="false"
                                        >                                            
                                            <template #empty>
                                                <div class="flex items-center justify-center flex-col">
                                                    <span class="pi pi-cloud-upload !border-2 !rounded-full !p-8 !text-4xl !text-muted-color">
                                                        <UploadCloud class="w-16 h-16" />
                                                    </span>
                                                    <p class="mt-6 mb-0">Drag and drop files to here to upload.</p>
                                                </div>
                                            </template>
                                        </FileUpload>

                                        <div v-if="existingFiles.length > 0" class="mt-6">
                                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                                <div v-for="file in existingFiles" :key="file.id" class="relative group rounded-lg shadow-sm overflow-hidden transition-shadow hover:shadow-lg">
                                                    <a :href="file.url" target="_blank" class="block w-full aspect-square flex items-center justify-center bg-slate-100 dark:bg-slate-700">
                                                        <img v-if="file.mime_type.includes('image')" :src="file.preview_url" :alt="file.original_name" class="w-full h-full object-cover">
                                                        <FileImage v-else-if="file.mime_type.includes('pdf')" class="text-red-500 w-36 h-36"/>
                                                        <FileType2 v-else-if="file.mime_type.includes('zip')" class="text-yellow-500 w-36 h-36"/>
                                                        <FileBadge v-else  class="text-blue-500 w-36 h-36"/>
                                                    </a>
                                                    <div class="p-3 bg-white dark:bg-slate-800">
                                                        <p class="font-medium text-sm text-slate-800 dark:text-slate-200 truncate" :title="file.original_name">
                                                            {{ file.original_name }}
                                                        </p>
                                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                                            {{ (file.size / 1024).toFixed(2) }} KB
                                                        </p>
                                                    </div>
                                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                        <Button class="p-button-rounded p-button-danger" @click="removeExistingFile(file)" v-tooltip.top="'Hapus File'">
                                                            <Trash2 class="w-4 h-4" />
                                                        </Button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>

                <div class="lg:col-span-1">
                    <Card class="h-full">
                        <template #title>
                            <h3 class="text-lg font-semibold">Pencatatan</h3>
                        </template>
                        <template #content>
                            <div class="flex flex-col gap-6">
                                <div>
                                    <label for="tags" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tags / Label</label>
                                    <Chips id="tags" v-model="form.tags" class="w-full" separator="," />
                                </div>
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex flex-row gap-3 pt-4">
                                <Button type="submit" label="Simpan" :loading="form.processing || isUploading"> <template #icon><Save class="w-4 h-4 mr-2" /></template>
                                </Button>
                                <Link :href="route('surat-keluar.index')"> <Button label="Batal" severity="secondary" outlined class="w-full">
                                        <template #icon><X class="w-4 h-4 mr-2" /></template>
                                    </Button>
                                </Link>
                            </div>
                        </template>
                    </Card>
                </div>

            </div>
        </form>
    </AppLayout>
</template>