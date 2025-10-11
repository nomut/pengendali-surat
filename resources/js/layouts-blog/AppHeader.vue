<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

import ApplicationLogo from '@/components/ApplicationLogo.vue';
import Button from 'primevue/button';
import Menubar from '@/components/primevue/menu/Menubar.vue';
import ClientOnly from '@/components/ClientOnly.vue';
import PanelMenu from '@/components/primevue/menu/PanelMenu.vue';

import {
    Home, Landmark, ListChecks, Menu, CircleChevronRight, Network
} from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const page = usePage();
const mobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};

const menuItems = ref([
    { 
        label: 'Beranda', 
        route: route('home'), 
        lucideIcon: Home 
    },
    {
        label: 'Pokja PKK',
        lucideIcon: ListChecks,
        items: [
            {
                label: 'Pokja I',
                route: route('kelompok-kerja', {kelompokKerja:'pokja-1'}),
                lucideIcon: CircleChevronRight,
            },
            {
                label: 'Pokja II',
                route: route('kelompok-kerja', {kelompokKerja:'pokja-2'}),
                lucideIcon: CircleChevronRight,
            },
            {
                label: 'Pokja III',
                route: route('kelompok-kerja', {kelompokKerja:'pokja-3'}),
                lucideIcon: CircleChevronRight,
            },
            {
                label: 'Pokja IV',
                route: route('kelompok-kerja', {kelompokKerja:'pokja-4'}),
                lucideIcon: CircleChevronRight,
            },
        ],
    },
    { 
        label: 'Struktur Organisasi', 
        route: route('struktur-organisasi'), 
        lucideIcon: Network 
    },
    { 
        label: 'Profil Organisasi', 
        route: route('profil-organisasi'), 
        lucideIcon: Landmark 
    },
]);

</script>

<template>
    <ClientOnly>
        <Teleport to="body">
            <!-- Mobile drawer menu -->
            <Drawer
                v-model:visible="mobileMenuOpen"
                position="right"
            >
                <div>
                    <PanelMenu
                        :model="menuItems"
                        class="mt-1 w-full"
                    >
                    </PanelMenu>
                </div>
                <template #footer>
                    <div class="flex flex-col">
                        <template v-if="page.props.auth.user">
                            <InertiaLink :href="route('dashboard')" @click="toggleMobileMenu">
                                <Button label="Dashboard" class="w-full" />
                            </InertiaLink>
                        </template>
                        <template v-else>
                            <InertiaLink :href="route('login')" class="block mb-3" @click="toggleMobileMenu">
                                <Button label="Login" class="w-full futuristic-button-light" />
                            </InertiaLink>
                            <!-- <InertiaLink :href="route('register')" @click="toggleMobileMenu">
                                <Button label="Register" outlined class="w-full !border-sky-500 !text-sky-500" />
                            </InertiaLink> -->
                        </template>
                    </div>
                </template>
            </Drawer>
            <ScrollTop
                :buttonProps="{ class: 'fixed! right-4! bottom-4! md:right-8! md:bottom-8! z-[1000]!', rounded: true, raised: true }"
            />
        </Teleport>
    </ClientOnly>

    <header class="frosted-glass-header sticky top-0 z-40">
        <div class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            
            <InertiaLink :href="route('home')" class="flex items-center space-x-2 group">
                <ApplicationLogo class="w-14 h-14 fill-current text-surface-900 dark:text-surface-0" />
                <span class="text-2xl font-bold tracking-wider text-slate-900 group-hover:text-black transition-colors duration-300">
                    PKK DIY
                </span>
            </InertiaLink>
            
            <nav class="hidden md:flex items-center space-x-8">
                <Menubar
                    :model="menuItems"
                    class="text-lg"
                    pt:root:class="px-0 py-4 border-0 rounded-none  bg-transparent"
                    pt:button:class="hidden"
                >
                </Menubar>
            </nav>

            <div class="hidden md:flex items-center space-x-2">
                <template v-if="page.props.auth.user">
                    <InertiaLink :href="route('dashboard')">
                        <Button label="Dashboard" text class="text-slate-700 hover:bg-black/5" />
                    </InertiaLink>
                </template>
                <template v-else>
                    <InertiaLink :href="route('login')">
                        <Button label="Login" text class="text-slate-700 hover:bg-black/5" />
                    </InertiaLink>
                    <!-- <InertiaLink :href="route('register')">
                        <Button label="Register" outlined class="!border-sky-500 !text-sky-500 hover:!bg-sky-500/10" />
                    </InertiaLink> -->
                </template>
            </div>
            <div class="md:hidden">
                <Button text rounded aria-label="Toggle Menu" @click="toggleMobileMenu" class="!p-2 text-slate-800" >
                    <Menu class="w-6 h-6" />
                </Button>
            </div>
        </div>
    </header>
</template>