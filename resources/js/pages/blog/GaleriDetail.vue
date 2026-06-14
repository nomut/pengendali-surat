<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import homeBg from '@/assets/images/home-background.png';
import Dialog from 'primevue/dialog';
import { Calendar as CalendarIcon, ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    gallery: Object, // Full JSON object from Backend
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
const getCoverImage = () => {
    if (!props.gallery.images || props.gallery.images.length === 0) return homeBg;
    return getImageUrl(props.gallery.images[0]);
};

// --- Preview Modal ---
const previewVisible = ref(false);
const currentPreviewImage = ref(null);

const openPreview = (imagePath) => {
    currentPreviewImage.value = getImageUrl(imagePath);
    previewVisible.value = true;
};
</script>

<template>
    <InertiaHead :title="gallery.title" />

    <AppLayout
        :can-login="canLogin"
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <!-- Hero Banner -->
            <section
                class="relative h-[40vh] md:h-[50vh] flex items-end pb-12 justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${getCoverImage()})` }">
                <div class="absolute inset-0 bg-linear-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10 text-white w-full max-w-5xl">
                    <InertiaLink :href="route('galeri')" class="inline-flex items-center text-sky-300 hover:text-white mb-6 transition-colors font-medium backdrop-blur-sm bg-black/20 px-4 py-2 rounded-full text-sm">
                        <ArrowLeft class="w-4 h-4 mr-2" /> Kembali ke Indeks Galeri
                    </InertiaLink>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tighter mb-4 drop-shadow-lg text-left">
                        {{ gallery.title }}
                    </h1>
                    <div class="flex items-center gap-2 text-sky-200 text-sm md:text-base mb-6 text-left font-medium">
                        <CalendarIcon class="w-5 h-5" />
                        <span>{{ gallery.date ? new Date(gallery.date).toLocaleDateString('id-ID', { year:'numeric', month:'long', day:'numeric' }) : '-' }}</span>
                        <span class="mx-2 opacity-50">•</span>
                        <span>{{ gallery.images?.length || 0 }} Foto</span>
                    </div>
                </div>
            </section>

            <!-- Gallery Details -->
            <section class="py-16 sm:py-24 relative z-10">
                <div class="container mx-auto px-4 sm:px-6 max-w-6xl">
                    
                    <!-- Description Block -->
                    <div v-if="gallery.description" v-animate-on-scroll class="animate-on-scroll bg-white/70 backdrop-blur-md border border-slate-200 shadow-sm rounded-3xl p-8 md:p-10 mb-16 text-slate-700 text-lg md:text-xl leading-relaxed font-serif relative">
                        <!-- Decorative Quote Mark -->
                        <span class="absolute -top-6 -left-4 text-7xl text-sky-200/50 font-serif leading-none rotate-180">"</span>
                        <p class="relative z-10">{{ gallery.description }}</p>
                    </div>

                    <!-- Images Grid -->
                    <div v-if="!gallery.images || gallery.images.length === 0" class="text-center py-20">
                        <p class="text-slate-500 text-lg">Belum ada foto dalam galeri ini.</p>
                    </div>

                    <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                        <div 
                            v-for="(img, iIndex) in gallery.images" 
                            :key="iIndex"
                            @click="openPreview(img)"
                            v-animate-on-scroll
                            class="animate-on-scroll aspect-square rounded-2xl overflow-hidden cursor-pointer group/item shadow-sm hover:shadow-2xl transition-all duration-500 relative bg-slate-100"
                            :style="{ transitionDelay: `${(iIndex % 8) * 50}ms` }"
                        >
                            <img :src="getImageUrl(img)" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-700 ease-in-out" loading="lazy" />
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-sky-900/0 group-hover/item:bg-sky-900/30 transition-colors duration-300 flex items-center justify-center">
                                <span class="text-white opacity-0 group-hover/item:opacity-100 font-semibold tracking-wider transition-all duration-300 transform scale-90 group-hover/item:scale-100 backdrop-blur-md bg-black/40 px-5 py-2 rounded-full border border-white/20 shadow-xl">Perbesar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Image Preview Modal -->
            <Dialog 
                v-model:visible="previewVisible" 
                modal 
                dismissableMask 
                :showHeader="false" 
                :style="{ width: '90vw', maxWidth: '1200px' }"
                pt:root:class="bg-transparent border-0 shadow-none"
                pt:content:class="p-0 bg-transparent flex items-center justify-center"
                pt:mask:class="bg-black/95 backdrop-blur-md"
            >
                <div class="relative w-full h-full flex flex-col items-center justify-center">
                    <img v-if="currentPreviewImage" :src="currentPreviewImage" class="max-w-full max-h-[85vh] object-contain shadow-[0_0_50px_rgba(0,0,0,0.5)]" />
                    <!-- Close cue -->
                    <p class="text-white/40 mt-6 text-sm font-semibold tracking-widest uppercase animate-pulse">Klik di luar gambar untuk menutup</p>
                </div>
            </Dialog>
        </main>
    </AppLayout>
</template>
