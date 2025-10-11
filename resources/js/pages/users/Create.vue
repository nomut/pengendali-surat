<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Impor komponen PrimeVue
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Dropdown from 'primevue/dropdown';
import { useToast } from "primevue/usetoast";

const props = defineProps({
    roles: Object, // Menerima data role
});

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Users', route: route('users.index') },
    { label: 'Tambah Baru' }
];

// Menggunakan useForm untuk state management & validasi
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_id: null, // Nilai default
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Pengguna baru telah ditambahkan', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Pengguna" />

        <div class="max-w-2xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Tambah Pengguna</h3>
                    <p class="text-sm text-muted-color mt-1">Isi detail di bawah ini untuk membuat akun pengguna baru.</p>
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
                                <label for="role" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Peran</label>
                                <Select id="role" v-model="form.role_id" :options="roles" optionLabel="name" optionValue="id" placeholder="Pilih Peran" class="w-full" :class="{ 'p-invalid': form.errors.role }" />
                                <small v-if="form.errors.role" class="p-error">{{ form.errors.role }}</small>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password</label>
                                <Password id="password" v-model="form.password" class="w-full" :feedback="false" toggleMask :class="{ 'p-invalid': form.errors.password }" fluid/>
                                <small v-if="form.errors.password" class="p-error">{{ form.errors.password }}</small>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Konfirmasi Password</label>
                                <Password id="password_confirmation" v-model="form.password_confirmation" class="w-full" :feedback="false" toggleMask  fluid/>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-8">
                            <Link :href="route('users.index')">
                                <Button label="Batal" severity="secondary" outlined />
                            </Link>
                            <Button type="submit" label="Simpan" :loading="form.processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>