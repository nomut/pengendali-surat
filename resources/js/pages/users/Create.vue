<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import UserForm from '@/components/users/UserForm.vue';

const props = defineProps({
    roles: Array, // Daftar peran
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Pengguna', route: route('users.index') },
    { label: 'Tambah Baru' }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Pengguna" />

        <div class="max-w-2xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">
                        Form Tambah Pengguna
                    </h3>
                    <p class="text-sm text-muted-color mt-1 font-normal">
                        Isi detail di bawah ini untuk membuat akun pengguna baru.
                    </p>
                </template>
                <template #content>
                    <UserForm :roles="props.roles" />
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
