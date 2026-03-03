<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { Calendar, Eye, ArrowLeft, Share2 } from 'lucide-vue-next';
import Button from 'primevue/button';

const props = defineProps({
    activity: Object,
});

const getImageUrl = (path) => path ? `/storage/${path}` : null;

const shareArticle = () => {
    if (navigator.share) {
        navigator.share({
            title: props.activity.title,
            text: props.activity.excerpt || `Baca kegiatan terbaru PKK Umbulharjo: ${props.activity.title}`,
            url: window.location.href,
        }).catch(console.error);
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="activity.title" />

        <article class="py-12 bg-white dark:bg-slate-900 min-h-screen">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Back Navigation -->
                <div class="mb-8">
                    <Link :href="route('kegiatan')">
                        <Button text class="!px-0 !text-slate-500 hover:!text-slate-900 dark:hover:!text-white group">
                            <ArrowLeft class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" /> 
                            <span class="font-medium">Kembali ke Kegiatan Terbaru</span>
                        </Button>
                    </Link>
                </div>

                <!-- Article Header -->
                <header class="mb-10 text-center sm:text-left">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-6">
                        {{ activity.title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 sm:gap-6 text-sm font-medium text-slate-500 dark:text-slate-400">
                        <div v-if="activity.date" class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-full">
                            <Calendar class="w-4 h-4 text-sky-500" />
                            {{ new Date(activity.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                        </div>
                        <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-full">
                            <Eye class="w-4 h-4 text-emerald-500" />
                            {{ activity.views }} x dibaca
                        </div>
                        <Button @click="shareArticle" rounded outlined size="small" class="!w-8 !h-8 !p-0 ml-auto sm:ml-0" v-tooltip.top="'Bagikan'">
                            <Share2 class="w-3.5 h-3.5" />
                        </Button>
                    </div>
                </header>

                <!-- Cover Image (If Any) -->
                <div v-if="activity.cover_image" class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-slate-100 dark:border-slate-800 aspect-video">
                    <img 
                        :src="getImageUrl(activity.cover_image)" 
                        :alt="activity.title"
                        class="w-full h-full object-cover"
                    />
                </div>

                <!-- Article Content -->
                <div class="prose prose-lg dark:prose-invert prose-sky max-w-none prose-img:rounded-xl prose-img:shadow-md">
                    <div v-if="activity.content" v-html="activity.content"></div>
                    <div v-else class="text-center italic text-slate-500 my-12">
                        Belum ada konten artikel untuk kegiatan ini.
                    </div>
                </div>

            </div>
        </article>
    </AppLayout>
</template>
