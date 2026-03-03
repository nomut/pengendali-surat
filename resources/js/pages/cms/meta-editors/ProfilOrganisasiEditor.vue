<script setup>
import Textarea from 'primevue/textarea';

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
    }
});

const emit = defineEmits(['update:modelValue']);

const updateVisi = (value) => {
    emit('update:modelValue', { ...props.modelValue, visi: value });
};

const updateMisi = (value) => {
    emit('update:modelValue', { ...props.modelValue, misi: value });
};
</script>

<template>
    <div class="flex flex-col gap-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Visi</label>
            <Textarea
                :model-value="modelValue.visi"
                @update:model-value="updateVisi"
                rows="3"
                class="w-full"
            />
            <small class="text-slate-500">Visi dari organisasi PKK DIY.</small>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Misi</label>
            <Textarea
                :model-value="modelValue.misi"
                @update:model-value="updateMisi"
                rows="5"
                class="w-full"
            />
            <small class="text-slate-500">Misi dari organisasi PKK DIY.</small>
        </div>
    </div>
</template>
