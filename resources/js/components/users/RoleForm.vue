<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Checkbox from 'primevue/checkbox';
import { useToast } from 'primevue/usetoast';

const props = defineProps({
    role: {
        type: Object,
        default: null, // null = mode tambah, terisi = mode edit
    },
    permissions: {
        type: Object,
        default: () => ({}),
    },
});

const toast = useToast();

const isEdit = computed(() => Boolean(props.role));

const form = useForm({
    name: props.role?.name ?? '',
    permissions: props.role?.permissions?.map((p) => p.name) ?? [],
});

// Kelompokkan permission per modul; nama modul & label aksi diambil dari
// config('permission.abilities') agar selaras dengan nama modul terkini
const groupedPermissions = computed(() => {
    const groups = {};
    for (const key in props.permissions) {
        const ability = props.permissions[key];
        // Dukung dua bentuk: objek { module, action } (terbaru) atau string biasa
        const moduleName = typeof ability === 'object' ? ability.module : key;
        const actionLabel = typeof ability === 'object' ? ability.action : ability;

        if (!groups[moduleName]) {
            groups[moduleName] = [];
        }
        groups[moduleName].push({ key, label: actionLabel });
    }
    return groups;
});

const submit = () => {
    const options = {
        onError: () => {
            toast.add({ severity: 'error', summary: 'Gagal', detail: 'Silakan periksa kembali isian form Anda', life: 3000 });
        },
    };

    if (isEdit.value) {
        form.put(route('users.roles.update', props.role.id), options);
    } else {
        form.post(route('users.roles.store'), options);
    }
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col gap-6">
            <div>
                <label
                    for="name"
                    class="block text-xs font-medium text-surface-700 dark:text-surface-300 mb-1"
                >
                    Nama Peran <span class="text-red-500">*</span>
                </label>
                <InputText
                    id="name"
                    v-model="form.name"
                    placeholder="Contoh: Sekretaris"
                    :invalid="Boolean(form.errors.name)"
                    size="small"
                    fluid
                />
                <small
                    v-if="form.errors.name"
                    class="text-red-500"
                >{{ form.errors.name }}</small>
            </div>

            <div class="flex flex-col gap-3">
                <h4 class="text-sm font-semibold m-0">
                    Hak Akses
                </h4>
                <div class="flex flex-col gap-3">
                    <div
                        v-for="(group, module) in groupedPermissions"
                        :key="module"
                        class="rounded-lg border dynamic-border p-3"
                    >
                        <p class="font-medium capitalize text-sm m-0 mb-2.5">
                            {{ module }}
                        </p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            <div
                                v-for="permission in group"
                                :key="permission.key"
                                class="flex items-center gap-2"
                            >
                                <Checkbox
                                    v-model="form.permissions"
                                    :input-id="permission.key"
                                    :value="permission.key"
                                    size="small"
                                />
                                <label
                                    :for="permission.key"
                                    class="text-sm cursor-pointer"
                                >{{ permission.label }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <small
                    v-if="form.errors.permissions"
                    class="text-red-500"
                >{{ form.errors.permissions }}</small>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <Link :href="route('users.roles.index')">
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
                :label="isEdit ? 'Simpan Perubahan' : 'Simpan Peran'"
                :loading="form.processing"
                size="small"
            />
        </div>
    </form>
</template>
