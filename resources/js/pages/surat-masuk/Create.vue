<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Impor komponen PrimeVue yang dibutuhkan untuk form
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import { useToast } from "primevue/usetoast";

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Masuk', route: route('surat-masuk.index') },
    { label: 'Tambah Baru' }
];

// Opsi untuk dropdown status disposisi
const statusDisposisiOptions = ref([
    { name: 'Belum Didisposisi', value: 'Belum Didisposisi' },
    { name: 'Sudah Didisposisi', value: 'Sudah Didisposisi' }
]);

// Menggunakan useForm untuk state management & validasi
const form = useForm({
    nomor_surat: '1',
    tanggal_surat: new Date(),
    tanggal_diterima: new Date(), // Default tanggal hari ini
    penerima: '1',
    pengirim: '1',
    perihal: '1',
    lampiran: '1',
    status_disposisi: 'Belum Didisposisi', // Nilai default
});

const submit = () => {
    form.post(route('surat-masuk.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Surat baru telah ditambahkan', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Surat Masuk" />

        <div class="w-full mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Form Tambah Surat Masuk</h3>
                    <p class="text-sm text-muted-color mt-1">Isi detail surat yang diterima di bawah ini.</p>
                </template>
                <template #content>
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="tanggal_diterima" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Diterima</label>
                                <Calendar id="tanggal_diterima" v-model="form.tanggal_diterima" class="w-full" dateFormat="dd/mm/yy" :class="{ 'p-invalid': form.errors.tanggal_diterima }" />
                                <small v-if="form.errors.tanggal_diterima" class="p-error">{{ form.errors.tanggal_diterima }}</small>
                            </div>
                            <div>
                                <label for="tanggal_surat" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Surat</label>
                                <Calendar id="tanggal_surat" v-model="form.tanggal_surat" class="w-full" dateFormat="dd/mm/yy" :class="{ 'p-invalid': form.errors.tanggal_surat }" />
                                <small v-if="form.errors.tanggal_surat" class="p-error">{{ form.errors.tanggal_surat }}</small>
                            </div>

                            <div>
                                <label for="pengirim" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pengirim</label>
                                <InputText id="pengirim" v-model="form.pengirim" class="w-full"  :class="{ 'p-invalid': form.errors.pengirim }" />
                                <small v-if="form.errors.pengirim" class="p-error">{{ form.errors.pengirim }}</small>
                            </div>
                            <div>
                                <label for="penerima" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Penerima</label>
                                <InputText id="penerima" v-model="form.penerima" class="w-full"  :class="{ 'p-invalid': form.errors.penerima }" />
                                <small v-if="form.errors.penerima" class="p-error">{{ form.errors.penerima }}</small>
                            </div>

                            <div>
                                <label for="nomor_surat" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nomor Surat</label>
                                <InputText id="nomor_surat" v-model="form.nomor_surat" class="w-full" :class="{ 'p-invalid': form.errors.nomor_surat }" />
                                <small v-if="form.errors.nomor_surat" class="p-error">{{ form.errors.nomor_surat }}</small>
                            </div>

                            <div class="md:col-span-2">
                                <label for="perihal" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Perihal</label>
                                <Textarea id="perihal" v-model="form.perihal" rows="3" class="w-full" :class="{ 'p-invalid': form.errors.perihal }" />
                                <small v-if="form.errors.perihal" class="p-error">{{ form.errors.perihal }}</small>
                            </div>
                            
                            <div>
                                <label for="lampiran" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Lampiran</label>
                                <InputText id="lampiran" v-model="form.lampiran" class="w-full" :class="{ 'p-invalid': form.errors.lampiran }" />
                                <small v-if="form.errors.lampiran" class="p-error">{{ form.errors.lampiran }}</small>
                            </div>

                            <div>
                                <label for="status_disposisi" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status Disposisi</label>
                                <Dropdown id="status_disposisi" v-model="form.status_disposisi" :options="statusDisposisiOptions" optionLabel="name" optionValue="value" class="w-full" :class="{ 'p-invalid': form.errors.status_disposisi }" />
                                <small v-if="form.errors.status_disposisi" class="p-error">{{ form.errors.status_disposisi }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-8">
                            <Link :href="route('surat-masuk.index')">
                                <Button label="Batal" severity="secondary" outlined />
                            </Link>
                            <Button type="submit" label="Simpan" :loading="form.processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>