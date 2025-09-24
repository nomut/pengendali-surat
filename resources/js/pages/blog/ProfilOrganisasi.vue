<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue'; // Pastikan path ini sesuai
import { ref } from 'vue';
import { Target, ClipboardCheck } from 'lucide-vue-next';
import homeBg from '@/assets/images/home-background.png'
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
    <InertiaHead title="Profil Organisasi" />

    <AppLayout
        :can-login="canLogin"
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section
                class="relative h-64 md:h-80 flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${homeBg})` }">
                <div class="absolute inset-0 bg-black/60"></div>
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight tracking-tighter mb-4 drop-shadow-md">
                        Tentang Kami
                    </h1>
                    <p class="text-lg text-slate-200 max-w-3xl mx-auto drop-shadow-sm">
                        Mengenal lebih dekat Gerakan Pemberdayaan dan Kesejahteraan Keluarga (PKK) di Daerah Istimewa Yogyakarta.
                    </p>
                </div>
            </section>


            <section class="py-20 sm:py-24">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                        <div v-animate-on-scroll class="animate-on-scroll">
                            <h2 class="text-3xl font-bold text-slate-800 mb-4">Sejarah Singkat</h2>
                            <p class="tracking-wide leading-normal text-slate-600 space-y-4">
                                Gerakan Pemberdayaan dan Kesejahteraan Keluarga (PKK) sebagai gerakan pembangunan masyarakat bermula dari seminar Home Economic di Bogor pada tahun 1957. Sebagai tindak lanjut dari seminar tersebut, pada tahun 1961 panitia penyusunan tata susunan pelajaran pada Pendidikan Kesejahteraan Keluarga (PKK) Kementerian Pendidikan.
                                <br><br>
                                Di Daerah Istimewa Yogyakarta, gerakan ini telah menjadi tulang punggung dalam upaya peningkatan kualitas hidup keluarga, adaptif terhadap perubahan zaman, dan terus berinovasi untuk memberdayakan perempuan dan masyarakat secara luas.
                            </p>
                        </div>
                        <div v-animate-on-scroll class="animate-on-scroll w-full h-80 rounded-2xl p-2 frosted-glass-card" style="transition-delay: 200ms">
                            <img :src="homeBg" alt="Gedung bersejarah di Yogyakarta" class="w-full h-full object-cover rounded-xl shadow-lg">
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 sm:py-24 bg-white/50">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 text-center">
                            <div class="inline-flex p-4 bg-sky-100 rounded-full mb-4">
                                <Target class="w-8 h-8 text-sky-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800 mb-2">Visi</h2>
                            <p class="tracking-wide leading-normal text-slate-600">Terwujudnya keluarga yang beriman dan bertaqwa kepada Tuhan Yang Maha Esa, berakhlak mulia dan berbudi luhur, sehat sejahtera, maju dan mandiri, kesetaraan dan keadilan gender serta kesadaran hukum dan lingkungan.</p>
                        </div>
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 text-center" style="transition-delay: 200ms">
                            <div class="inline-flex p-4 bg-sky-100 rounded-full mb-4">
                                <ClipboardCheck class="w-8 h-8 text-sky-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800 mb-2">Misi</h2>
                            <p class="tracking-wide leading-normal text-slate-600">Meningkatkan kualitas sumber daya manusia, memperkuat ketahanan ekonomi keluarga, serta melestarikan lingkungan hidup sambil meningkatkan kesadaran hukum dan partisipasi masyarakat.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>