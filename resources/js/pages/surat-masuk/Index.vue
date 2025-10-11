<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import throttle from 'lodash/throttle';

// Impor komponen PrimeVue
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
    suratMasuk: Object,
    filters: Object,
    auth: Object,
});

const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Masuk' }
];

// Inisialisasi state filter untuk semua kolom yang relevan
const dtFilters = ref({
    'nomor_surat': { value: props.filters?.nomor_surat || null, matchMode: FilterMatchMode.CONTAINS },
    'pengirim': { value: props.filters?.pengirim || null, matchMode: FilterMatchMode.CONTAINS },
    'perihal': { value: props.filters?.perihal || null, matchMode: FilterMatchMode.CONTAINS },
    'tanggal_diterima': { value: props.filters?.tanggal_diterima || null, matchMode: FilterMatchMode.DATE_IS },
    'tags': { value: props.filters?.tags || null, matchMode: FilterMatchMode.CONTAINS },
});

// Fungsi yang dipicu saat filter diubah
const onFilter = throttle((event) => {
    const backendFilters = {};
    for (const key in event.filters) {
        backendFilters[key] = event.filters[key].value;
    }
    router.get(route('surat-masuk.index'), backendFilters, {
        preserveState: true,
        replace: true,
    });
}, 500);

const onSort = (event) => {
    const queryParams = {
        ...props.filters,
        sortField: event.sortField,
        sortOrder: event.sortOrder,
    };

    Object.keys(queryParams).forEach(key => {
        if (!queryParams[key]) delete queryParams[key];
    });
    
    router.get(route('surat-masuk.index'), queryParams, {
        preserveState: true,
        replace: true,
    });
};

// Fungsi pembantu dan aksi
const formatDate = (value) => new Date(value).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
const editSurat = (surat) => router.get(route('surat-masuk.edit', surat.id));
const deleteSurat = (surat) => {
    confirm.require({
        message: `Hapus surat dengan perihal "${surat.perihal}"?`,
        header: 'Konfirmasi Hapus',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('surat-masuk.destroy', surat.id), {
                preserveScroll: true,
                onSuccess: () => toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Surat masuk telah dihapus', life: 3000 }),
            });
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Daftar Surat Masuk" />
        <Card>
            <template #content>
                <DataTable 
                    :value="suratMasuk.data" 
                    paginator :rows="10" stripedRows lazy
                    :totalRecords="suratMasuk.total"
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
                            <h3 class="m-0 text-lg font-semibold">Daftar Surat Masuk</h3>
                             <Link :href="route('surat-masuk.create')" v-if="props.auth.permissions.includes('surat-masuk-create')">
                                <Button label="Tambah Surat" severity="success" icon="pi pi-plus" />
                            </Link>
                        </div>
                    </template>
                    <template #empty> Tidak ada data yang cocok dengan filter yang diterapkan. </template>

                    <Column field="nomor_surat" header="Nomor Surat" sortable :show-filter-match-modes="false">
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Cari nomor..."/>
                        </template>
                    </Column>

                    <Column field="pengirim" header="Pengirim" sortable :show-filter-match-modes="false">
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Cari pengirim..."/>
                        </template>
                    </Column>

                    <Column field="perihal" header="Perihal" sortable :show-filter-match-modes="false">
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Cari perihal..."/>
                        </template>
                    </Column>
                    
                    <Column field="tanggal_diterima" header="Tanggal Diterima" sortable :show-filter-match-modes="false">
                         <template #body="{ data }">{{ formatDate(data.tanggal_diterima) }}</template>
                         <template #filter="{ filterModel }">
                            <Calendar v-model="filterModel.value" dateFormat="yy-mm-dd" placeholder="YYYY-MM-DD" mask="9999-99-99" class="p-column-filter" />
                        </template>
                    </Column>
                    
                    <Column field="tags" header="Tags" :show-filter-match-modes="false" style="min-width: 12rem">
                        <template #body="{ data }">
                            <div v-if="data.tags.length" class="flex flex-wrap gap-1">
                                <Tag v-for="tag in data.tags" :key="tag.id" :value="tag.name.en" severity="info"></Tag>
                            </div>
                        </template>
                        
                        <template #filter="{ filterModel }">
                             <Chips
                                v-model="filterModel.value"
                                placeholder="Ketik tag, lalu Enter"
                                class="p-column-filter"
                                separator=","
                             />
                        </template>
                    </Column>

                    <Column field="files_count" header="Lampiran">
                        <template #body="{ data }">
                            <div v-if="data.files_count > 0" class="flex items-center gap-2">
                                <FileBadge class="w-4 h-4" />
                                <Tag :value="data.files_count" severity="secondary" rounded />
                            </div>
                            <span v-else class="text-slate-400">-</span>
                        </template>
                    </Column>
                    
                    <Column header="Aksi" :exportable="false">
                         <template #body="{ data }">
                            <div class="flex space-x-2">
                                
                                <Button v-if="props.auth.permissions.includes('surat-masuk-index')" class="p-button-rounded p-button-secondary" @click="router.visit(route('surat-masuk.show', data.id))" v-tooltip.top="'Lihat Detail'">
                                    <Eye class="w-4 h-4" />
                                </Button>
                                <Button v-if="props.auth.permissions.includes('surat-masuk-edit')" class="p-button-rounded p-button-info" @click="editSurat(data)" v-tooltip.top="'Edit Surat'">
                                    <Pencil class="w-4 h-4" />
                                </Button>
                                <Button v-if="props.auth.permissions.includes('surat-masuk-delete')" class="p-button-rounded p-button-danger" @click="deleteSurat(data)" v-tooltip.top="'Hapus Surat'">
                                    <Trash2 class="w-4 h-4" />
                                </Button>
                            </div>
                         </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AppLayout>
</template>