<script setup>
import InputText from 'primevue/inputtext';

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
    }
});

const emit = defineEmits(['update:modelValue']);

const updateSubtitle = (value) => {
    emit('update:modelValue', { ...props.modelValue, subtitle: value });
};
</script>

<template>
    <div class="flex flex-col gap-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Subtitle (Keterangan di bawah Judul)</label>
            <InputText
                :model-value="modelValue ? modelValue.subtitle : ''"
                @update:model-value="updateSubtitle"
                class="w-full"
                placeholder="Masukkan subtitle Pokja..."
            />
        </div>
    </div>
</template>
