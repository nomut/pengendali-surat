<script setup>
import { computed, inject } from 'vue';
import { Sun, Moon, Monitor } from 'lucide-vue-next';

const colorMode = inject('colorMode');

const modes = [
    { value: 'light', icon: Sun, label: 'Terang' },
    { value: 'dark', icon: Moon, label: 'Gelap' },
    { value: 'auto', icon: Monitor, label: 'Sistem' },
];

const current = computed(() => modes.find((mode) => mode.value === colorMode.value) ?? modes[0]);

const cycle = () => {
    const index = modes.findIndex((mode) => mode.value === colorMode.value);
    colorMode.value = modes[(index + 1) % modes.length].value;
};
</script>

<template>
    <Button
        :title="`Mode: ${current.label}`"
        :aria-label="`Mode: ${current.label}`"
        severity="secondary"
        text
        rounded
        @click="cycle"
    >
        <template #icon>
            <component
                :is="current.icon"
                class="size-5!"
            />
        </template>
    </Button>
</template>
