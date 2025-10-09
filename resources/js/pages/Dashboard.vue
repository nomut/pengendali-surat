<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Users, Mail, Send } from 'lucide-vue-next';

// Impor komponen PrimeVue
import Card from 'primevue/card';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

// Menerima props dari DashboardController
const props = defineProps({
    stats: Object,
    latestSuratMasuk: Object,
    latestSuratKeluar: Object,
    latestSuratTugas: Object,
});

const breadcrumbs = [{ label: 'Dashboard' }];

// Helper untuk format tanggal
const formatDate = (value) => {
    return new Date(value).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric'
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Dashboard" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <Card>
                <template #content>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-muted-color">Surat Masuk</p>
                            <p class="text-2xl font-bold">{{ stats.total_surat_masuk }}</p>
                        </div>
                        <div class="p-3 bg-sky-100 rounded-full">
                            <Mail class="w-6 h-6 text-sky-600" />
                        </div>
                    </div>
                </template>
            </Card>

            <Card>
                <template #content>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-muted-color">Surat Keluar</p>
                            <p class="text-2xl font-bold">{{ stats.total_surat_keluar }}</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-full">
                            <Send class="w-6 h-6 text-orange-600" />
                        </div>
                    </div>
                </template>
            </Card>
            

            <Card>
                <template #content>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-muted-color">Surat Tugas</p>
                            <p class="text-2xl font-bold">{{ stats.total_surat_tugas }}</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-full">
                            <Send class="w-6 h-6 text-orange-600" />
                        </div>
                    </div>
                </template>
            </Card>
            
            <Card>
                <template #content>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-muted-color">Total Pengguna</p>
                            <p class="text-2xl font-bold">{{ stats.total_users }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <Users class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <Card>
                <template #content>
                    <h3 class="text-lg font-semibold mb-4">Surat Masuk Terbaru</h3>
                    <DataTable :value="latestSuratMasuk" stripedRows tableStyle="min-width: 20rem">
                        <template #empty>Belum ada surat masuk.</template>
                        <Column field="pengirim" header="Pengirim"></Column>
                        <Column field="perihal" class="truncate max-w-[230px]" header="Perihal"></Column>
                        <Column field="tanggal_diterima" header="Tanggal">
                            <template #body="{ data }">
                                {{ formatDate(data.tanggal_diterima) }}
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
            
            <Card>
                <template #content>
                    <h3 class="text-lg font-semibold mb-4">Surat Keluar Terbaru</h3>
                    <DataTable :value="latestSuratKeluar" stripedRows tableStyle="min-width: 20rem">
                        <template #empty>Belum ada surat keluar.</template>
                        <Column field="tujuan" header="Tujuan"></Column>
                        <Column field="perihal" class="truncate max-w-[230px]" header="Perihal"></Column>
                        <Column field="tanggal_surat" header="Tanggal">
                            <template #body="{ data }">
                                {{ formatDate(data.tanggal_surat) }}
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>

            <Card>
                <template #content>
                    <h3 class="text-lg font-semibold mb-4">Surat Tugas Terbaru</h3>
                    <DataTable :value="latestSuratTugas" stripedRows tableStyle="min-width: 20rem">
                        <template #empty>Belum ada surat tugas.</template>
                        <Column field="tujuan" header="Tujuan"></Column>
                        <Column field="perihal" class="truncate max-w-[230px]" header="Perihal"></Column>
                        <Column field="tanggal_surat" header="Tanggal">
                            <template #body="{ data }">
                                {{ formatDate(data.tanggal_surat) }}
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
        </div>

    </AppLayout>
</template>