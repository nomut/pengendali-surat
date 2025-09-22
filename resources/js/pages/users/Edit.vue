<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

// Impor komponen PrimeVue
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Select from 'primevue/select';
import Message from 'primevue/message';
import { useToast } from "primevue/usetoast";

const props = defineProps({
    user: Object, // Menerima data user yang akan diedit
    roles: Object, // Menerima data user yang akan diedit
});

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Users', route: route('users.index') },
    { label: 'Edit' }
];

// Menggunakan useForm dan mengisinya dengan data dari props
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role_id: props.user.role_id,
});

const submit = () => {
    // Menggunakan method PUT untuk update
    form.put(route('users.update', props.user.id), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Data pengguna telah diperbarui', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Edit User: ${user.name}`" />

        <div class="max-w-2xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Form Edit Pengguna</h3>
                    <p class="text-sm text-muted-color mt-1">Perbarui detail untuk akun <span class="font-medium">{{ user.name }}</span>.</p>
                </template>
                <template #content>
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama</label>
                                <InputText id="name" v-model="form.name" type="text" class="w-full" :class="{ 'p-invalid': form.errors.name }" />
                                <small v-if="form.errors.name" class="p-error">{{ form.errors.name }}</small>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                                <InputText id="email" v-model="form.email" type="email" class="w-full" :class="{ 'p-invalid': form.errors.email }" />
                                <small v-if="form.errors.email" class="p-error">{{ form.errors.email }}</small>
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Role</label>
                                <Select id="role" v-model="form.role_id" :options="roles" optionLabel="name" optionValue="id" placeholder="Pilih Role" class="w-full" :class="{ 'p-invalid': form.errors.role }" />
                                <small v-if="form.errors.role" class="p-error">{{ form.errors.role }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-8">
                            <Link :href="route('users.index')">
                                <Button label="Batal" severity="secondary" outlined />
                            </Link>
                            <Button type="submit" label="Simpan Perubahan" :loading="form.processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>