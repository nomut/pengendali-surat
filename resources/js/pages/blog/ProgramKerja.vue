<script setup>
// Impor Layout utama
import AppLayout from '@/layouts-blog/AppLayout.vue';

// Impor komponen dan helper lain yang hanya dibutuhkan di halaman ini
import Button from 'primevue/button';
import { ref } from 'vue';
import {
    BookOpen, HeartHandshake, Sprout, ArrowRight, ShieldCheck, Palette, Users
} from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

// Konten spesifik untuk halaman ini
const programs = ref([
    {
        title: 'Pendidikan & Keterampilan',
        description: 'Meningkatkan wawasan dan keahlian untuk kemandirian keluarga.',
        icon: BookOpen,
        activities: [
            'Pelatihan Digital Marketing untuk Ibu Rumah Tangga.',
            'Kelas Bahasa Inggris Komunitas.',
            'Workshop Keterampilan Menjahit Modern.'
        ]
    },
    {
        title: 'Kesejahteraan Sosial',
        description: 'Menciptakan lingkungan sosial yang suportif dan peduli.',
        icon: HeartHandshake,
        activities: [
            'Program Pendampingan Balita & Lansia.',
            'Bakti Sosial dan Donor Darah Rutin.',
            'Penyuluhan Kesehatan Mental Keluarga.'
        ]
    },
    {
        title: 'Lingkungan Hidup Lestari',
        description: 'Menggalakkan gaya hidup ramah lingkungan mulai dari rumah.',
        icon: Sprout,
        activities: [
            'Gerakan Bank Sampah di setiap RW.',
            'Workshop Pembuatan Kompos & Urban Farming.',
            'Penanaman 1000 Pohon di Lahan Kritis.'
        ]
    },
    {
        title: 'Keamanan & Ketahanan Keluarga',
        description: 'Membangun keluarga yang tangguh menghadapi tantangan zaman.',
        icon: ShieldCheck,
        activities: [
            'Seminar Pola Asuh Anak di Era Digital.',
            'Penyuluhan Anti-Narkoba dan Kenakalan Remaja.',
            'Simulasi Tanggap Bencana tingkat RT/RW.'
        ]
    },
    {
        title: 'Seni Budaya & Kreativitas',
        description: 'Melestarikan budaya lokal sambil mendorong inovasi kreatif.',
        icon: Palette,
        activities: [
            'Pelatihan Membatik untuk Generasi Muda.',
            'Pentas Seni dan Budaya tahunan.',
            'Lomba Desain Produk Kerajinan Lokal.'
        ]
    },
    {
        title: 'Koperasi & Ekonomi Kreatif',
        description: 'Mendorong kemandirian ekonomi melalui usaha bersama.',
        icon: Users,
        activities: [
            'Pendirian Koperasi Simpan Pinjam PKK.',
            'Bazar UMKM produk anggota setiap bulan.',
            'Pelatihan Manajemen Keuangan Usaha Mikro.'
        ]
    }
]);

// Directive untuk animasi scroll tetap diperlukan di sini
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
    <InertiaHead title="Program Kerja" />

    <AppLayout
        :can-login="canLogin" 
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section class="py-24 md:py-32 text-center bg-white/30">
                <div v-animate-on-scroll class="animate-on-scroll container mx-auto px-4 sm:px-6">
                    <h1 class="text-4xl md:text-6xl font-bold text-slate-900 leading-tight tracking-tighter mb-4">
                        Program Kerja Unggulan
                    </h1>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        Inisiatif kami untuk membangun keluarga yang tangguh, kreatif, dan sejahtera di Daerah Istimewa Yogyakarta.
                    </p>
                </div>
            </section>

            <section id="program-kerja" class="py-20 sm:py-24">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div
                            v-for="(program, index) in programs"
                            :key="program.title"
                            v-animate-on-scroll
                            class="animate-on-scroll frosted-glass-card rounded-2xl flex flex-col"
                            :style="{ 'transition-delay': `${index * 100}ms` }"
                        >
                            <div class="p-6 text-center border-b border-slate-900/10">
                                <div class="inline-flex p-4 bg-sky-100 rounded-full mb-4">
                                     <component :is="program.icon" class="w-8 h-8 text-sky-600" />
                                </div>
                                <h3 class="text-xl font-bold text-slate-800">{{ program.title }}</h3>
                                <p class="text-slate-600 text-sm mt-1">{{ program.description }}</p>
                            </div>
                            <div class="p-6 flex-grow">
                                <h4 class="font-semibold text-slate-700 mb-3">Kegiatan Utama:</h4>
                                <ul class="space-y-2 text-slate-600 text-sm list-disc list-inside">
                                    <li v-for="activity in program.activities" :key="activity">{{ activity }}</li>
                                </ul>
                            </div>
                            <div class="p-4 mt-auto">
                                <Button label="Ikut Serta" class="w-full futuristic-button-light !font-normal" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 sm:py-24">
                <div v-animate-on-scroll class="animate-on-scroll container mx-auto px-4 sm:px-6">
                    <div class="frosted-glass-card rounded-2xl p-8 md:p-12 text-center">
                        <h2 class="text-3xl font-bold text-slate-900 mb-4">Mari Berkontribusi!</h2>
                        <p class="text-lg text-slate-600 max-w-xl mx-auto mb-6">
                            Punya ide atau ingin terlibat dalam program kami? Hubungi kami untuk berkolaborasi dan membawa perubahan positif.
                        </p>
                        <Button size="large" class="futuristic-button-light">
                            Hubungi Kami
                            <ArrowRight class="ml-2 w-5 h-5" />
                        </Button>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>