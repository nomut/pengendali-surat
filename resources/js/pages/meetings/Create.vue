<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios'; 

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import Dialog from 'primevue/dialog';
import { useToast } from "primevue/usetoast";
import { Plus } from 'lucide-vue-next';

const props = defineProps({
    persons: Array,
});

const toast = useToast();

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Rapat', route: route('meetings.index') },
    { label: 'Tambah Baru' }
];

const form = useForm({
    title: '',
    starts_at: null,
    ends_at: null,
    location: '',
    minutes: '',
    pesertas: [],
});

const submitMeeting = () => {
    form.post(route('meetings.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Data rapat baru telah disimpan', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        }
    });
};

const isPersonDialogVisible = ref(false);
const allPersons = ref([...props.persons]);

const personForm = useForm({
    name: '',
    email: '',
    office: '',
    position: '',
});

const openPersonDialog = () => {
    personForm.reset();
    personForm.clearErrors();
    isPersonDialogVisible.value = true;
};

const submitNewPerson = () => {
    axios.post(route('persons.store'), personForm.data())
        .then(response => {
            const newPerson = response.data;
            allPersons.value.push(newPerson); 
            form.pesertas.push(newPerson.id);
            
            toast.add({ severity: 'success', summary: 'Berhasil', detail: 'Peserta baru telah ditambahkan', life: 3000 });
            isPersonDialogVisible.value = false;
        })
        .catch(error => {
            if (error.response.status === 422) {
                personForm.errors = error.response.data.errors;
            }
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal menambahkan peserta', life: 3000 });
        });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Tambah Rapat Baru" />

        <div class="max-w-3xl mx-auto">
            <Card>
                <template #title>
                    <h3 class="text-lg font-semibold">Form Tambah Rapat</h3>
                    <p class="text-sm text-muted-color mt-1">Isi detail di bawah ini untuk menjadwalkan rapat baru.</p>
                </template>
                <template #content>
                    <form @submit.prevent="submitMeeting">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul Rapat <span class="text-red-500">*</span></label>
                                <InputText id="title" v-model="form.title" class="w-full" :class="{ 'p-invalid': form.errors.title }" />
                                <small v-if="form.errors.title" class="p-error">{{ form.errors.title }}</small>
                            </div>

                            <div>
                                <label for="starts_at" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Waktu Mulai <span class="text-red-500">*</span></label>
                                <Calendar id="starts_at" v-model="form.starts_at" class="w-full" showTime hourFormat="24" :class="{ 'p-invalid': form.errors.starts_at }" fluid />
                                <small v-if="form.errors.starts_at" class="p-error">{{ form.errors.starts_at }}</small>
                            </div>
                            
                            <div>
                                <label for="ends_at" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Waktu Selesai</label>
                                <Calendar id="ends_at" v-model="form.ends_at" class="w-full" showTime hourFormat="24" :class="{ 'p-invalid': form.errors.ends_at }" fluid />
                                <small v-if="form.errors.ends_at" class="p-error">{{ form.errors.ends_at }}</small>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="location" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Lokasi <span class="text-red-500">*</span></label>
                                <InputText id="location" v-model="form.location" class="w-full" :class="{ 'p-invalid': form.errors.location }" />
                                <small v-if="form.errors.location" class="p-error">{{ form.errors.location }}</small>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="pesertas" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Peserta Rapat <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-2">
                                    <MultiSelect id="pesertas" v-model="form.pesertas" :options="allPersons" filter optionLabel="name" optionValue="id" placeholder="Pilih Peserta" class="w-full" :class="{ 'p-invalid': form.errors.pesertas }">
                                        <template #option="slotProps">
                                            <div class="flex flex-col">
                                                <span>{{ slotProps.option.name }}</span>
                                                <small class="text-muted-color">{{ slotProps.option.instansi || slotProps.option.email }}</small>
                                            </div>
                                        </template>
                                    </MultiSelect>
                                    <Button type="button" @click="openPersonDialog" class="p-button-success p-button-outlined flex-shrink-0" v-tooltip.top="'Tambah Peserta Baru'">
                                        <Plus class="w-5 h-5" />
                                    </Button>
                                </div>
                                <small v-if="form.errors.pesertas" class="p-error">{{ form.errors.pesertas }}</small>
                            </div>

                            <div class="md:col-span-2">
                                <label for="minutes" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Notulensi (Opsional)</label>
                                <Textarea id="minutes" v-model="form.minutes" rows="5" class="w-full" :class="{ 'p-invalid': form.errors.minutes }" />
                                <small v-if="form.errors.minutes" class="p-error">{{ form.errors.minutes }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 mt-8">
                            <Link :href="route('meetings.index')">
                                <Button type="button" label="Batal" severity="secondary" outlined />
                            </Link>
                            <Button type="submit" label="Simpan Rapat" :loading="form.processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>

        <Dialog v-model:visible="isPersonDialogVisible" modal header="Tambah Peserta Baru" :style="{ width: '30rem' }">
            <form @submit.prevent="submitNewPerson" id="personForm">
                <div class="p-fluid flex flex-col gap-4">
                    <div>
                        <label for="person-name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <InputText id="person-name" v-model="personForm.name" :class="{ 'p-invalid': personForm.errors.name }" fluid />
                        <small v-if="personForm.errors.name" class="p-error">{{ personForm.errors.name }}</small>
                    </div>
                     <div>
                        <label for="person-email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                        <InputText id="person-email" v-model="personForm.email" :class="{ 'p-invalid': personForm.errors.email }" fluid />
                        <small v-if="personForm.errors.email" class="p-error">{{ personForm.errors.email }}</small>
                    </div>
                     <div>
                        <label for="person-office" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Instansi</label>
                        <InputText id="person-office" v-model="personForm.office" :class="{ 'p-invalid': personForm.errors.office }" fluid />
                        <small v-if="personForm.errors.office" class="p-error">{{ personForm.errors.office }}</small>
                    </div>
                     <div>
                        <label for="person-position" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jabatan</label>
                        <InputText id="person-position" v-model="personForm.position" :class="{ 'p-invalid': personForm.errors.position }" fluid />
                        <small v-if="personForm.errors.position" class="p-error">{{ personForm.errors.position }}</small>
                    </div>
                </div>
            </form>
            <template #footer>
                <Button type="button" label="Batal" severity="secondary" @click="isPersonDialogVisible = false"></Button>
                <Button type="submit" form="personForm" label="Simpan Peserta" :loading="personForm.processing"></Button>
            </template>
        </Dialog>
    </AppLayout>
</template>