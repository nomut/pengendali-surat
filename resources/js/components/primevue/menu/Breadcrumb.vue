<script setup lang="ts">
import { ref, useTemplateRef } from 'vue';
import Breadcrumb, { type BreadcrumbPassThroughOptions, type BreadcrumbProps } from 'primevue/breadcrumb';
import { ChevronRight, House } from 'lucide-vue-next';
import type { MenuItem } from '@/types';
import { ptViewMerge } from '@/utils';

interface ExtendedBreadcrumbProps extends Omit<BreadcrumbProps, 'model'> {
    model?: MenuItem[] | undefined;
}
const componentProps = defineProps<ExtendedBreadcrumbProps>();

// Rute beranda, dipakai untuk menandai crumb pertama dengan ikon rumah
const homeRoute = route('dashboard');

const defaultPt = ref<BreadcrumbPassThroughOptions>({
    root: 'p-0 bg-transparent text-sm',
    separator: 'mx-1 text-muted-color',
});

type BreadcrumbType = InstanceType<typeof Breadcrumb>;
const childRef = useTemplateRef<BreadcrumbType>('child-ref');
defineExpose({ $el: childRef });
</script>

<template>
    <Breadcrumb
        ref="child-ref"
        v-bind="{ ...componentProps, pt: defaultPt, ptOptions: { mergeProps: ptViewMerge } }"
    >
        <template #item="{ item, props }">
            <InertiaLink
                v-if="item.visible !== false && item.route"
                :href="item.route"
                :target="item.target"
                :class="[
                    'inline-flex items-center gap-1.5 rounded-md px-1.5 py-1 no-underline text-muted-color hover:text-color hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors',
                    item.class,
                ]"
                :style="item.style"
                :aria-disabled="item.disabled === true"
                custom
            >
                <House
                    v-if="item.route === homeRoute"
                    class="size-3.5 shrink-0"
                />
                <i
                    v-else-if="item.icon"
                    :class="['p-breadcrumb-item-icon', item.icon]"
                />
                <component
                    :is="item.lucideIcon"
                    v-else-if="item.lucideIcon"
                    :class="['size-3.5 shrink-0', item.lucideIconClass]"
                />
                <span>{{ item.label }}</span>
            </InertiaLink>
            <span
                v-else-if="item.visible !== false"
                v-bind="props.action"
                :class="['inline-flex items-center gap-1.5 px-1.5 py-1 font-semibold text-color', item.class]"
                :style="item.style"
                :aria-current="'page'"
            >
                <i
                    v-if="item.icon"
                    :class="['p-breadcrumb-item-icon', item.icon]"
                />
                <component
                    :is="item.lucideIcon"
                    v-else-if="item.lucideIcon"
                    :class="['size-3.5 shrink-0', item.lucideIconClass]"
                />
                <span>{{ item.label }}</span>
            </span>
        </template>
        <template #separator>
            <ChevronRight class="size-3.5" />
        </template>
    </Breadcrumb>
</template>
