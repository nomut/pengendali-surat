<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Users, Mail, Send, Eye, Compass, CalendarClock } from 'lucide-vue-next';

// Impor komponen PrimeVue
import Card from 'primevue/card';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

// Menerima semua props yang diperlukan, termasuk props baru untuk Rapat
const props = defineProps({
    stats: Object,
    upcomingMeetings: Object,
    pastMeetings: Object,
    latestSuratMasuk: Object,
    latestSuratKeluar: Object,
    latestSuratTugas: Object,
    auth: Object,
});

const breadcrumbs = [{ label: 'Dashboard' }];

// Helper untuk format tanggal saja
const formatDate = (value) => {
    if (!value) return '';
    return new Date(value).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric'
    });
};

// Helper untuk format tanggal dan waktu
const formatDateTime = (value) => {
    if (!value) return '';
    return new Date(value).toLocaleString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Dashboard" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <Card>
                <template #content>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-muted-color">Total Rapat</p>
                            <p class="text-2xl font-bold">{{ stats.total_meetings }}</p>
                        </div>
                        <div class="p-3 bg-cyan-100 rounded-full">
                            <CalendarClock class="w-6 h-6 text-cyan-600" />
                        </div>
                    </div>
                </template>
            </Card>
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
                        <div class="p-3 bg-slate-100 rounded-full">
                            <Compass class="w-6 h-6 text-slate-600" />
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <Card>
                <template #content>
                    <h3 class="text-lg font-semibold mb-4">Rapat Akan Datang</h3>
                    <DataTable :value="upcomingMeetings" stripedRows tableStyle="min-width: 20rem">
                        <template #empty>Tidak ada rapat yang akan datang.</template>
                        <Column field="starts_at" header="Waktu">
                            <template #body="{ data }">{{ formatDateTime(data.starts_at) }}</template>
                        </Column>
                        <Column field="title" header="Judul Rapat" class="truncate max-w-[230px]"></Column>
                        <Column v-if="props.auth.permissions.includes('rapat-index')" bodyClass="text-center">
                            <template #body="{ data }">
                                <Link :href="route('meetings.show', data.id)">
                                    <Button class="p-button-rounded p-button-link" v-tooltip.top="'Lihat Detail'"><Eye class="w-4 h-4" /></Button>
                                </Link>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
            <Card>
                <template #content>
                    <h3 class="text-lg font-semibold mb-4">Rapat Terdahulu</h3>
                    <DataTable :value="pastMeetings" stripedRows tableStyle="min-width: 20rem">
                        <template #empty>Belum ada riwayat rapat.</template>
                        <Column field="starts_at" header="Waktu">
                            <template #body="{ data }">{{ formatDateTime(data.starts_at) }}</template>
                        </Column>
                        <Column field="title" header="Judul Rapat" class="truncate max-w-[230px]"></Column>
                        <Column v-if="props.auth.permissions.includes('rapat-index')" bodyClass="text-center">
                            <template #body="{ data }">
                                <Link :href="route('meetings.show', data.id)">
                                    <Button class="p-button-rounded p-button-link" v-tooltip.top="'Lihat Detail'"><Eye class="w-4 h-4" /></Button>
                                </Link>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <Card>
                <template #content>
                    <h3 class="text-lg font-semibold mb-4">Surat Masuk Terbaru</h3>
                    <DataTable :value="latestSuratMasuk" stripedRows tableStyle="min-width: 20rem">
                        <template #empty>Belum ada surat masuk.</template>
                        <Column field="tanggal_diterima" header="Tanggal">
                            <template #body="{ data }">{{ formatDate(data.tanggal_diterima) }}</template>
                        </Column>
                        <Column field="pengirim" header="Pengirim"></Column>
                        <Column field="perihal" class="truncate max-w-[230px]" header="Perihal"></Column>
                        <Column v-if="props.auth.permissions.includes('surat-masuk-index')" bodyClass="text-center">
                            <template #body="{ data }">
                                <Link :href="route('surat-masuk.show', data.id)">
                                    <Button class="p-button-rounded p-button-link" v-tooltip.top="'Lihat Detail'"><Eye class="w-4 h-4" /></Button>
                                </Link>
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
                        <Column field="tanggal_surat" header="Tanggal">
                            <template #body="{ data }">{{ formatDate(data.tanggal_surat) }}</template>
                        </Column>
                        <Column field="tujuan" header="Tujuan"></Column>
                        <Column field="perihal" class="truncate max-w-[230px]" header="Perihal"></Column>
                        <Column v-if="props.auth.permissions.includes('surat-keluar-index')" bodyClass="text-center">
                            <template #body="{ data }">
                                <Link :href="route('surat-keluar.show', data.id)">
                                    <Button class="p-button-rounded p-button-link" v-tooltip.top="'Lihat Detail'"><Eye class="w-4 h-4" /></Button>
                                </Link>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>

            <Card class="lg:col-span-2"> <template #content>
                    <h3 class="text-lg font-semibold mb-4">Surat Tugas Terbaru</h3>
                    <DataTable :value="latestSuratTugas" stripedRows tableStyle="min-width: 20rem">
                        <template #empty>Belum ada surat tugas.</template>
                        <Column field="tanggal_surat" header="Tanggal">
                            <template #body="{ data }">{{ formatDate(data.tanggal_surat) }}</template>
                        </Column>
                        <Column field="tujuan" header="Tujuan"></Column>
                        <Column field="perihal" class="truncate max-w-[230px]" header="Perihal"></Column>
                        <Column v-if="props.auth.permissions.includes('surat-tugas-index')" bodyClass="text-center">
                            <template #body="{ data }">
                                <Link :href="route('surat-tugas.show', data.id)">
                                    <Button class="p-button-rounded p-button-link" v-tooltip.top="'Lihat Detail'"><Eye class="w-4 h-4" /></Button>
                                </Link>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>