<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from 'primevue/button';
import {
    LogIn, UserPlus, Home, Landmark, ListChecks, Menu
} from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

// Mendefinisikan event yang bisa dipancarkan oleh komponen ini
const emit = defineEmits(['toggle-menu']);

const page = usePage();

const menuItems = ref([
    { label: 'Beranda', route: 'home', icon: Home },
    { label: 'Profil Organisasi', route: 'profil-organisasi', icon: Landmark },
    { label: 'Program Kerja', route: 'program-kerja', icon: ListChecks },
]);
</script>

<template>
    <header class="frosted-glass-header sticky top-0 z-40">
        <div class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            
            <InertiaLink :href="route('home')" class="flex items-center space-x-2 group">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-sky-500 group-hover:text-sky-600 transition-colors duration-300">
                    <path d="M12 2L3 22H21L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M12 14L8 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 14L16 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 14V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-xl font-bold tracking-wider text-slate-900 group-hover:text-black transition-colors duration-300">
                    PKK DIY
                </span>
            </InertiaLink>
            
            <nav class="hidden md:flex items-center space-x-8">
                <InertiaLink v-for="item in menuItems" :key="item.label" :href="item.route === '#' ? '#' : route(item.route)" class="nav-link-light">
                    <span>{{ item.label }}</span>
                </InertiaLink>
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
                    <InertiaLink :href="route('register')">
                        <Button label="Register" outlined class="!border-sky-500 !text-sky-500 hover:!bg-sky-500/10" />
                    </InertiaLink>
                </template>
            </div>
            <div class="md:hidden">
                <Button text rounded aria-label="Toggle Menu" @click="emit('toggle-menu')" class="!p-2 text-slate-800" >
                    <Menu class="w-6 h-6" />
                </Button>
            </div>
        </div>
    </header>
</template>