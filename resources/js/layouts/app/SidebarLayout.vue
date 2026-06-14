<script setup>
import { computed, useTemplateRef } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { ChevronDown, Menu as MenuIcon } from 'lucide-vue-next';
import { useAppLayout } from '@/composables/useAppLayout';
import ClientOnly from '@/components/ClientOnly.vue';
import FlashMessages from '@/components/FlashMessages.vue';
import NavLogoLink from '@/components/NavLogoLink.vue';
import SidebarNav from '@/components/SidebarNav.vue';
import ColorModeToggle from '@/components/ColorModeToggle.vue';
import Menu from '@/components/primevue/menu/Menu.vue';
import Breadcrumb from '@/components/primevue/menu/Breadcrumb.vue';

const props = defineProps({
    breadcrumbs: {
        type: Array,
        required: false,
        default: () => [],
    },
});

const page = usePage();
const {
    mobileMenuOpen,
    menuItems,
    userMenuItems,
} = useAppLayout();

const userInitials = computed(() => {
    return page.props.auth.user.name
        .split(' ')
        .map((word) => word[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();
});

const userMenu = useTemplateRef('user-menu');
const toggleUserMenu = (event) => {
    userMenu.value.$el.toggle(event);
};
</script>

<template>
    <div class="relative min-h-screen">
        <!-- Background Tugu Jogja, diblur — di belakang seluruh konten -->
        <div
            class="fixed inset-0 -z-10 bg-cover bg-center blur-xs scale-105"
            style="background-image: url('/tugu-bg.jpg')"
            aria-hidden="true"
        />
        <!-- Overlay kuat agar konten tetap nyaman dibaca (mode terang/gelap) -->
        <div
            class="fixed inset-0 -z-10 bg-surface-100/85 dark:bg-surface-950/88"
            aria-hidden="true"
        />

        <ClientOnly>
            <Teleport to="body">
                <!-- Mobile drawer menu -->
                <Drawer
                    v-model:visible="mobileMenuOpen"
                    position="left"
                    pt:root:class="w-72!"
                >
                    <template #header>
                        <NavLogoLink />
                    </template>
                    <SidebarNav :items="menuItems" />
                </Drawer>
                <ScrollTop
                    :buttonProps="{ class: 'fixed! right-4! bottom-4! md:right-8! md:bottom-8! z-[1000]!', rounded: true, raised: true }"
                />
            </Teleport>
        </ClientOnly>

        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex fixed inset-y-0 left-0 z-50 w-68 flex-col dynamic-bg border-r dynamic-border">
            <div class="flex items-center shrink-0 h-16 px-6">
                <NavLogoLink />
            </div>
            <div class="flex-1 overflow-y-auto px-4 pb-4 pt-4">
                <SidebarNav :items="menuItems" />
            </div>
        </aside>

        <div class="lg:pl-68 flex flex-col min-h-screen pt-16">
            <!-- Fixed Topbar -->
            <header class="fixed top-0 inset-x-0 lg:left-68 z-40 dynamic-bg border-b dynamic-border">
                <div class="h-16 px-4 md:px-8 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        <Button
                            class="lg:hidden"
                            severity="secondary"
                            text
                            rounded
                            @click="mobileMenuOpen = true"
                        >
                            <template #icon>
                                <MenuIcon class="size-5!" />
                            </template>
                        </Button>
                        <div class="lg:hidden">
                            <NavLogoLink />
                        </div>
                        <!-- Breadcrumbs -->
                        <Breadcrumb
                            v-if="props.breadcrumbs.length"
                            :model="props.breadcrumbs"
                            class="hidden lg:block"
                        />
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <ClientOnly>
                            <ColorModeToggle />
                        </ClientOnly>
                        <!-- User Dropdown Menu -->
                        <Button
                            id="user-menu-btn"
                            severity="secondary"
                            text
                            pt:root:class="px-2 py-1.5"
                            @click="toggleUserMenu($event)"
                        >
                            <Avatar
                                :label="userInitials"
                                shape="circle"
                                class="bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-100 font-semibold"
                            />
                            <span class="hidden md:block max-w-40 truncate text-sm font-medium">
                                {{ page.props.auth.user.name }}
                            </span>
                            <ChevronDown class="hidden md:block size-4!" />
                        </Button>
                        <Menu
                            ref="user-menu"
                            :model="userMenuItems"
                            pt:root:class="z-[1200]!"
                            popup
                        />
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1">
                <Container
                    vertical
                    fluid
                >
                    <!-- Session-based Flash Messages -->
                    <FlashMessages />

                    <!-- Page Content -->
                    <slot />
                </Container>
            </main>
        </div>
    </div>
</template>
