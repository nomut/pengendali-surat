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
import Select from 'primevue/select';
import Tag from 'primevue/tag';
import { Plus, Pencil, Trash2, EllipsisVertical, ShieldUser } from 'lucide-vue-next';
import { FilterMatchMode } from '@primevue/core/api';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    users: Object,  // Data pengguna terpaginasi dari controller
    filters: Object, // Filter aktif dari query string
    roles: Array,   // Daftar nama peran untuk filter
    auth: Object,
});

const currentUser = usePage().props.auth.user;
const confirm = useConfirm();
const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Pengguna' }
];

// --- Filter per kolom (server-side) ---
const dtFilters = ref({
    'name': { value: props.filters?.name || null, matchMode: FilterMatchMode.CONTAINS },
    'email': { value: props.filters?.email || null, matchMode: FilterMatchMode.CONTAINS },
    'role': { value: props.filters?.role || null, matchMode: FilterMatchMode.EQUALS },
});

const onFilter = throttle((event) => {
    const backendFilters = {};
    for (const key in event.filters) {
        if (event.filters[key].value) {
            backendFilters[key] = event.filters[key].value;
        }
    }
    router.get(route('users.index'), backendFilters, {
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
    router.get(route('users.index'), cleanParams({
        ...props.filters,
        page: event.page + 1,
        per_page: event.rows,
    }), {
        preserveState: true,
        replace: true,
    });
};

const onSort = (event) => {
    router.get(route('users.index'), cleanParams({
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
const selectedUser = ref(null);
const toggleActionMenu = (event, user) => {
    selectedUser.value = user;
    actionMenu.value.$el.toggle(event);
};

// Pengguna utama (id 1) dan akun sendiri tidak boleh dihapus
const canDeleteSelected = computed(() => {
    const user = selectedUser.value;
    if (!user) return false;
    return user.id !== 1 && user.id !== currentUser.id;
});

const actionItems = computed(() => [
    {
        label: 'Edit',
        lucideIcon: Pencil,
        visible: props.auth.permissions.includes('user-update'),
        command: () => router.get(route('users.edit', selectedUser.value.id)),
    },
    { separator: true, visible: props.auth.permissions.includes('user-delete') && canDeleteSelected.value },
    {
        label: 'Hapus',
        lucideIcon: Trash2,
        class: 'text-red-600! dark:text-red-400!',
        visible: props.auth.permissions.includes('user-delete') && canDeleteSelected.value,
        command: () => deleteUser(selectedUser.value),
    },
]);

const deleteUser = (user) => {
    confirm.require({
        message: `Apakah Anda yakin ingin menghapus ${user.name}?`,
        header: 'Konfirmasi Hapus',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Batal',
        acceptLabel: 'Hapus',
        rejectClass: 'p-button-secondary p-button-outlined',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(route('users.destroy', user.id), {
                preserveScroll: true,
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Pengguna telah dihapus', life: 3000 });
                },
                onError: () => {
                    toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal menghapus pengguna', life: 3000 });
                }
            });
        },
    });
};

const formatDate = (value) => {
    if (!value) return '-';
    return new Date(value).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric'
    });
};

const getRoleSeverity = (role) => (role === 'Administrator' ? 'danger' : 'info');
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Daftar Pengguna" />

        <Card>
            <template #content>
                <DataTable
                    v-model:filters="dtFilters"
                    :value="users.data"
                    lazy
                    paginator
                    :rows="users.per_page"
                    :rowsPerPageOptions="[10, 25, 50]"
                    :totalRecords="users.total"
                    :first="(users.current_page - 1) * users.per_page"
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
                                Daftar Pengguna
                            </h3>
                            <div class="flex items-center gap-2">
                                <Link
                                    v-if="props.auth.permissions.includes('user-role-index')"
                                    :href="route('users.roles.index')"
                                >
                                    <Button
                                        label="Peran"
                                        severity="secondary"
                                        outlined
                                        size="small"
                                    >
                                        <template #icon>
                                            <ShieldUser class="size-4" />
                                        </template>
                                    </Button>
                                </Link>
                                <Link
                                    v-if="props.auth.permissions.includes('user-create')"
                                    :href="route('users.create')"
                                >
                                    <Button
                                        label="Tambah Pengguna"
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
                        Tidak ada data pengguna yang cocok.
                    </template>

                    <Column
                        field="name"
                        header="Nama"
                        sortable
                        :showFilterMatchModes="false"
                        style="min-width: 12rem"
                    >
                        <template #body="{ data }">
                            <span class="font-medium">{{ data.name }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                class="p-column-filter"
                                placeholder="Cari nama..."
                            />
                        </template>
                    </Column>

                    <Column
                        field="email"
                        header="Email"
                        sortable
                        :showFilterMatchModes="false"
                        style="min-width: 14rem"
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                class="p-column-filter"
                                placeholder="Cari email..."
                            />
                        </template>
                    </Column>

                    <Column
                        field="role"
                        header="Peran"
                        :showFilterMatchModes="false"
                        style="min-width: 10rem"
                    >
                        <template #body="{ data }">
                            <Tag
                                :value="data.role_name"
                                :severity="getRoleSeverity(data.role_name)"
                                rounded
                            />
                        </template>
                        <template #filter="{ filterModel }">
                            <Select
                                v-model="filterModel.value"
                                :options="props.roles"
                                placeholder="Semua peran"
                                show-clear
                                class="p-column-filter"
                            />
                        </template>
                    </Column>

                    <Column
                        field="created_at"
                        header="Dibuat"
                        sortable
                        style="min-width: 9rem"
                    >
                        <template #body="{ data }">
                            {{ formatDate(data.created_at) }}
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
