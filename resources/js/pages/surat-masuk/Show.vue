<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

// Impor komponen PrimeVue & Ikon
import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Divider from 'primevue/divider';
import { ArrowLeft, Printer, FileEdit } from 'lucide-vue-next';

const props = defineProps({
    surat: Object, // Menerima data surat yang akan ditampilkan
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Masuk', route: route('surat-masuk.index') },
    { label: 'Detail Surat' }
];

// Helper untuk format tanggal
const formatDate = (value) => {
    if (!value) return '-';
    return new Date(value).toLocaleDateString('id-ID', {
        weekday: 'long', day: '2-digit', month: 'long', year: 'numeric'
    });
};

// Helper untuk warna Tag
const getDisposisiSeverity = (status) => {
    if (status === 'Sudah Didisposisi') return 'success';
    if (status === 'Belum Didisposisi') return 'warning';
    return 'info';
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Detail Surat: ${surat.perihal}`" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <Card>
                    <template #title>
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">{{ surat.perihal }}</h3>
                                <p class="text-sm text-muted-color mt-1">
                                    Dari: <span class="font-semibold">{{ surat.pengirim }}</span>
                                </p>
                            </div>
                            <Tag :value="surat.status_disposisi" :severity="getDisposisiSeverity(surat.status_disposisi)" />
                        </div>
                    </template>
                    <template #content>
                        <Divider />
                        <div class="prose max-w-none text-slate-600 dark:text-slate-300">
                            <h4>Isi Ringkas / Catatan</h4>
                            <p>
                                {{ surat.isi_ringkas || 'Tidak ada isi ringkas atau catatan untuk surat ini.' }}
                            </p>
                            
                            <h4>Lampiran</h4>
                            <p>
                                {{ surat.lampiran || 'Tidak ada lampiran.' }}
                            </p>
                        </div>
                    </template>
                </Card>
            </div>

            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <Card>
                        <template #title>
                            <h4 class="text-lg font-semibold">Informasi Surat</h4>
                        </template>
                        <template #content>
                            <ul class="space-y-4 text-sm">
                                <li class="flex justify-between">
                                    <span class="text-muted-color">Nomor Surat:</span>
                                    <span class="font-semibold text-right">{{ surat.nomor_surat }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-muted-color">Tanggal Surat:</span>
                                    <span class="font-semibold">{{ formatDate(surat.tanggal_surat) }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-muted-color">Tanggal Diterima:</span>
                                    <span class="font-semibold">{{ formatDate(surat.tanggal_diterima) }}</span>
                                </li>
                            </ul>
                        </template>
                    </Card>
                    
                    <Card>
                        <template #title>
                             <h4 class="text-lg font-semibold">Pratinjau Dokumen</h4>
                        </template>
                        <template #content>
                            <div class="flex items-center justify-center h-48 bg-slate-100 dark:bg-slate-800 rounded-md">
                                <span class="text-muted-color text-sm">Pratinjau tidak tersedia</span>
                                </div>
                        </template>
                    </Card>

                    <Card>
                        <template #content>
                            <div class="flex flex-col space-y-3">
                                <Link :href="route('surat-masuk.index')">
                                    <Button label="Kembali ke Daftar" severity="secondary" outlined class="w-full">
                                        <template #icon><ArrowLeft class="w-4 h-4 mr-2" /></template>
                                    </Button>
                                </Link>
                                <Button label="Disposisi / Edit" severity="info" class="w-full">
                                     <template #icon><FileEdit class="w-4 h-4 mr-2" /></template>
                                </Button>
                                <Button label="Cetak" severity="contrast" class="w-full">
                                    <template #icon><Printer class="w-4 h-4 mr-2" /></template>
                                </Button>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
/* Menambahkan style dasar untuk konten teks */
.prose h4 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}
</style>