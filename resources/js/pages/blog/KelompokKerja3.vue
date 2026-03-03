<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { computed } from 'vue';
import imgPokjaLandscape from '@/assets/images/pokja3-landscape.png'

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
      {
        root: scrollContainer,
        threshold: 0.1
      }
    );
    observer.observe(el);
  },
};

const subtitle = computed(() => props.page?.meta?.subtitle || '');
</script>

<template>
    <InertiaHead :title="page?.title || 'Program Pokja I'" />

    <AppLayout
        :can-login="canLogin"
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section
                class="relative h-96 flex items-center justify-center text-center bg-cover bg-center"
                :style="{ backgroundImage: `url(${imgPokjaLandscape})` }"
            >
                <div class="absolute inset-0 bg-black/60"></div>
                <div v-animate-on-scroll class="animate-on-scroll relative container mx-auto px-4 sm:px-6 z-10 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight tracking-tighter mb-4 drop-shadow-md">
                        {{ page?.title || 'Pokja I' }}
                    </h1>
                    <p class="text-lg text-slate-200 max-w-3xl mx-auto drop-shadow-sm">
                        {{ subtitle }}
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
                            <div v-if="page?.content" v-html="page.content" class="prose prose-slate max-w-none [&>h2]:text-2xl [&>h2]:md:text-3xl [&>h2]:font-bold [&>h2]:text-slate-900 [&>h2]:mb-6 [&>h2]:text-center [&>h3]:text-xl [&>h3]:font-semibold [&>h3]:text-slate-800 [&>h3]:mb-4 [&>p]:text-slate-600 [&>p]:mb-4 [&>ul]:list-disc [&>ul]:list-inside [&>ul]:space-y-2 [&>ul]:text-slate-600"></div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>