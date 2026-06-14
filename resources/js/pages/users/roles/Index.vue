<script setup>
import { ref, computed, useTemplateRef } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Menu from '@/components/primevue/menu/Menu.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { throttle } from 'lodash-es';

// Impor komponen PrimeVue & Ikon
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Tag from 'primevue/tag';
import { Plus, Pencil, Trash2, EllipsisVertical, ArrowLeft } from 'lucide-vue-next';
import { FilterMatchMode } from '@primevue/core/api';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    roles: Object,   // Data peran terpaginasi dari controller
    filters: Object, // Filter aktif dari query string
});

const permissions = usePage().props.auth.permissions;
const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Pengguna', route: route('users.index') },
    { label: 'Peran' }
];

// --- Filter per kolom (server-side) ---
const dtFilters = ref({
    'name': { value: props.filters?.name || null, matchMode: FilterMatchMode.CONTAINS },
});

const onFilter = throttle((event) => {
    const backendFilters = {};
    for (const key in event.filters) {
        if (event.filters[key].value) {
            backendFilters[key] = event.filters[key].value;
        }
    }
    router.get(route('users.roles.index'), backendFilters, {
        preserveState: true,
        replace: true,
    });
}, 500);

const cleanParams = (params) => {
    Object.keys(params).forEach(key => {
        if (!params[key]) delete params[key];
    });
    return params;
};

const onPage = (event) => {
    router.get(route('users.roles.index'), cleanParams({
        ...props.filters,
        page: event.page + 1,
        per_page: event.rows,
    }), {
        preserveState: true,
        replace: true,
    });
};

const onSort = (event) => {
    router.get(route('users.roles.index'), cleanParams({
        ...props.filters,
        sortField: event.sortField,
        sortOrder: event.sortOrder,
    }), {
        preserveState: true,
        replace: true,
    });
};

// --- Menu aksi titik tiga per baris ---
const actionMenu = useTemplateRef('action-menu');
const selectedRole = ref(null);
const toggleActionMenu = (event, role) => {
    selectedRole.value = role;
    actionMenu.value.$el.toggle(event);
};

const actionItems = computed(() => {
    const role = selectedRole.value;
    if (!role) return [];

    // Peran masih dapat diubah; peran utama (id 1) atau yang masih dipakai tidak dapat dihapus
    const canEdit = permissions.includes('user-role-update');
    const canDelete = permissions.includes('user-role-delete') && role.id !== 1 && role.users_count === 0;

    return [
        {
            label: 'Edit',
            lucideIcon: Pencil,
            visible: canEdit,
            command: () => router.get(route('users.roles.edit', role.id)),
        },
        { separator: true, visible: canEdit && canDelete },
        {
            label: 'Hapus',
            lucideIcon: Trash2,
            class: 'text-red-600! dark:text-red-400!',
            visible: canDelete,
            command: () => deleteRole(role),
        },
    ];
});

const deleteRole = (role) => {
    confirm.require({
        message: `Apakah Anda yakin ingin menghapus peran "${role.name}"?`,
        header: 'Konfirmasi Hapus',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Batal',
        acceptLabel: 'Hapus',
        rejectClass: 'p-button-secondary p-button-outlined',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('users.roles.destroy', role.id), {
                preserveScroll: true,
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Peran telah dihapus', life: 3000 });
                },
                onError: () => {
                    toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal menghapus peran', life: 3000 });
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
                    v-model:filters="dtFilters"
                    :value="roles.data"
                    lazy
                    paginator
                    :rows="roles.per_page"
                    :rowsPerPageOptions="[10, 25, 50]"
                    :totalRecords="roles.total"
                    :first="(roles.current_page - 1) * roles.per_page"
                    filterDisplay="menu"
                    removableSort
                    :sortField="filters.sortField"
                    :sortOrder="filters.sortOrder"
                    stripedRows
                    size="small"
                    pt:table:class="text-sm"
                    @page="onPage"
                    @sort="onSort"
                    @filter="onFilter"
                >
                    <template #header>
                        <div class="flex justify-between items-center flex-wrap gap-2">
                            <h3 class="m-0 text-lg font-semibold">
                                Daftar Peran
                            </h3>
                            <div class="flex items-center gap-2">
                                <Link :href="route('users.index')">
                                    <Button
                                        label="Pengguna"
                                        severity="secondary"
                                        outlined
                                        size="small"
                                    >
                                        <template #icon>
                                            <ArrowLeft class="size-4" />
                                        </template>
                                    </Button>
                                </Link>
                                <Link
                                    v-if="permissions.includes('user-role-create')"
                                    :href="route('users.roles.create')"
                                >
                                    <Button
                                        label="Tambah Peran"
                                        size="small"
                                    >
                                        <template #icon>
                                            <Plus class="size-4" />
                                        </template>
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </template>
                    <template #empty>
                        Tidak ada data peran yang cocok.
                    </template>

                    <Column
                        field="name"
                        header="Nama Peran"
                        sortable
                        :showFilterMatchModes="false"
                        style="min-width: 14rem"
                    >
                        <template #body="{ data }">
                            <span class="font-medium">{{ data.name }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                class="p-column-filter"
                                placeholder="Cari peran..."
                            />
                        </template>
                    </Column>

                    <Column
                        field="users_count"
                        header="Jumlah Pengguna"
                        sortable
                        style="min-width: 10rem"
                    >
                        <template #body="{ data }">
                            <Tag
                                :value="`${data.users_count} pengguna`"
                                severity="secondary"
                                rounded
                            />
                        </template>
                    </Column>

                    <Column
                        header="Aksi"
                        style="width: 4rem"
                    >
                        <template #body="{ data }">
                            <Button
                                severity="secondary"
                                text
                                rounded
                                aria-label="Aksi"
                                @click="toggleActionMenu($event, data)"
                            >
                                <template #icon>
                                    <EllipsisVertical class="size-5!" />
                                </template>
                            </Button>
                        </template>
                    </Column>
                </DataTable>

                <Menu
                    ref="action-menu"
                    :model="actionItems"
                    popup
                />
            </template>
        </Card>
    </AppLayout>
</template>
