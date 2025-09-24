<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue'; // Pastikan path ini sesuai
import { ref } from 'vue';
// Ikon yang relevan dengan tema Kesehatan, Lingkungan, dan Perencanaan
import { HeartPulse, Leaf, PiggyBank } from 'lucide-vue-next'; 
import imgPokja4Landscape from '@/assets/images/pokja4-landscape.png';

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
    <InertiaHead title="Program Pokja IV" />

    <AppLayout
        :can-login="canLogin"
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section
                class="relative h-96 flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${imgPokja4Landscape})` }"
            >
                <div class="absolute inset-0 bg-black/60"></div> 
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight tracking-tighter mb-4 drop-shadow-md">
                        Pokja IV
                    </h1>
                    <p class="text-lg text-slate-200 max-w-3xl mx-auto drop-shadow-sm">
                        Fokus pada Kesehatan, Kelestarian Lingkungan Hidup, dan Perencanaan Sehat.
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
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-6 text-center">PROGRAM POKJA IV</h2>

                            <div class="mb-10">
                                <div class="flex items-center mb-4">
                                    <div class="p-3 bg-red-100 rounded-full mr-4">
                                        <HeartPulse class="w-6 h-6 text-red-600" />
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-800">Program Kesehatan</h3>
                                </div>
                                <p class="text-slate-600 mb-4">Program ini dilaksanakan dengan cara:</p>
                                <ul class="list-disc list-inside space-y-2 text-slate-600">
                                    <li>Menggerakkan Keluarga dalam perilaku hidup bersih dan sehat.</li>
                                    <li>Pembinaan peran serta masyarakat dalam upaya penurunan angka kematian ibu, bayi dan balita.</li>
                                    <li>Pembinaan Keluarga yang sadar gizi.</li>
                                    <li>Mendukung program pencegahan dan deteksi dini kanker pada perempuan.</li>
                                    <li>Pembinaan Keluarga dalam pelaksanaan imunisasi dan pencegahan penyakit menular maupun tidak menular serta asuhan mandiri dalam Keluarga.</li>
                                </ul>
                            </div>

                            <div class="mb-10">
                                <div class="flex items-center mb-4">
                                    <div class="p-3 bg-green-100 rounded-full mr-4">
                                        <Leaf class="w-6 h-6 text-green-600" />
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-800">Program Kelestarian Lingkungan Hidup</h3>
                                </div>
                                <p class="text-slate-600 mb-4">Program ini dilaksanakan dengan cara:</p>
                                <ul class="list-disc list-inside space-y-2 text-slate-600">
                                    <li>Pembinaan keluarga dalam memelihara dan menjaga lingkungan bersih dan sehat.</li>
                                    <li>Melestarikan lingkungan hidup.</li>
                                </ul>
                            </div>
                            
                            <div>
                                <div class="flex items-center mb-4">
                                    <div class="p-3 bg-sky-100 rounded-full mr-4">
                                        <PiggyBank class="w-6 h-6 text-sky-600" />
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-800">Program Perencanaan Sehat</h3>
                                </div>
                                <p class="text-slate-600 mb-4">Program ini dilaksanakan dengan cara:</p>
                                <ul class="list-disc list-inside space-y-2 text-slate-600">
                                    <li>pembinaan Keluarga dalam meningkatkan Keluarga berencana menuju Keluarga berkualitas.</li>
                                    <li>melakukan perencanaan keuangan yang baik untuk kehidupan Keluarga sehat.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>