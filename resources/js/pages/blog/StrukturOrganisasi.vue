<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue'; // Pastikan path ini sesuai
import { ref } from 'vue';

import ketuaPkkDiy from '@/assets/images/org/ketua-pkk-diy.png';
import wakilKetuaPkkDiy from '@/assets/images/org/wakil-ketua-pkk-diy.png';
import homeBg from '@/assets/images/home-background.png'
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

// --- DATA STRUKTUR ORGANISASI ---
const ketuaDanWakil = ref([
    {
        nama: 'GUSTI KANJENG RATU HEMAS',
        jabatan: 'KETUA TP PKK',
        foto: ketuaPkkDiy
    },
    {
        nama: 'GKBRAA PAKU ALAM',
        jabatan: 'WAKIL KETUA TP PKK',
        foto: wakilKetuaPkkDiy
    },
]);

const penasehat = ref([
    { nama: 'GKBRAY. KUSWARJANTI RIYOKUSUMO' },
    { nama: 'Dr. Dra. I. M. SUNARSIH SUTARYO, SU, Apt' },
    { nama: 'Dr. SISWATININGSIH. SU' },
]);

const bendahara = ref([
    { nama: 'SUGIANTI' },
]);

const sekertaris = ref([
    { nama: 'M.ANGGRAINI ADRIANI', jabatan: 'SEKERTARIS' },
    { nama: 'IR. TRI MARTINI', jabatan: 'SEKERTARIS I', sub: 'URUSAN PERENCANAAN' },
    { nama: 'DARA KUSUMAWATI, SE, MM', jabatan: 'SEKERTARIS II', sub: 'URUSAN HUMAS & IT' },
    { nama: 'NUGRAHENI SIH WINANTI, SH', jabatan: 'SEKERTARIS III', sub: 'URUSAN UMUM' },
]);

const ketuaBidang = ref([
    { nama: 'Dra. KRISTIANA SWASTI, MSi', jabatan: 'KETUA 1', sub: 'PEMBINAAN KARAKTER KELUARGA' },
    { nama: 'Dra. TATIK RATNAWATI, MM', jabatan: 'KETUA II', sub: 'PENDIDIKAN DAN PENINGKATAN EKONOMI KELUARGA' },
    { nama: 'T.O SUPRAPTO', jabatan: 'KETUA III', sub: 'PENGUATAN KETAHANAN KELUARGA' },
    { nama: 'Drg. INNI HIKMATIN M.Kes', jabatan: 'KETUA IV', sub: 'KESEHATAN KELUARGA DAN LINGKUNGAN' },
]);

const pokja1 = ref([
    { nama: 'ATIK WULANDARI, SP', jabatan: 'KETUA' },
    { nama: 'Dra. BASKOROWATI', jabatan: 'ANGGOTA' },
    { nama: 'TRI SUNDARI', jabatan: 'ANGGOTA' },
    { nama: 'SURYANTINAH, SIP, MM', jabatan: 'ANGGOTA' },
]);

const pokja2 = ref([
    { nama: 'TUTIK MULYANTO, S.Sos', jabatan: 'KETUA' },
    { nama: 'SUPRIHATININGSHI', jabatan: 'ANGGOTA' },
    { nama: 'PUJI ASTUTI', jabatan: 'ANGGOTA' },
    { nama: 'YURRY APRITO', jabatan: 'ANGGOTA' },
]);

const pokja3 = ref([
    { nama: 'RUKIWIYATI', jabatan: 'KETUA' },
    { nama: 'Ir. INDIYAH WIDNINGSIH', jabatan: 'ANGGOTA' },
    { nama: 'SRI SUKARNI SUWARDI', jabatan: 'ANGGOTA' },
    { nama: 'IR. ANING INDRAWATI', jabatan: 'ANGGOTA' },
]);

