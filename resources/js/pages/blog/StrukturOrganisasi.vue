<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { computed } from 'vue';
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
      { root: scrollContainer, threshold: 0.1 }
    );
    observer.observe(el);
  },
};

const meta = computed(() => props.page?.meta || {});
const ketuaDanWakil = computed(() => meta.value.ketua_dan_wakil || []);
const penasehat = computed(() => meta.value.penasehat || []);
const bendahara = computed(() => meta.value.bendahara || []);
const sekertaris = computed(() => meta.value.sekertaris || []);
const ketuaBidang = computed(() => meta.value.ketua_bidang || []);
const pokjaList = computed(() => meta.value.pokja || []);

const getImageUrl = (path) => {
    if (!path) return null;
    return `/storage/${path}`;
};
</script>

<template>
    <InertiaHead title="Struktur Organisasi" />

    <AppLayout :can-login="canLogin" :can-register="canRegister" :laravel-version="laravelVersion" :php-version="phpVersion">
        <main>
            <section
                class="relative h-64 md:h-80 flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${homeBg})` }">
                <div class="absolute inset-0 bg-black/60"></div>
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight tracking-tighter mb-4 drop-shadow-md">
                        Struktur Organisasi
                    </h1>
                    <p class="text-lg text-slate-200 max-w-3xl mx-auto drop-shadow-sm">
                        Tim Penggerak Pemberdayaan dan Kesejahteraan Keluarga Daerah Istimewa Yogyakarta.
                    </p>
                </div>
            </section>

            <section class="py-20 sm:py-24">
                <div class="container mx-auto px-4 sm:px-6">
                    <div v-animate-on-scroll class="animate-on-scroll text-center mb-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                            <div v-for="p in ketuaDanWakil" :key="p.jabatan" class="frosted-glass-card rounded-2xl p-6 flex flex-col items-center shadow-lg">
                                <div class="w-64 h-64 rounded-full mb-4 bg-slate-200 flex items-center justify-center overflow-hidden shadow-inner">
                                    <img v-if="p.foto_path" :src="getImageUrl(p.foto_path)" class="w-full h-full object-cover" :alt="p.nama">
                                    <span v-else class="text-6xl font-bold text-slate-400">{{ p.nama?.charAt(0) || '?' }}</span>
                                </div>
                                <h3 class="font-bold text-xl text-slate-800 text-center uppercase">{{ p.nama }}</h3>
                                <p class="text-sky-600 font-semibold">{{ p.jabatan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-16">
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">PENASEHAT</h2>
                            <ul class="space-y-4">
                                <li v-for="p in penasehat" :key="p.nama" class="flex flex-col sm:flex-row items-center gap-4 bg-white/50 p-3 rounded-xl border border-white/40 shadow-sm">
                                    <div class="w-16 h-16 bg-slate-200 rounded-full overflow-hidden shadow-inner shrink-0 flex items-center justify-center">
                                        <img v-if="p.foto_path" :src="getImageUrl(p.foto_path)" class="w-full h-full object-cover">
                                        <span v-else class="text-slate-400 font-bold text-2xl" v-text="p.nama?.charAt(0) || '?'" />
                                    </div>
                                    <span class="text-slate-800 font-bold uppercase text-center sm:text-left">{{ p.nama }}</span>
                                </li>
                            </ul>
                        </div>
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">BENDAHARA</h2>
                            <ul class="space-y-4">
                                <li v-for="p in bendahara" :key="p.nama" class="flex flex-col sm:flex-row items-center gap-4 bg-white/50 p-3 rounded-xl border border-white/40 shadow-sm">
                                    <div class="w-16 h-16 bg-slate-200 rounded-full overflow-hidden shadow-inner shrink-0 flex items-center justify-center">
                                        <img v-if="p.foto_path" :src="getImageUrl(p.foto_path)" class="w-full h-full object-cover">
                                        <span v-else class="text-slate-400 font-bold text-2xl" v-text="p.nama?.charAt(0) || '?'" />
                                    </div>
                                    <span class="text-slate-800 font-bold uppercase text-center sm:text-left">{{ p.nama }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 my-16">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">SEKERTARIS</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                            <div v-for="s in sekertaris" :key="s.jabatan" class="p-4 bg-slate-50 flex flex-col items-center rounded-lg border shadow-sm">
                                <div class="w-20 h-20 bg-slate-200 rounded-full overflow-hidden mb-3 shadow-inner flex items-center justify-center">
                                    <img v-if="s.foto_path" :src="getImageUrl(s.foto_path)" class="w-full h-full object-cover">
                                    <span v-else class="text-slate-400 font-bold text-3xl" v-text="s.nama?.charAt(0) || '?'" />
                                </div>
                                <p class="text-sky-600 text-sm font-medium mb-1">{{ s.jabatan }}</p>
                                <p class="font-semibold text-slate-800 uppercase text-sm mb-1 line-clamp-2">{{ s.nama }}</p>
                                <p v-if="s.sub" class="text-xs text-slate-500">{{ s.sub }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 my-16">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">KETUA BIDANG</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                            <div v-for="k in ketuaBidang" :key="k.jabatan" class="p-4 bg-sky-50 flex flex-col items-center rounded-lg border border-sky-100 shadow-sm">
                                <div class="w-20 h-20 bg-slate-200 rounded-full overflow-hidden mb-3 shadow-inner flex items-center justify-center">
                                    <img v-if="k.foto_path" :src="getImageUrl(k.foto_path)" class="w-full h-full object-cover">
                                    <span v-else class="text-slate-400 font-bold text-3xl" v-text="k.nama?.charAt(0) || '?'" />
                                </div>
                                <p class="text-sky-600 text-sm font-medium mb-1">{{ k.jabatan }}</p>
                                <p class="font-semibold text-slate-800 uppercase text-sm mb-1 line-clamp-2">{{ k.nama }}</p>
                                <p class="text-xs text-slate-500 leading-tight mt-1">{{ k.sub }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-animate-on-scroll class="animate-on-scroll my-16">
                        <h2 class="text-3xl font-bold text-slate-900 mb-8 text-center">KELOMPOK KERJA (POKJA)</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <div v-for="pokja in pokjaList" :key="pokja.nama" class="frosted-glass-card rounded-2xl p-6">
                                <h3 class="font-bold text-xl text-center text-slate-800 mb-4">{{ pokja.nama }}</h3>
                                <ul class="space-y-3">
                                    <li v-for="p in pokja.anggota" :key="p.nama" class="p-3 bg-slate-50/50 rounded-md flex items-center gap-4 text-left">
                                        <div class="w-12 h-12 shrink-0 bg-slate-200 rounded-full overflow-hidden flex items-center justify-center shadow-sm">
                                            <img v-if="p.foto_path" :src="getImageUrl(p.foto_path)" class="w-full h-full object-cover">
                                            <span v-else class="text-lg font-bold text-slate-400">{{ p.nama?.charAt(0) || '?' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-sm text-sky-600 font-semibold">{{ p.jabatan }}</span>
                                            <br>
                                            <span class="uppercase font-medium text-sm text-slate-700">{{ p.nama }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>