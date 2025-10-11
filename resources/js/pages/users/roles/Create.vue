<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

// Impor komponen PrimeVue
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { useToast } from "primevue/usetoast";
import { computed } from 'vue';

const toast = useToast();
const props = defineProps({
    permissions: Object,
});
const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Pengguna', route: route('users.index') },
    { label: 'Peran', route: route('users.roles.index') },
    { label: 'Tambah Peran' }
];

// Menggunakan useForm untuk state management & validasi
const form = useForm({
    name: '',
    permissions: [],
});

const groupedPermissions = computed(() => {
    const groups = {};

    for (const key in props.permissions) {
        
        const splitKey = key.split('-');
        let moduleKey = splitKey.slice(0, splitKey.length > 1 ? splitKey.length - 1 : 0).join(' ');

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
    form.post(route('users.roles.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Peran baru telah ditambahkan', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Peran Baru" />

        <div class="max-w-xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Tambah Peran</h3>
                </template>
                <template #content>
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama</label>
                                <InputText id="name" v-model="form.name" type="text" class="w-full" :class="{ 'p-invalid': form.errors.name }" placeholder="Contoh: Super Admin" />
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
                            <Button type="submit" label="Simpan" :loading="form.processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>