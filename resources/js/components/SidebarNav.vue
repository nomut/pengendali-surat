<script setup>
import { computed } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});

// Buang item tersembunyi, lalu rapikan separator yatim (di awal/akhir atau berurutan)
const visibleItems = computed(() => {
    const result = [];
    for (const item of props.items) {
        if (item.separator) {
            if (result.length && !result[result.length - 1].separator) {
                result.push(item);
            }
        } else if (item.visible !== false) {
            result.push(item);
        }
    }
    while (result.length && result[result.length - 1].separator) {
        result.pop();
    }
    return result;
});
</script>

<template>
    <nav class="flex flex-col gap-1.5">
        <template
            v-for="(item, index) in visibleItems"
            :key="item.label ?? `separator-${index}`"
        >
            <div
                v-if="item.separator"
                class="my-1.5 border-t dynamic-border"
            />
            <InertiaLink
                v-else-if="item.route"
                :href="item.route"
                :target="item.target"
                class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium no-underline transition-colors duration-200"
                :class="item.active
                    ? 'bg-linear-to-r from-primary-500 to-primary-600 text-primary-contrast shadow-md shadow-primary-500/40 dark:from-primary-400 dark:to-primary-500'
                    : 'text-muted-color hover:bg-surface-100 hover:text-color dark:hover:bg-surface-800'"
            >
                <component
                    :is="item.lucideIcon"
                    v-if="item.lucideIcon"
                    class="size-5 shrink-0"
                />
                <span>{{ item.label }}</span>
            </InertiaLink>
        </template>
    </nav>
</template>
