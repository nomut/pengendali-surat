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
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

// Halaman ini menerima prop 'roles' dari controller
const props = defineProps({
    roles: Object,
});

const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Users', route: route('users.index') },
    { label: 'Roles' }
];

const filters = ref({
    global: { value: null, matchMode: 'contains' },
});

// --- Fungsi Aksi untuk Roles ---
const editRole = (role) => {
    router.get(route('users.roles.edit', role.id));
};

const deleteRole = (role) => {
    confirm.require({
        message: `Apakah Anda yakin ingin menghapus Peran "${role.name}"?`,
        header: 'Konfirmasi Hapus',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Batal',
        acceptLabel: 'Hapus',
        rejectClass: 'p-button-secondary p-button-outlined',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('users.roles.destroy', role.id), {
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Peran telah dihapus', life: 3000 });
                },
                onError: () => {
                    toast.add({ severity: 'error', summary: 'Gagal', detail: 'Terjadi kesalahan saat menghapus peran', life: 3000 });
                }
            });
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Daftar Peran" />

        <Card>
            <template #content>

                <DataTable 
                    :value="roles.data" 
                    paginator :rows="10"
                    v-model:filters="filters"
                    stripedRows
                    tableStyle="min-width: 40rem"
                >
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h3 class="m-0 text-lg font-semibold">Daftar Peran</h3>
                            
                            <Link :href="route('users.roles.create')">
                                <Button label="Tambah Peran" severity="success">
                                    <template #icon>
                                        <Plus class="w-4 h-4 mr-2" />
                                    </template>
                                </Button>
                            </Link>
                        </div>
                    </template>
                    <template #empty> Belum ada data Peran. </template>

                    <Column field="name" header="Nama Peran" sortable />
                    <Column field="users_count" header="Jumlah Pengguna" sortable />

                    <Column header="Aksi" style="width: 10rem">
                        <template #body="{ data }">
                            <div class="flex space-x-2">
                                <Button class="p-button-rounded p-button-info" @click="editRole(data)" :disabled="data.id === 1" v-tooltip.top="data.id === 1 ? 'Peran ini tidak dapat diedit' : ''">
                                    <Pencil class="w-4 h-4" />
                                </Button>

                                <Button class="p-button-rounded p-button-danger" @click="deleteRole(data)" :disabled="data.users_count > 0" v-tooltip.top="data.users_count > 0 ? 'Peran ini memiliki pengguna terkait dan tidak dapat dihapus' : ''">
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