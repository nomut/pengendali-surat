<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

// Impor komponen PrimeVue
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import DatePicker from 'primevue/datepicker';
import Chips from 'primevue/chips';
import FileUpload from 'primevue/fileupload';
import { useToast } from "primevue/usetoast";

// Impor Ikon
import { Save, X } from 'lucide-vue-next';

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Tugas', route: route('surat-tugas.index') },
    { label: 'Tambah Baru' }
];

const fileUploadRef = ref(null);
const isUploading = ref(false);

// State form disesuaikan untuk Surat Tugas
const form = useForm({
    nomor_surat: '',
    tanggal_surat: new Date(),
    tujuan: '',
    perihal: '',
    lampiran: [],
    tags: [],
});

// Fungsi unggah file (SAMA PERSIS DENGAN FILE PATOKAN ANDA)
const uploadFiles = async () => {
    if (!fileUploadRef.value || !fileUploadRef.value.files || fileUploadRef.value.files.length === 0) {
        return [];
    }
    isUploading.value = true;
    const uploadPromises = fileUploadRef.value.files.map(file => {
        const formData = new FormData();
        formData.append('file', file);
        return axios.post(route('files.store'), formData);
    });
    try {
        const responses = await Promise.all(uploadPromises);
        toast.add({ severity: 'info', summary: 'Berhasil', detail: 'Semua file lampiran telah diunggah.', life: 3000 });
        return responses.map(response => response.data.id);
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Terjadi kesalahan saat mengunggah file.', life: 3000 });
        throw new Error("File upload failed");
    } finally {
        isUploading.value = false;
    }
};

// Fungsi submit utama (SAMA PERSIS DENGAN FILE PATOKAN ANDA)
const submit = async () => {
    try {
        const uploadedFileIds = await uploadFiles();
        form.lampiran = uploadedFileIds;
        form.post(route('surat-tugas.store'), {
            onSuccess: () => {
                toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Surat tugas baru telah ditambahkan.', life: 3000 });
            },
        });
    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Surat Tugas" />

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <div class="lg:col-span-3">
                    <Card class="h-full">
                        <template #title>
                            <h3 class="text-lg font-semibold">Informasi Surat Tugas</h3>
                        </template>
                        <template #content>
                            <div class="flex flex-col gap-6">
                                <div>
                                    <label for="nomor_surat" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Surat <span class="text-red-500">*</span></label>
                                    <InputText id="nomor_surat" v-model="form.nomor_surat" class="w-full" placeholder="Contoh: 090/ST/DPMPTSP/X/2025" :invalid="!!form.errors.nomor_surat" />
                                    <small class="p-error">{{ form.errors.nomor_surat }}</small>
                                </div>
                                <div>
                                    <label for="tanggal_surat" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Surat <span class="text-red-500">*</span></label>
                                    <DatePicker id="tanggal_surat" v-model="form.tanggal_surat" class="w-full" inputClass="w-full" dateFormat="dd/mm/yy" :invalid="!!form.errors.tanggal_surat" />
                                    <small class="p-error">{{ form.errors.tanggal_surat }}</small>
                                </div>
                                <div>
                                    <label for="tujuan" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tujuan <span class="text-red-500">*</span></label>
                                    <Textarea id="tujuan" v-model="form.tujuan" rows="3" class="w-full" placeholder="Nama pegawai atau tim yang diberi tugas" :invalid="!!form.errors.tujuan" />
                                    <small class="p-error">{{ form.errors.tujuan }}</small>
                                </div>
                                <div>
                                    <label for="perihal" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Perihal / Dasar Tugas <span class="text-red-500">*</span></label>
                                    <Textarea id="perihal" v-model="form.perihal" rows="4" class="w-full" placeholder="Uraian singkat mengenai tugas yang diberikan" :invalid="!!form.errors.perihal" />
                                    <small class="p-error">{{ form.errors.perihal }}</small>
                                </div>
                                <div>
                                    <label for="lampiran" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Lampiran</label>
                                    <FileUpload 
                                        ref="fileUploadRef"
                                        name="lampiran[]" 
                                        :multiple="true" 
                                        accept=".pdf,.doc,.docx,.jpg,.png,.zip" 
                                        :maxFileSize="2000000"
                                        :auto="false" 
                                        chooseLabel="Pilih File"
                                        :showUploadButton="false"
                                        :showCancelButton="false"
                                    >
                                        <template #empty>
                                            <p>Seret dan lepas file ke sini.</p>
                                        </template>
                                    </FileUpload>
                                    <small class="p-error">{{ form.errors.lampiran }}</small>
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
                                    <Chips id="tags" v-model="form.tags" class="w-full" separator="," placeholder="Ketik tag..."/>
                                </div>
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex flex-row gap-3 pt-4">
                                <Button type="submit" label="Simpan Surat" :loading="form.processing || isUploading">
                                    <template #icon><Save class="w-4 h-4 mr-2" /></template>
                                </Button>
                                <Link :href="route('surat-tugas.index')">
                                    <Button label="Batal" severity="secondary" outlined class="w-full">
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