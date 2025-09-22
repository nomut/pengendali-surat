<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import Button from 'primevue/button';
import { ref } from 'vue';
import {
    BookOpen, HeartHandshake, Sprout, ArrowRight
} from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

// Konten spesifik halaman
const programs = ref([
    {
        title: 'Pendidikan & Keterampilan',
        description: 'Meningkatkan wawasan dan keterampilan keluarga melalui berbagai pelatihan dan lokakarya inovatif.',
        icon: BookOpen,
        image: 'https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop'
    },
    {
        title: 'Kesejahteraan Sosial',
        description: 'Program bantuan dan pendampingan berbasis komunitas untuk mewujudkan keluarga yang sehat dan sejahtera.',
        icon: HeartHandshake,
        image: 'https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&w=2070&auto=format&fit=crop'
    },
    {
        title: 'Lingkungan Hidup Lestari',
        description: 'Menggalakkan kesadaran dan aksi nyata akan pentingnya kelestarian lingkungan hidup di sekitar kita.',
        icon: Sprout,
        image: 'https://images.unsplash.com/photo-1585020430145-2a6b034f7729?q=80&w=2070&auto=format&fit=crop'
    }
]);
const heroBackgroundImage = ref("https://images.unsplash.com/photo-1563816453154-33add611bdf4?q=80&w=2070&auto=format&fit=crop");

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
    <InertiaHead title="Selamat Datang" />
    <AppLayout 
        :can-login="canLogin" 
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section
                class="relative h-[65vh] flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${heroBackgroundImage})` }"
            >
                <div class="absolute inset-0 bg-black/50"></div>
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10">
                    <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight tracking-tighter mb-6 drop-shadow-md">
                        Inovasi Pemberdayaan, Wujudkan Keluarga Sejahtera.
                    </h1>
                    <p class="text-lg text-slate-200 max-w-2xl mx-auto mb-8 drop-shadow-sm">
                        Jelajahi berbagai program terdepan kami yang dirancang untuk mengangkat potensi setiap keluarga di Yogyakarta.
                    </p>
                    <InertiaLink href="#lebih-lanjut">
                        <Button size="large" class="futuristic-button-light">
                            Lebih Lanjut
                            <ArrowRight class="ml-2 w-5 h-5" />
                        </Button>
                    </InertiaLink>
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
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Inisiatif Unggulan</h2>
                        <p class="mt-4 text-lg text-slate-600">Program terdepan kami untuk transformasi digital keluarga.</p>
                    </div>
                    <div class="space-y-20">
                        <div
                            v-for="(program, index) in programs"
                            :key="program.title"
                            v-animate-on-scroll
                            class="animate-on-scroll grid lg:grid-cols-2 gap-12 items-center"
                            :style="{ 'transition-delay': `${index * 100}ms` }"
                        >
                            <div :class="['w-full h-80 rounded-2xl p-2 frosted-glass-card', index % 2 === 1 ? 'lg:order-last' : '']">
                                <img :src="program.image" :alt="program.title" class="w-full h-full object-cover rounded-xl shadow-lg">
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="inline-flex items-center space-x-3 bg-sky-100/80 text-sky-700 px-4 py-2 rounded-full mb-4">
                                    <component :is="program.icon" class="w-5 h-5" />
                                    <span class="font-semibold">{{ program.title }}</span>
                                </div>
                                <p class="text-lg text-slate-600">
                                    {{ program.description }}
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
.custom-shape-divider-bottom-light {
    position: absolute; bottom: -1px; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(0);
}
.custom-shape-divider-bottom-light svg {
    position: relative; display: block; width: calc(100% + 1.3px); height: 80px;
}
.custom-shape-divider-bottom-light .shape-fill {
    fill: #f9fefe;
}
</style>