const pokja4 = ref([
    { nama: 'SRI HERAWATI, SH, MSI', jabatan: 'KETUA' },
    { nama: 'SRI HARTATI, SKM, M.Kes', jabatan: 'ANGGOTA' },
    { nama: 'WITRI ASTUTI ANGGRASNI, SE', jabatan: 'ANGGOTA' },
    { nama: 'SRI MUKTISUNARDINI, SKM, M.Kes', jabatan: 'ANGGOTA' },
]);


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
                                <img :src="p.foto" :alt="p.nama" class="w-64 h-64 rounded-full mb-4 object-cover shadow-md border-4 border-white">
                                <h3 class="font-bold text-xl text-slate-800 text-center uppercase">{{ p.nama }}</h3>
                                <p class="text-sky-600 font-semibold">{{ p.jabatan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-16">
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">PENASEHAT</h2>
                            <ul class="space-y-2 text-center">
                                <li v-for="p in penasehat" :key="p.nama" class="text-slate-700 font-medium uppercase">{{ p.nama }}</li>
                            </ul>
                        </div>
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">BENDAHARA</h2>
                            <ul class="space-y-2 text-center">
                                <li v-for="p in bendahara" :key="p.nama" class="text-slate-700 font-medium uppercase">{{ p.nama }}</li>
                            </ul>
                        </div>
                    </div>

                    <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 my-16">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">SEKERTARIS</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                            <div v-for="s in sekertaris" :key="s.jabatan" class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-sky-600 text-sm font-medium  mb-3">{{ s.jabatan }}</p>
                                <p class="font-semibold text-slate-800 uppercase">{{ s.nama }}</p>
                                <p v-if="s.sub" class="text-xs text-slate-500">{{ s.sub }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 my-16">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">KETUA BIDANG</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                            <div v-for="k in ketuaBidang" :key="k.jabatan" class="p-4 bg-sky-50 rounded-lg">
                                <p class="text-sky-600 text-sm font-medium mb-3">{{ k.jabatan }}</p>
                                <p class="font-semibold text-slate-800 uppercase">{{ k.nama }}</p>
                                <p class="text-xs text-slate-500 leading-tight mt-1">{{ k.sub }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-animate-on-scroll class="animate-on-scroll my-16">
                        <h2 class="text-3xl font-bold text-slate-900 mb-8 text-center">KELOMPOK KERJA (POKJA)</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <div class="frosted-glass-card rounded-2xl p-6">
                                <h3 class="font-bold text-xl text-center text-slate-800 mb-4">POKJA I</h3>
                                <ul class="space-y-3">
                                    <li v-for="p in pokja1" :key="p.nama" class="p-2 bg-slate-50/50 rounded-md">
                                        <span class="text-sm text-sky-600 font-semibold">{{ p.jabatan }}</span>
                                        <br>
                                        <span class="uppercase font-medium text-sm text-slate-700">{{ p.nama }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="frosted-glass-card rounded-2xl p-6">
                                <h3 class="font-bold text-xl text-center text-slate-800 mb-4">POKJA II</h3>
                                <ul class="space-y-3">
                                    <li v-for="p in pokja2" :key="p.nama" class="p-2 bg-slate-50/50 rounded-md">
                                        <span class="text-sm text-sky-600 font-semibold">{{ p.jabatan }}</span>
                                        <br>
                                        <span class="uppercase font-medium text-sm text-slate-700">{{ p.nama }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="frosted-glass-card rounded-2xl p-6">
                                <h3 class="font-bold text-xl text-center text-slate-800 mb-4">POKJA III</h3>
                                <ul class="space-y-3">
                                    <li v-for="p in pokja3" :key="p.nama" class="p-2 bg-slate-50/50 rounded-md">
                                        <span class="text-sm text-sky-600 font-semibold">{{ p.jabatan }}</span>
                                        <br>
                                        <span class="uppercase font-medium text-sm text-slate-700">{{ p.nama }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="frosted-glass-card rounded-2xl p-6">
                                <h3 class="font-bold text-xl text-center text-slate-800 mb-4">POKJA IV</h3>
                                <ul class="space-y-3">
                                    <li v-for="p in pokja4" :key="p.nama" class="fp-2 bg-slate-50/50 rounded-md">
                                        <span class="text-sm text-sky-600 font-semibold">{{ p.jabatan }}</span>
                                        <br>
                                        <span class="uppercase font-medium text-sm text-slate-700">{{ p.nama }}</span>
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