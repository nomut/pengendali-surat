<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import RoleForm from '@/components/users/RoleForm.vue';

const props = defineProps({
    permissions: Object, // Daftar semua hak akses yang tersedia
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Pengguna', route: route('users.index') },
    { label: 'Peran', route: route('users.roles.index') },
    { label: 'Tambah Baru' }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Peran" />

        <div class="max-w-2xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">
                        Form Tambah Peran
                    </h3>
                    <p class="text-sm text-muted-color mt-1 font-normal">
                        Tentukan nama peran dan hak akses yang dimilikinya.
                    </p>
                </template>
                <template #content>
                    <RoleForm :permissions="props.permissions" />
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
