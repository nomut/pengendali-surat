<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { useToast } from "primevue/usetoast";

const props = defineProps({
    pages: Array,
    auth: Object,
});

const toast = useToast();
const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'CMS Halaman' }
];

const formatDate = (value) => {
    if (!value) return '-';
    return new Date(value).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="CMS - Kelola Halaman" />

        <Card>
            <template #content>
                <DataTable :value="pages" stripedRows tableStyle="min-width: 20rem">
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h3 class="m-0 text-lg font-semibold">Daftar Halaman</h3>
                        </div>
                    </template>
                    <template #empty>Tidak ada halaman.</template>

                    <Column field="title" header="Judul Halaman" sortable></Column>
                    <Column field="slug" header="Slug" sortable></Column>
                    <Column field="updated_at" header="Terakhir Diubah" sortable>
                        <template #body="{ data }">{{ formatDate(data.updated_at) }}</template>
                    </Column>
                    <Column header="Aksi" :exportable="false" style="width: 100px">
                        <template #body="{ data }">
                            <Link :href="route('cms.edit', data.id)">
                                <Button class="p-button-rounded p-button-info" v-tooltip.top="'Edit Halaman'">
                                    <Pencil class="w-4 h-4" />
                                </Button>
                            </Link>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </AppLayout>
</template>
