<script setup>
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    persons: Object,
    auth: Object
});

const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Rapat', route: route('meetings.index') },
    { label: 'Peserta' }
];

const filters = ref({
    global: { value: null, matchMode: 'contains' },
});

const editPerson = (person) => {
    router.get(route('persons.edit', person.id));
};

const deletePerson = (person) => {
    confirm.require({
        message: `Apakah Anda yakin ingin menghapus ${person.name}?`,
        header: 'Konfirmasi Hapus',
        icon: 'pi pi-info-circle',
        acceptLabel: 'Hapus',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('persons.destroy', person.id), {
                preserveScroll: true,
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Data peserta telah dihapus', life: 3000 });
                },
            });
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Daftar Peserta" />
        <Card>
            <template #content>

                <DataTable :value="persons.data" paginator :rows="10" v-model:filters="filters" stripedRows>
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h3 class="m-0 text-lg font-semibold">Daftar Peserta</h3>
                        </div>
                    </template>
                    <template #empty> Belum ada data peserta. </template>
                    <Column field="name" header="Nama" sortable />
                    <Column field="email" header="Email" sortable />
                    <Column field="office" header="Instansi" sortable />
                    <Column field="position" header="Jabatan" sortable />
                    <Column header="Aksi" style="width: 10rem">
                        <template #body="{ data }">
                            <div class="flex space-x-2">
                                <Button class="p-button-rounded p-button-info" @click="editPerson(data)" v-if="props.auth.permissions.includes('peserta-rapat-index')">
                                    <Pencil class="w-4 h-4" />
                                </Button>
                                <Button class="p-button-rounded p-button-danger" @click="deletePerson(data)" v-if="props.auth.permissions.includes('peserta-rapat-index')">
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