<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import Button from 'primevue/button';
import { ref } from 'vue';
import {
    Users, Shield, Wallet, Stethoscope, BookText
} from 'lucide-vue-next';

import imgPokja1Landscape from '@/assets/images/pokja1-landscape.png'
import imgPokja2Landscape from '@/assets/images/pokja2-landscape.png'
import imgPokja3Landscape from '@/assets/images/pokja3-landscape.png'
import imgPokja4Landscape from '@/assets/images/pokja4-landscape.png'
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


const kelompokKerja = ref([
    {
        title: 'Pembinaan Karakter Keluarga',
        description: 'Pembinaan karakter keluarga berfokus pada penguatan nilai moral, etika, dan budaya luhur dalam keluarga. Programnya mendorong pola asuh positif, ketahanan keluarga, serta peran orang tua dalam pendidikan karakter anak, sehingga keluarga menjadi dasar pembentukan generasi yang berakhlak mulia, tangguh, dan harmonis.',
        icon: Users,
        image: imgPokja1Landscape
    }, {
        title: 'Pendidikan Dan Peningkatan Ekonomi Keluarga',
        description: 'Bidang Pendidikan dan Peningkatan Ekonomi Keluarga berupaya meningkatkan kualitas sumber daya manusia serta kemandirian ekonomi keluarga. Program yang dijalankan mencakup penguatan pendidikan nonformal, pelatihan keterampilan, serta pemberdayaan usaha mikro dan rumah tangga. Bidang ini mendorong keluarga untuk lebih kreatif, produktif, dan adaptif, sehingga mampu meningkatkan kesejahteraan serta mendukung terwujudnya keluarga mandiri dan berdaya saing di DIY.',
        icon: Wallet,
        image: imgPokja2Landscape
    }, {
        title: 'Penguatan Ketahanan Keluarga',
        description: 'Penguatan Ketahanan Keluarga berfokus pada upaya membangun keluarga yang sehat, harmonis, dan tangguh menghadapi tantangan zaman. Programnya meliputi peningkatan kualitas hubungan antaranggota keluarga, kesehatan jasmani dan rohani, serta kesadaran akan pentingnya lingkungan yang aman dan nyaman. Dengan pembinaan berkelanjutan, bidang ini mendorong keluarga di DIY agar menjadi fondasi kuat bagi terciptanya masyarakat yang sejahtera dan berkarakter.',
        icon: Shield,
        image: imgPokja3Landscape
    }, {
        title: 'Kesehatan Keluarga Dan Lingkungan',
        description: 'Kesehatan Keluarga dan Lingkungan berkomitmen meningkatkan kualitas hidup masyarakat dengan mendorong perilaku hidup bersih dan sehat. Programnya mencakup edukasi gizi, kesehatan ibu dan anak, pencegahan penyakit, serta pengelolaan lingkungan yang bersih dan ramah. Bidang ini menekankan peran keluarga sebagai agen utama dalam menjaga kesehatan sekaligus menciptakan lingkungan yang layak huni, sehat, dan berkelanjutan bagi generasi mendatang.',
        icon: Stethoscope,
        image: imgPokja4Landscape
    }
]);

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
                    <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight tracking-tighter mb-6 drop-shadow-sm">
                        PKK DIY Teguhkan Komitmen Menuju Indonesia Emas
                    </h1>
                    <p class="text-white text-lg max-w-3xl mx-auto mb-8 drop-shadow-sm font-bold bg-black/40 backdrop-blur-sm px-4 py-2 rounded-lg">
                        Terwujudnya Keluarga Beriman dan Bertaqwa kepada Tuhan Yang Maha Esa, Berakhlak Mulia, dan Berbudi Luhur, Sehat, Sejahtera, Maju, Mandiri, Kesetaraan dan Keadilan Gender, serta Kesadaran Hukum dan Lingkungan.
                    </p>
                    
                    <div class="mx-auto px-4 sm:px-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                            <InertiaLink
                                v-for="(link, index) in furtherLinks"
                                :key="link.label"
                                :href="link.route"
                                v-animate-on-scroll
                                class="group animate-on-scroll frosted-glass-card rounded-2xl p-6 text-center flex flex-col items-center justify-center transition-all duration-300 relative overflow-hidden no-underline leading-normal text-slate-600"
                                :class="[
                                    index === furtherLinks.length - 1 && furtherLinks.length % 2 === 1
                                        ? 'col-span-2 md:col-span-2'
                                        : ''
                                ]"
                                :style="{ 'transition-delay': `${index * 100}ms` }"
                            >
                                <div class="absolute inset-0 bg-gradient-to-br from-sky-100/0 via-sky-100/0 to-sky-100/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <ArrowUpRight class="absolute top-4 right-4 w-5 h-5 text-sky-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />

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