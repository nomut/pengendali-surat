<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import RoleForm from '@/components/users/RoleForm.vue';

const props = defineProps({
    role: Object,         // Data peran yang akan diedit
    permissions: Object,  // Daftar semua hak akses yang tersedia
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Pengguna', route: route('users.index') },
    { label: 'Peran', route: route('users.roles.index') },
    { label: 'Edit Peran' }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Edit Peran: ${props.role.name}`" />

        <div class="max-w-2xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">
                        Form Edit Peran
                    </h3>
                    <p class="text-sm text-muted-color mt-1 font-normal">
                        Perbarui nama peran dan hak aksesnya.
                    </p>
                </template>
                <template #content>
                    <RoleForm
                        :role="props.role"
                        :permissions="props.permissions"
                    />
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
