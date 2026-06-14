<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import UserForm from '@/components/users/UserForm.vue';

const props = defineProps({
    user: Object,  // Data pengguna yang akan diedit
    roles: Array,  // Daftar peran
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Pengguna', route: route('users.index') },
    { label: 'Edit Pengguna' }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Edit Pengguna: ${props.user.name}`" />

        <div class="max-w-2xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">
                        Form Edit Pengguna
                    </h3>
                    <p class="text-sm text-muted-color mt-1 font-normal">
                        Perbarui detail untuk akun <span class="font-medium">{{ props.user.name }}</span>.
                    </p>
                </template>
                <template #content>
                    <UserForm
                        :user="props.user"
                        :roles="props.roles"
                    />
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
