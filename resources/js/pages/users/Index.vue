<script setup>
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';

// Impor komponen PrimeVue
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import Tag from 'primevue/tag';
// Impor ikon dari Lucide
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    users: Object,
});
const user = usePage().props.auth.user;
const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Users' }
];

const filters = ref({
    global: { value: null, matchMode: 'contains' },
});

const editUser = (user) => {
    return router.visit(route('users.edit', user));
};

const deleteUser = (user) => {
    const confirmation = confirm.require({
        message: `Apakah Anda yakin ingin menghapus ${user.name}?`,
        header: 'Konfirmasi Hapus',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Batal',
        acceptLabel: 'Hapus',
        rejectClass: 'p-button-secondary p-button-outlined',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('users.destroy', user));

            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Pengguna dihapus (simulasi)', life: 3000 });
        },
    });
    console.log(confirmation);
};

const formatDate = (value) => {
    return new Date(value).toLocaleString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric'
    });
};

const getRoleSeverity = (role) => (role === 'Administrator' ? 'danger' : 'info');
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="User List" />

        <Card>
            <template #content>
                <Toolbar class="mb-4">
                    <!-- 
                    <template #start>
                        <Link :href="route('users.create')">
                            <Button label="Tambah Pengguna" severity="success">
                                <template #icon>
                                    <Plus class="w-4 h-4 mr-2" />
                                </template>
                            </Button>
                        </Link>
                    </template> 
                    -->
                    <template #end>
                        <span class="relative">
                            <i class="pi pi-search absolute top-2/4 -mt-2 left-3" />
                            <InputText v-model="filters.global.value" placeholder="Cari..." class="pl-10" />
                        </span>
                    </template>
                </Toolbar>

                <DataTable
                    :value="users.data"
                    paginator :rows="10"
                    v-model:filters="filters"
                    stripedRows
                >
                    <template #header>
                        <h3 class="m-0 text-lg font-semibold">Daftar Pengguna</h3>
                    </template>
                    <template #empty> Pengguna tidak ditemukan. </template>

                    <Column field="name" header="Nama" sortable />
                    <Column field="email" header="Email" sortable />
                    <Column field="role" header="Role" sortable>
                        <template #body="{ data }">
                            <Tag :value="data.role_name" :severity="getRoleSeverity(data.role_name)" />
                        </template>
                    </Column>
                    <Column field="created_at" header="Bergabung" sortable>
                        <template #body="{ data }">
                            {{ formatDate(data.created_at) }}
                        </template>
                    </Column>
                    <Column header="Aksi" style="width: 10rem">
                        <template #body="{ data }">
                            <div class="flex space-x-2">
                                <template v-if="data.id != user.id">
                                    <Button class="p-button-rounded p-button-info" @click="editUser(data)">
                                        <Pencil class="w-4 h-4" />
                                    </Button>

                                    <Button class="p-button-rounded p-button-danger" @click="deleteUser(data)">
                                        <Trash2 class="w-4 h-4" />
                                    </Button>
                                </template>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AppLayout>
</template>