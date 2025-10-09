<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

// Impor komponen PrimeVue (sama persis dengan file Anda)
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import DatePicker from 'primevue/datepicker';
import Chips from 'primevue/chips';
import FileUpload from 'primevue/fileupload';
import { useToast } from "primevue/usetoast";
// Impor Ikon (sama persis dengan file Anda)
import { Save, X } from 'lucide-vue-next';

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Keluar', route: route('surat-keluar.index') }, // Diubah
    { label: 'Tambah Baru' }
];

const fileUploadRef = ref(null);
const isUploading = ref(false);

// State form disesuaikan untuk Surat Keluar
const form = useForm({
    nomor_surat: '',
    tanggal_surat: new Date(),
    tujuan: '', // Menggantikan 'pengirim'
    perihal: '',
    tembusan: '', // Kolom baru
    lampiran: [],
    tags: [],
});

// Fungsi untuk mengunggah file (LOGIKA SAMA PERSIS DENGAN FILE ANDA)
const uploadFiles = async () => {
    if (!fileUploadRef.value || !fileUploadRef.value.files || fileUploadRef.value.files.length === 0) {
        return []; // Kembalikan array kosong jika tidak ada file
    }

    isUploading.value = true;
    const uploadPromises = fileUploadRef.value.files.map(file => {
        const formData = new FormData();
        formData.append('file', file);
        return axios.post(route('files.store'), formData); // Memanggil route('files.store')
    });

    try {
        const responses = await Promise.all(uploadPromises);
        toast.add({ severity: 'info', summary: 'Berhasil', detail: 'Semua file lampiran telah diunggah.', life: 3000 });
        // Kembalikan array dari ID file yang berhasil diunggah
        return responses.map(response => response.data.id);
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Terjadi kesalahan saat mengunggah file.', life: 3000 });
        // Lemparkan error agar proses submit berhenti
        throw new Error("File upload failed");
    } finally {
        isUploading.value = false;
    }
};

// Fungsi submit utama (LOGIKA SAMA PERSIS DENGAN FILE ANDA)
const submit = async () => {
    try {
        // 1. Upload file terlebih dahulu
        const uploadedFileIds = await uploadFiles();
        
        // 2. Masukkan ID file ke dalam form
        form.lampiran = uploadedFileIds;

        // 3. Kirim form utama dengan data dan ID file
        form.post(route('surat-keluar.store'), { // Route diubah ke surat-keluar.store
            onSuccess: () => {
                toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Surat keluar baru telah ditambahkan', life: 3000 }); // Pesan diubah
            },
        });
    } catch (error) {
        // Jika upload gagal, form tidak akan dikirim.
        console.error(error);
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Surat Keluar" />

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
                                    <InputText id="tujuan" v-model="form.tujuan" class="w-full" placeholder="Nama instansi/perorangan tujuan" :invalid="!!form.errors.tujuan" />
                                    <small class="p-error">{{ form.errors.tujuan }}</small>
                                </div>
                                <div>
                                    <label for="nomor_surat" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Surat <span class="text-red-500">*</span></label>
                                    <InputText id="nomor_surat" v-model="form.nomor_surat" class="w-full" placeholder="Contoh: 123/A/IX/2025" :invalid="!!form.errors.nomor_surat" />
                                    <small class="p-error">{{ form.errors.nomor_surat }}</small>
                                </div>
                                <div>
                                    <label for="tanggal_surat" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Surat <span class="text-red-500">*</span></label>
                                    <DatePicker id="tanggal_surat" v-model="form.tanggal_surat" class="w-full" inputClass="w-full" dateFormat="dd/mm/yy" :invalid="!!form.errors.tanggal_surat" />
                                    <small class="p-error">{{ form.errors.tanggal_surat }}</small>
                                </div>
                                <div>
                                    <label for="perihal" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Perihal / Subjek Surat <span class="text-red-500">*</span></label>
                                    <Textarea id="perihal" v-model="form.perihal" rows="4" class="w-full" placeholder="Tuliskan perihal utama surat..." :invalid="!!form.errors.perihal" />
                                    <small class="p-error">{{ form.errors.perihal }}</small>
                                </div>
                                <div>
                                    <label for="tembusan" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Tembusan</label>
                                    <Textarea id="tembusan" v-model="form.tembusan" rows="3" class="w-full" placeholder="Tuliskan pihak-pihak tembusan..." :invalid="!!form.errors.tembusan" />
                                    <small class="p-error">{{ form.errors.tembusan }}</small>
                                </div>
                                <div>
                                    <label for="lampiran" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Lampiran</label>
                                    <FileUpload 
                                        ref="fileUploadRef"
                                        name="lampiran[]" 
                                        :multiple="true" 
                                        accept=".pdf,.doc,.docx,.jpg,.png,.zip,.jpeg,.webp" 
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
                                <Button type="submit" label="Simpan Surat" :loading="form.processing || isUploading"> <template #icon><Save class="w-4 h-4 mr-2" /></template>
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