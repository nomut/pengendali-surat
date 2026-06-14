<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Select from 'primevue/select';
import { useToast } from 'primevue/usetoast';

const props = defineProps({
    user: {
        type: Object,
        default: null, // null = mode tambah, terisi = mode edit
    },
    roles: {
        type: Array,
        default: () => [],
    },
});

const toast = useToast();

const isEdit = computed(() => Boolean(props.user));

const form = useForm({
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    role_id: props.user?.role_id ?? null,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    const options = {
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        },
    };

    if (isEdit.value) {
        form.put(route('users.update', props.user.id), options);
    } else {
        form.post(route('users.store'), options);
    }
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label
                        for="name"
                        class="block text-xs font-medium text-surface-700 dark:text-surface-300 mb-1"
                    >
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <InputText
                        id="name"
                        v-model="form.name"
                        placeholder="Nama lengkap pengguna"
                        :invalid="Boolean(form.errors.name)"
                        size="small"
                        fluid
                    />
                    <small
                        v-if="form.errors.name"
                        class="text-red-500"
                    >{{ form.errors.name }}</small>
                </div>

                <div>
                    <label
                        for="email"
                        class="block text-xs font-medium text-surface-700 dark:text-surface-300 mb-1"
                    >
                        Email <span class="text-red-500">*</span>
                    </label>
                    <InputText
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="nama@email.com"
                        :invalid="Boolean(form.errors.email)"
                        size="small"
                        fluid
                    />
                    <small
                        v-if="form.errors.email"
                        class="text-red-500"
                    >{{ form.errors.email }}</small>
                </div>
            </div>

            <div>
                <label
                    for="role"
                    class="block text-xs font-medium text-surface-700 dark:text-surface-300 mb-1"
                >
                    Peran <span class="text-red-500">*</span>
                </label>
                <Select
                    id="role"
                    v-model="form.role_id"
                    :options="roles"
                    option-label="name"
                    option-value="id"
                    placeholder="Pilih peran"
                    :invalid="Boolean(form.errors.role_id)"
                    size="small"
                    fluid
                />
                <small
                    v-if="form.errors.role_id"
                    class="text-red-500"
                >{{ form.errors.role_id }}</small>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label
                        for="password"
                        class="block text-xs font-medium text-surface-700 dark:text-surface-300 mb-1"
                    >
                        Password
                        <span
                            v-if="!isEdit"
                            class="text-red-500"
                        >*</span>
                        <span
                            v-else
                            class="text-muted-color text-xs"
                        >(kosongkan jika tidak diubah)</span>
                    </label>
                    <Password
                        id="password"
                        v-model="form.password"
                        :feedback="false"
                        toggle-mask
                        :invalid="Boolean(form.errors.password)"
                        size="small"
                        fluid
                    />
                    <small
                        v-if="form.errors.password"
                        class="text-red-500"
                    >{{ form.errors.password }}</small>
                </div>

                <div>
                    <label
                        for="password_confirmation"
                        class="block text-xs font-medium text-surface-700 dark:text-surface-300 mb-1"
                    >
                        Konfirmasi Password
                    </label>
                    <Password
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        :feedback="false"
                        toggle-mask
                        size="small"
                        fluid
                    />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <Link :href="route('users.index')">
                <Button
                    type="button"
                    label="Batal"
                    severity="secondary"
                    outlined
                    size="small"
                />
            </Link>
            <Button
                type="submit"
                :label="isEdit ? 'Simpan Perubahan' : 'Simpan Pengguna'"
                :loading="form.processing"
                size="small"
            />
        </div>
    </form>
</template>
