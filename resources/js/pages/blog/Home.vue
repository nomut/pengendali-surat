<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { ref, computed } from 'vue';
import {
    Users, Shield, Wallet, Stethoscope
} from 'lucide-vue-next';

import imgPokja1Landscape from '@/assets/images/pokja1-landscape.png'
import imgPokja2Landscape from '@/assets/images/pokja2-landscape.png'
import imgPokja3Landscape from '@/assets/images/pokja3-landscape.png'
import imgPokja4Landscape from '@/assets/images/pokja4-landscape.png'
import homeBg from '@/assets/images/home-background.png'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    page: Object,
});

const vAnimateOnScroll = {
  mounted: (el) => {
    const scrollContainer = el.closest('.scroll-container');
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        root: scrollContainer,
        threshold: 0.1
      }
    );
    observer.observe(el);
  },
};

const icons = [Users, Wallet, Shield, Stethoscope];
const images = [imgPokja1Landscape, imgPokja2Landscape, imgPokja3Landscape, imgPokja4Landscape];

const getImageUrl = (path) => {
    if (!path) return null;
    return `/storage/${path}`;
};

const kelompokKerja = computed(() => {
    const meta = props.page?.meta;
    const items = meta?.kelompok_kerja || [];
    return items.map((item, index) => ({
        ...item,
        icon: icons[index] || Users,
        image: item.foto_path ? getImageUrl(item.foto_path) : (images[index] || imgPokja1Landscape),
    }));
});

const furtherLinks = ref([
    { label: 'Pokja I', icon: Users, route: route('kelompok-kerja', {kelompokKerja:'pokja-1'}) },
    { label: 'Pokja II', icon: Wallet, route: route('kelompok-kerja', {kelompokKerja:'pokja-2'}) },
    { label: 'Pokja III', icon: Shield, route: route('kelompok-kerja', {kelompokKerja:'pokja-3'}) },
    { label: 'Pokja IV', icon: Stethoscope, route: route('kelompok-kerja', {kelompokKerja:'pokja-4'}) },
]);
</script>

<template>
    <InertiaHead title="Selamat Datang" />
    <AppLayout
        :can-login="canLogin"
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section
                class="relative h-[85vh] flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${homeBg})` }"
            >
                <div class="absolute inset-0 bg-black/20"></div>
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10">
                    <div v-if="page?.content" v-html="page.content" class="text-white [&>h1]:text-4xl [&>h1]:md:text-6xl [&>h1]:font-bold [&>h1]:leading-tight [&>h1]:tracking-tighter [&>h1]:mb-6 [&>h1]:drop-shadow-sm [&>p]:text-lg [&>p]:max-w-3xl [&>p]:mx-auto [&>p]:mb-8 [&>p]:drop-shadow-sm [&>p]:font-bold [&>p]:bg-black/40 [&>p]:backdrop-blur-sm [&>p]:px-4 [&>p]:py-2 [&>p]:rounded-lg"></div>

                    <div class="mx-auto px-4 sm:px-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                            <InertiaLink
                                v-for="(link, index) in furtherLinks"
                                :key="link.label"
                                :href="link.route"
                                v-animate-on-scroll
                                class="group animate-on-scroll frosted-glass-card rounded-2xl p-6 text-center flex flex-col items-center justify-center transition-all duration-300 relative overflow-hidden no-underline leading-normal text-slate-600"
                                :style="{ 'transition-delay': `${index * 100}ms` }"
                            >
                                <div class="relative z-10 flex flex-col items-center">
                                    <div class="p-3 bg-sky-100 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                                        <component :is="link.icon" class="w-7 h-7 text-sky-600" />
                                    </div>
                                    <span class="font-semibold">{{ link.label }}</span>
                                </div>
                            </InertiaLink>
                        </div>
                    </div>
                </div>
                <div class="custom-shape-divider-bottom-light">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                    </svg>
                </div>
            </section>

            <section id="lebih-lanjut" class="py-20 sm:py-24 bg-white/50">
                <div class="container mx-auto px-4 sm:px-6">
                    <div v-animate-on-scroll class="text-center mb-16 animate-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Kelompok Kerja</h2>
                        <p class="mt-4 text-lg text-slate-600">Untuk mendukung Visi dan Misi PKK DIY, beberapa kelompok kerja yang ada.</p>
                    </div>
                    <div class="space-y-20">
                        <div
                            v-for="(kelompok, index) in kelompokKerja"
                            :key="kelompok.title"
                            v-animate-on-scroll
                            class="animate-on-scroll grid lg:grid-cols-2 gap-12 items-center"
                            :style="{ 'transition-delay': `${index * 100}ms` }"
                        >
                            <div :class="['w-full h-80 rounded-2xl p-2 frosted-glass-card', index % 2 === 1 ? 'lg:order-last' : '']">
                                <img :src="kelompok.image" :alt="kelompok.title" class="w-full h-full object-cover rounded-xl shadow-lg">
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="inline-flex items-center space-x-3 bg-sky-100/80 text-sky-700 px-4 py-2 rounded-full mb-4">
                                    <component :is="kelompok.icon" class="w-5 h-5" />
                                    <span class="font-semibold text-lg">{{ kelompok.title }}</span>
                                </div>
                                <p class="tracking-wide leading-normal text-slate-600">
                                    {{ kelompok.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>

<style scoped>
</style>