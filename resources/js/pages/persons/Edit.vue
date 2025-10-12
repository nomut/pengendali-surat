<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { useToast } from "primevue/usetoast";

const props = defineProps({
    person: Object,
});

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Peserta', route: route('persons.index') },
    { label: 'Edit Peserta' }
];

const form = useForm({
    name: props.person.name,
    email: props.person.email,
    office: props.person.office,
    position: props.person.position,
});

const submit = () => {
    form.put(route('persons.update', props.person.id), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Data peserta telah diperbarui', life: 3000 });
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Edit Peserta: ${form.name}`" />
        <div class="max-w-xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Form Edit Peserta</h3>
                </template>
                <template #content>
                    <form @submit.prevent="submit">
                        <div class="flex flex-col gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium mb-1">Nama Lengkap</label>
                                <InputText id="name" v-model="form.name" class="w-full" :class="{ 'p-invalid': form.errors.name }" />
                                <small v-if="form.errors.name" class="p-error">{{ form.errors.name }}</small>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                                <InputText id="email" v-model="form.email" class="w-full" :class="{ 'p-invalid': form.errors.email }" />
                                <small v-if="form.errors.email" class="p-error">{{ form.errors.email }}</small>
                            </div>
                            <div>
                                <label for="office" class="block text-sm font-medium mb-1">Instansi</label>
                                <InputText id="office" v-model="form.office" class="w-full" :class="{ 'p-invalid': form.errors.office }" />
                                <small v-if="form.errors.office" class="p-error">{{ form.errors.office }}</small>
                            </div>
                            <div>
                                <label for="position" class="block text-sm font-medium mb-1">Jabatan</label>
                                <InputText id="position" v-model="form.position" class="w-full" :class="{ 'p-invalid': form.errors.position }" />
                                <small v-if="form.errors.position" class="p-error">{{ form.errors.position }}</small>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2 mt-8">
                            <Link :href="route('persons.index')">
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