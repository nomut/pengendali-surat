<script setup>
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

// Impor komponen PrimeVue & Ikon
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import { Plus, Pencil, Trash2, Eye, Users2, Users } from 'lucide-vue-next';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    meetings: Object, // Menerima data rapat dari controller
    auth: Object
});

const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Rapat' }
];

const filters = ref({
    global: { value: null, matchMode: 'contains' },
});

// --- Fungsi Aksi untuk Rapat ---
const viewMeeting = (meeting) => {
    router.get(route('meetings.show', meeting.id));
};

const editMeeting = (meeting) => {
    router.get(route('meetings.edit', meeting.id));
};

const deleteMeeting = (meeting) => {
    confirm.require({
        message: `Apakah Anda yakin ingin menghapus rapat "${meeting.title}"?`,
        header: 'Konfirmasi Hapus',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Batal',
        acceptLabel: 'Hapus',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('meetings.destroy', meeting.id), {
                preserveScroll: true,
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Data rapat telah dihapus', life: 3000 });
                },
                onError: () => {
                    toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal menghapus data rapat', life: 3000 });
                }
            });
        },
    });
};

// Helper untuk format tanggal dan waktu
const formatDate = (value) => {
    if (!value) return '';
    return new Date(value).toLocaleString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric',
        hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta'
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Daftar Rapat" />

        <Card>
            <template #content>

                <DataTable 
                    :value="meetings.data" 
                    paginator :rows="10"
                    v-model:filters="filters"
                    stripedRows
                    tableStyle="min-width: 60rem"
                >
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h3 class="m-0 text-lg font-semibold">Daftar Rapat</h3>
                            <div>
                                <Link :href="route('meetings.create')" class="mr-4" v-if="props.auth.permissions.includes('rapat-index')">
                                    <Button label="Tambah Rapat" severity="success">
                                        <template #icon>
                                            <Plus class="w-4 h-4 mr-2" />
                                        </template>
                                    </Button>
                                </Link>

                                <Link :href="route('persons.index')" v-if="props.auth.permissions.includes('peserta-rapat-index')">
                                    <Button label="Peserta" severity="primary">
                                        <template #icon>
                                            <Users class="w-4 h-4 mr-2" />
                                        </template>
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </template>
                    <template #empty> Belum ada data rapat. </template>

                    <Column field="title" header="Judul Rapat" sortable />
                    <Column field="location" header="Lokasi" sortable />
                    <Column field="starts_at" header="Waktu Mulai" sortable>
                        <template #body="{ data }">
                            {{ formatDate(data.starts_at) }}
                        </template>
                    </Column>
                    <Column header="Aksi" style="width: 12rem">
                        <template #body="{ data }">
                            <div class="flex space-x-2">
                                <Button class="p-button-rounded p-button-secondary" @click="viewMeeting(data)" v-if="props.auth.permissions.includes('rapat-index')">
                                    <Eye class="w-4 h-4" />
                                </Button>
                                <Button class="p-button-rounded p-button-info" @click="editMeeting(data)" v-if="props.auth.permissions.includes('rapat-update')">
                                    <Pencil class="w-4 h-4" />
                                </Button>
                                <Button class="p-button-rounded p-button-danger" @click="deleteMeeting(data)" v-if="props.auth.permissions.includes('rapat-delete')">
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