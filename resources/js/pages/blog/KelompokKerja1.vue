<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { ref } from 'vue';
import { BookUser, Handshake } from 'lucide-vue-next';

import imgPokja1Landscape from '@/assets/images/pokja1-landscape.png'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
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
</script>

<template>
    <InertiaHead title="Program Pokja I" />

    <AppLayout
        :can-login="canLogin"
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section
                class="relative h-96 flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${imgPokja1Landscape})` }"
            >
                <div class="absolute inset-0 bg-black/60"></div> <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight tracking-tighter mb-4 drop-shadow-md">
                        Pokja I
                    </h1>
                    <p class="text-lg text-slate-200 max-w-3xl mx-auto drop-shadow-sm">
                        Fokus pada Penghayatan dan Pengamalan Pancasila serta Gotong Royong.
                    </p>
                </div>
                <div class="custom-shape-divider-bottom-light">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                    </svg>
                </div>
            </section>

            <section class="py-20 sm:py-24">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="max-w-4xl mx-auto">
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 md:p-12">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-6 text-center">PROGRAM POKJA I</h2>

                            <div class="mb-10">
                                <div class="flex items-center mb-4">
                                    <div class="p-3 bg-sky-100 rounded-full mr-4">
                                        <BookUser class="w-6 h-6 text-sky-600" />
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-800">Program Penghayatan dan Pengamalan Pancasila</h3>
                                </div>
                                <p class="text-slate-600 mb-4">Program ini dilaksanakan dengan cara:</p>
                                <ul class="list-disc list-inside space-y-2 text-slate-600">
                                    <li>Pembinaan karakter Keluarga.</li>
                                    <li>Pembinaan karakter anak sejak dini.</li>
                                    <li>Pembinaan peran orang tua dalam menerapkan pola asuh anak dan remaja di era digital.</li>
                                    <li>Pencegahan perkawinan anak dibawah umur khususnya anak perempuan.</li>
                                    <li>Pembinaan Keluarga sadar administrasi kependudukan.</li>
                                    <li>Pembinaan kesadaran bela negara.</li>
                                    <li>Pembinaan pencegahan penyalahagunaan narkoba.</li>
                                    <li>Pembinaan pencegahan kekerasan dalam rumah tangga.</li>
                                    <li>Pembinaan pencegahan perdagangan manusia.</li>
                                    <li>Pembinaan pencegahan kekerasan seksual terhadap anak.</li>
                                </ul>
                            </div>

                            <div>
                                <div class="flex items-center mb-4">
                                    <div class="p-3 bg-orange-100 rounded-full mr-4">
                                        <Handshake class="w-6 h-6 text-orange-600" />
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-800">Program Gotong Royong</h3>
                                </div>
                                <p class="text-slate-600 mb-4">Program ini dilaksanakan dengan cara:</p>
                                <ul class="list-disc list-inside space-y-2 text-slate-600">
                                    <li>Menumbuhkan sikap kesetiakawanan sosial.</li>
                                    <li>Pemberdayaan lanjut usia.</li>
                                    <li>Pemberdayaan penyandang disabilitas.</li>
                                    <li>Partisipasi dalam kegiatan bakti sosial di masyarakat.</li>
                                    <li>Pencegahan kekerasan seksual pada anak dan perempuan.</li>
                                    <li>Pencegahan praktek perdagangan manusia.</li>
                                    <li>Pembinaan keluarga Indonesia bebas narkoba.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>