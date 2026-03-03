<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { ref, computed } from 'vue';
import {
    Users, Shield, Wallet, Stethoscope, Eye, ArrowRight
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
    latestActivities: Array,
    latestGalleries: Array,
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
                :style="{ backgroundImage: `url(${page?.meta?.main_image ? getImageUrl(page.meta.main_image) : homeBg})` }"
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
            <section id="kegiatan-terbaru" class="py-20 sm:py-24 bg-slate-50 dark:bg-slate-900 border-t border-slate-200/50">
                <div class="container mx-auto px-4 sm:px-6">
                    <div v-animate-on-scroll class="text-center mb-16 animate-on-scroll flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-left">
                            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white">Kegiatan Terbaru</h2>
                            <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">Berita dan dokumentasi kegiatan terkini.</p>
                        </div>
                        <InertiaLink :href="route('kegiatan')" class="mt-6 sm:mt-0 px-6 py-2.5 bg-sky-100 text-sky-700 hover:bg-sky-200 hover:text-sky-800 rounded-full font-semibold transition-colors flex items-center gap-2">
                            Lihat Semua <ArrowRight class="w-4 h-4" />
                        </InertiaLink>
                    </div>

                    <div v-if="latestActivities && latestActivities.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        <article 
                            v-for="(activity, index) in latestActivities" 
                            :key="activity.id"
                            v-animate-on-scroll
                            class="animate-on-scroll bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-slate-100 dark:border-slate-700 hover:-translate-y-1"
                            :style="{ 'transition-delay': `${index * 100}ms` }"
                        >
                            <InertiaLink :href="route('kegiatan.show', activity.slug)" class="block relative aspect-[16/9] overflow-hidden bg-slate-100 dark:bg-slate-900">
                                <img 
                                    v-if="activity.cover_image"
                                    :src="getImageUrl(activity.cover_image)" 
                                    :alt="activity.title"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center text-slate-400 relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900"></div>
                                    <span class="font-medium relative z-10 text-slate-500">Tanpa Gambar</span>
                                </div>
                                
                                <div v-if="activity.date" class="absolute top-4 left-4 bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm font-medium text-xs text-sky-700 dark:text-sky-400">
                                    {{ new Date(activity.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                </div>
                            </InertiaLink>

                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex items-center gap-4 text-xs font-medium text-slate-500 mb-3">
                                    <span class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-700/50 px-2 py-1 rounded-md">
                                        <Eye class="w-3.5 h-3.5" /> {{ activity.views }}x dibaca
                                    </span>
                                </div>
                                <InertiaLink :href="route('kegiatan.show', activity.slug)" class="block mb-3">
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white leading-tight group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors line-clamp-2">
                                        {{ activity.title }}
                                    </h3>
                                </InertiaLink>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6 line-clamp-3">
                                    {{ activity.excerpt || (activity.content ? activity.content.replace(/<[^>]*>?/gm, '').substring(0, 100) + '...' : '') }}
                                </p>
                            </div>
                        </article>
                    </div>
                    <div v-else class="text-center py-10 bg-white shadow-sm rounded-xl">
                        <p class="text-slate-500">Belum ada kegiatan dipublikasikan.</p>
                    </div>
                </div>
            </section>

            <section id="galeri-terbaru" class="py-20 sm:py-24 bg-white dark:bg-slate-800 border-t border-slate-200/50">
                <div class="container mx-auto px-4 sm:px-6">
                    <div v-animate-on-scroll class="text-center mb-16 animate-on-scroll flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-left">
                            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white">Galeri Kegiatan</h2>
                            <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">Arsip foto dari berbagai kegiatan.</p>
                        </div>
                        <InertiaLink :href="route('galeri')" class="mt-6 sm:mt-0 px-6 py-2.5 bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-800 rounded-full font-semibold transition-colors flex items-center gap-2">
                            Selengkapnya <ArrowRight class="w-4 h-4" />
                        </InertiaLink>
                    </div>

                    <div v-if="latestGalleries && latestGalleries.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        <div 
                            v-for="(gallery, index) in latestGalleries" 
                            :key="gallery.id"
                            v-animate-on-scroll
                            class="animate-on-scroll group bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-100 dark:border-slate-700 flex flex-col h-full"
                            :style="{ 'transition-delay': `${index * 100}ms` }"
                        >
                            <InertiaLink :href="route('galeri.show', gallery.slug)" class="block aspect-video relative overflow-hidden bg-slate-100">
                                <img 
                                    v-if="gallery.images && gallery.images.length > 0"
                                    :src="getImageUrl(gallery.images[0])" 
                                    :alt="gallery.title" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" 
                                />
                                <div v-else class="w-full h-full flex items-center justify-center text-slate-400 relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900"></div>
                                    <span class="font-medium relative z-10 text-slate-500">Kosong</span>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center gap-1 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                    {{ gallery.images?.length || 0 }} Foto
                                </div>
                            </InertiaLink>

                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex items-center gap-2 text-slate-400 text-xs mb-3 font-medium">
                                    <span>{{ gallery.date ? new Date(gallery.date).toLocaleDateString('id-ID', { year:'numeric', month:'short', day:'numeric' }) : '-' }}</span>
                                </div>
                                <InertiaLink :href="route('galeri.show', gallery.slug)" class="block group-hover:text-sky-600 transition-colors">
                                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 leading-tight">{{ gallery.title }}</h3>
                                </InertiaLink>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-10 bg-slate-50 rounded-xl">
                        <p class="text-slate-500">Belum ada album galeri dipublikasikan.</p>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>

<style scoped>
</style>