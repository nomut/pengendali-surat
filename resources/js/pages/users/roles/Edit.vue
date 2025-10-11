<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

// Impor komponen PrimeVue
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Checkbox from 'primevue/checkbox'; // Pastikan Checkbox diimpor
import { useToast } from "primevue/usetoast";
import { computed } from 'vue';

const toast = useToast();
const props = defineProps({
    role: Object,         // Data peran yang akan diedit
    permissions: Object,  // Daftar semua permission yang tersedia
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'User Roles', route: route('users.roles.index') },
    { label: 'Edit Peran' }
];

// Mengisi form dengan data dari props
const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions.map(p => p.name), // Ambil nama permission yang sudah dimiliki peran
});

// Logika pengelompokan permission (sama seperti di Create.vue)
const groupedPermissions = computed(() => {
    const groups = {};

    for (const key in props.permissions) {
        const splitKey = key.split('-');
        let moduleKey = splitKey.slice(0, splitKey.length - 1).join(' ');
        if (splitKey.length === 1) {
            moduleKey = key;
        }

        if (!groups[moduleKey]) {
            groups[moduleKey] = [];
        }

        let label = splitKey.slice(-1).join(' ');
        if (label === 'index') label = 'Lihat';
        if (label === 'create') label = 'Buat';
        if (label === 'update') label = 'Ubah';
        if (label === 'delete') label = 'Hapus';

        groups[moduleKey].push({ key: key, label: label });
    }

    return groups;
});


const submit = () => {
    // Menggunakan method PUT untuk update
    form.put(route('users.roles.update', props.role.id), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Peran telah diperbarui', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Edit Peran: ${form.name}`" />

        <div class="max-w-xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Edit Peran</h3>
                </template>
                <template #content>
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama</label>
                                <InputText id="name" v-model="form.name" type="text" class="w-full" :class="{ 'p-invalid': form.errors.name }" />
                                <small v-if="form.errors.name" class="p-error">{{ form.errors.name }}</small>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                             <h4 class="text-md font-semibold text-slate-800 dark:text-slate-200 mb-4">Hak Akses</h4>
                             <div class="space-y-6">
                                <div v-for="(group, module) in groupedPermissions" :key="module" class="p-4 border border-slate-300 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                                    <p class="font-semibold capitalize mb-3">{{ module }}</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                        <div v-for="permission in group" class="flex items-center">
                                            <Checkbox v-model="form.permissions" :inputId="permission.key" :value="permission.key" />
                                            <label :for="permission.key" class="ml-2 text-sm">{{ permission.label }}</label>
                                        </div>
                                    </div>
                                </div>
                             </div>
                             <small v-if="form.errors.permissions" class="p-error mt-2">{{ form.errors.permissions }}</small>
                        </div>

                        <div class="flex justify-end space-x-2 mt-8">
                            <Link :href="route('users.roles.index')">
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