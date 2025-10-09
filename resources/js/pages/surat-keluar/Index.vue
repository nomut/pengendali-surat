<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import throttle from 'lodash/throttle';

// Impor komponen
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Tag from 'primevue/tag';
import Calendar from 'primevue/datepicker';
import { Pencil, Trash2, Eye, FileBadge } from 'lucide-vue-next';
import { FilterMatchMode } from '@primevue/core/api';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    suratKeluar: Object, // Prop diganti
    filters: Object,
});

const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Keluar' }
];

const dtFilters = ref({
    'nomor_surat': { value: props.filters?.nomor_surat || null, matchMode: FilterMatchMode.CONTAINS },
    'tujuan': { value: props.filters?.tujuan || null, matchMode: FilterMatchMode.CONTAINS },
    'perihal': { value: props.filters?.perihal || null, matchMode: FilterMatchMode.CONTAINS },
    'tanggal_surat': { value: props.filters?.tanggal_surat || null, matchMode: FilterMatchMode.DATE_IS },
    'tags': { value: props.filters?.tags || null, matchMode: FilterMatchMode.CONTAINS },
});

const onFilter = throttle((event) => {
    const backendFilters = {};
    for (const key in event.filters) {
        if (event.filters[key].value) {
            backendFilters[key] = event.filters[key].value;
        }
    }
    router.get(route('surat-keluar.index'), backendFilters, {
        preserveState: true,
        replace: true,
    });
}, 500);

const onSort = (event) => {
    const queryParams = { ...props.filters, sortField: event.sortField, sortOrder: event.sortOrder };
    router.get(route('surat-keluar.index'), queryParams, { preserveState: true, replace: true });
};

const formatDate = (value) => new Date(value).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
const editSurat = (surat) => router.get(route('surat-keluar.edit', surat.id));
const deleteSurat = (surat) => {
    confirm.require({
        message: `Hapus surat dengan perihal "${surat.perihal}"?`,
        header: 'Konfirmasi Hapus',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('surat-keluar.destroy', surat.id), {
                preserveScroll: true,
                onSuccess: () => toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Surat keluar telah dihapus', life: 3000 }),
            });
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Daftar Surat Keluar" />
        <Card>
            <template #content>
                <DataTable 
                    :value="suratKeluar.data" 
                    paginator :rows="10" stripedRows lazy
                    :totalRecords="suratKeluar.total"
                    v-model:filters="dtFilters"      
                    filterDisplay="menu"              
                    @filter="onFilter"
                    removableSort  
                    :sortField="filters.sortField"   
                    :sortOrder="filters.sortOrder"   
                    @sort="onSort"
                >
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h3 class="m-0 text-lg font-semibold">Daftar Surat Keluar</h3>
                             <Link :href="route('surat-keluar.create')">
                                <Button label="Tambah Surat" severity="success" icon="pi pi-plus" />
                            </Link>
                        </div>
                    </template>
                    <template #empty> Tidak ada data yang cocok. </template>

                    <Column field="nomor_surat" header="Nomor Surat" sortable :show-filter-match-modes="false">
                        <template #filter="{ filterModel }"><InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Cari nomor..."/></template>
                    </Column>

                    <Column field="tujuan" header="Tujuan" sortable :show-filter-match-modes="false">
                        <template #filter="{ filterModel }"><InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Cari tujuan..."/></template>
                    </Column>

                    <Column field="perihal" header="Perihal" sortable :show-filter-match-modes="false">
                        <template #filter="{ filterModel }"><InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Cari perihal..."/></template>
                    </Column>
                    
                    <Column field="tanggal_surat" header="Tanggal Surat" sortable :show-filter-match-modes="false">
                         <template #body="{ data }">{{ formatDate(data.tanggal_surat) }}</template>
                         <template #filter="{ filterModel }"><Calendar v-model="filterModel.value" dateFormat="yy-mm-dd" placeholder="YYYY-MM-DD" class="p-column-filter" /></template>
                    </Column>

                     <Column header="Lampiran" style="width: 10%">
                        <template #body="{ data }">
                            <div v-if="data.files_count > 0" class="flex items-center gap-2 text-slate-600">
                                <FileBadge class="w-4 h-4" />
                                <Tag :value="data.files_count" severity="secondary" rounded />
                            </div>
                            <span v-else class="text-slate-400">-</span>
                        </template>
                    </Column>
                    
                    <Column header="Aksi" :exportable="false">
                         <template #body="{ data }">
                            <div class="flex space-x-2">
                                <Button class="p-button-rounded p-button-secondary" @click="router.visit(route('surat-keluar.show', data.id))" v-tooltip.top="'Lihat Detail'"><Eye class="w-4 h-4" /></Button>
                                <Button class="p-button-rounded p-button-info" @click="editSurat(data)" v-tooltip.top="'Edit Surat'"><Pencil class="w-4 h-4" /></Button>
                                <Button class="p-button-rounded p-button-danger" @click="deleteSurat(data)" v-tooltip.top="'Hapus Surat'"><Trash2 class="w-4 h-4" /></Button>
                            </div>
                         </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AppLayout>
</template>