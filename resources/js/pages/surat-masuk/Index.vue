<script setup>
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

// Impor komponen PrimeVue
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import Tag from 'primevue/tag';
import { Plus, Pencil, Trash2, Eye } from 'lucide-vue-next';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    suratMasuk: Object,
});

const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Masuk' }
];

const filters = ref({
    global: { value: null, matchMode: 'contains' },
});

// --- Fungsi Aksi untuk Surat Masuk ---
const viewSurat = (surat) => {
    // Arahkan ke halaman detail menggunakan Inertia router
    router.visit(route('surat-masuk.show', surat.id));
};

const editSurat = (surat) => {
    router.get(route('surat-masuk.edit', surat.id));
};

const deleteSurat = (surat) => {
    confirm.require({
        message: `Apakah Anda yakin ingin menghapus surat dengan perihal "${surat.perihal}"?`,
        header: 'Konfirmasi Hapus',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Batal',
        acceptLabel: 'Hapus',
        rejectClass: 'p-button-secondary p-button-outlined',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('surat-masuk.destroy', surat.id), {
                preserveScroll: true, // Agar halaman tidak scroll ke atas setelah delete
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Surat masuk telah dihapus', life: 3000 });
                },
                onError: () => {
                    toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal menghapus surat masuk', life: 3000 });
                }
            });
        },
    });
};

const formatDate = (value) => {
    return new Date(value).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric'
    });
};

const getDisposisiSeverity = (status) => {
    if (status === 'Sudah Didisposisi') return 'success';
    if (status === 'Belum Didisposisi') return 'warning';
    return 'info';
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Daftar Surat Masuk" />

        <Card>
            <template #content>
                <Toolbar class="mb-4">
                    <template #start>
                        <Link :href="route('surat-masuk.create')">
                            <Button label="Tambah Surat" severity="success">
                                <template #icon>
                                    <Plus class="w-4 h-4 mr-2" />
                                </template>
                            </Button>
                        </Link>
                    </template>
                    <template #end>
                        <span class="relative">
                            <i class="pi pi-search absolute top-2/4 -mt-2 left-3" />
                            <InputText v-model="filters.global.value" placeholder="Cari surat..." class="pl-10" />
                        </span>
                    </template>
                </Toolbar>

                <DataTable 
                    :value="suratMasuk.data" 
                    paginator :rows="10"
                    v-model:filters="filters"
                    stripedRows
                    tableStyle="min-width: 60rem"
                >
                    <template #header>
                        <h3 class="m-0 text-lg font-semibold">Daftar Surat Masuk</h3>
                    </template>
                    <template #empty> Belum ada data surat masuk. </template>

                    <Column field="nomor_surat" header="Nomor Surat" sortable />
                    <Column field="pengirim" header="Pengirim" sortable />
                    <Column field="perihal" header="Perihal" sortable />
                    <Column field="tanggal_diterima" header="Tanggal Diterima" sortable>
                        <template #body="{ data }">
                            {{ formatDate(data.tanggal_diterima) }}
                        </template>
                    </Column>
                    <Column field="status_disposisi" header="Status Disposisi" sortable>
                        <template #body="{ data }">
                            <Tag :value="data.status_disposisi" :severity="getDisposisiSeverity(data.status_disposisi)" />
                        </template>
                    </Column>

                    <Column header="Aksi" style="width: 12rem">
                        <template #body="{ data }">
                            <div class="flex space-x-2">
                                <Button class="p-button-rounded p-button-secondary" @click="viewSurat(data)">
                                    <Eye class="w-4 h-4" />
                                </Button>
                                <Button class="p-button-rounded p-button-info" @click="editSurat(data)">
                                    <Pencil class="w-4 h-4" />
                                </Button>
                                <Button class="p-button-rounded p-button-danger" @click="deleteSurat(data)">
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