<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import homeBg from '@/assets/images/home-background.png';
import { Calendar as CalendarIcon, ArrowRight } from 'lucide-vue-next';
import Paginator from 'primevue/paginator';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    galleries: Object, // Laravel Paginated Data
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
      { root: scrollContainer, threshold: 0.1 }
    );
    observer.observe(el);
  },
};

const getImageUrl = (path) => path ? `/storage/${path}` : null;

// Get the first image as cover
const getCoverImage = (images) => {
    if (!images || !Array.isArray(images) || images.length === 0) return homeBg;
    return getImageUrl(images[0]);
};

// Handle Pagination
const onPageChange = (event) => {
    const page = event.page + 1;
    router.get(
        route('galeri'),
        { page: page },
        { preserveState: true, preserveScroll: true }
    );
};
</script>

<template>
    <InertiaHead title="Galeri Kegiatan" />

    <AppLayout
        :can-login="canLogin"
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <!-- Hero Banner -->
            <section
                class="relative h-64 md:h-80 flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${homeBg})` }">
                <div class="absolute inset-0 bg-linear-to-b from-slate-900/70 via-slate-900/45 to-slate-900/70"></div>
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10 text-white">
                    <span class="inline-block mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">Dokumentasi</span>
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight tracking-tighter mb-4 drop-shadow-md">
                        Galeri Kegiatan
                    </h1>
                    <div class="mx-auto mb-6 h-1 w-20 rounded-full bg-linear-to-r from-sky-400 to-cyan-300"></div>
                    <p class="text-lg text-slate-200 max-w-3xl mx-auto drop-shadow-sm">
                        Kumpulan dokumentasi visual dari berbagai program dan kegiatan penggerak kesejahteraan keluarga (PKK) DIY.
                    </p>
                </div>
            </section>

            <!-- Gallery List Content -->
            <section class="py-20 sm:py-24 relative z-10">
                <div class="container mx-auto px-4 sm:px-6">
                    
                    <div v-if="!galleries.data || galleries.data.length === 0" class="text-center py-20 bg-white/50 backdrop-blur-sm rounded-3xl border border-white/20 shadow-xl">
                        <p class="text-slate-500 text-xl font-medium">Belum ada album galeri yang dipublikasikan.</p>
                    </div>

                    <div v-else class="space-y-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            
                            <!-- Gallery Card -->
                            <div v-for="(gallery, index) in galleries.data" :key="gallery.id" 
                                v-animate-on-scroll class="animate-on-scroll group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-sky-900/10 transition-all duration-300 border border-slate-200/70 hover:-translate-y-1.5 flex flex-col h-full"
                                :style="{ transitionDelay: `${index * 50}ms` }">
                                
                                <InertiaLink :href="route('galeri.show', gallery.slug)" class="block aspect-video relative overflow-hidden">
                                    <img :src="getCoverImage(gallery.images)" :alt="gallery.title" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                                    <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm text-sky-800 text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center gap-1 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                        Lihat {{ gallery.images?.length || 0 }} Foto <ArrowRight class="w-3 h-3" />
                                    </div>
                                </InertiaLink>

                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-3">
                                        <CalendarIcon class="w-4 h-4 text-sky-500" />
                                        <span>{{ gallery.date ? new Date(gallery.date).toLocaleDateString('id-ID', { year:'numeric', month:'long', day:'numeric' }) : '-' }}</span>
                                    </div>
                                    <InertiaLink :href="route('galeri.show', gallery.slug)" class="block group-hover:text-sky-600 transition-colors">
                                        <h3 class="text-2xl font-bold text-slate-800 mb-2 line-clamp-2 leading-tight">{{ gallery.title }}</h3>
                                    </InertiaLink>
                                    <p class="text-slate-600 text-sm line-clamp-3 mb-4 flex-grow">{{ gallery.description || 'Tidak ada deskripsi.' }}</p>
                                </div>
                            </div>

                        </div>

                        <!-- Pagination -->
                        <div v-if="galleries.total > galleries.per_page" class="flex justify-center mt-12 pt-8 border-t border-slate-200/50">
                            <Paginator 
                                :rows="galleries.per_page" 
                                :totalRecords="galleries.total" 
                                :first="(galleries.current_page - 1) * galleries.per_page"
                                @page="onPageChange"
                                template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
                                pt:root:class="bg-white/80 backdrop-blur-sm shadow-md rounded-full px-4 py-2 border border-white/50"
                            />
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>
