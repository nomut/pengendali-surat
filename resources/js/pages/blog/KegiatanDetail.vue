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

        <article class="py-12 min-h-screen">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Back Navigation -->
                <div class="mb-8">
                    <Link :href="route('kegiatan')">
                        <Button text class="!px-0 !text-slate-500 hover:!text-slate-900 group">
                            <ArrowLeft class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" /> 
                            <span class="font-medium">Kembali ke Kegiatan Terbaru</span>
                        </Button>
                    </Link>
                </div>

                <div class="frosted-glass-card rounded-2xl p-6 sm:p-8 md:p-10">
                <!-- Article Header -->
                <header class="mb-10 text-center sm:text-left">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">
                        {{ activity.title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 sm:gap-6 text-sm font-medium text-slate-500">
                        <div v-if="activity.date" class="flex items-center gap-2 bg-slate-100 px-3 py-1.5 rounded-full">
                            <Calendar class="w-4 h-4 text-sky-500" />
                            {{ new Date(activity.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                        </div>
                        <div class="flex items-center gap-2 bg-slate-100 px-3 py-1.5 rounded-full">
                            <Eye class="w-4 h-4 text-emerald-500" />
                            {{ activity.views }} x dibaca
                        </div>
                        <Button @click="shareArticle" rounded outlined size="small" class="!w-8 !h-8 !p-0 ml-auto sm:ml-0" v-tooltip.top="'Bagikan'">
                            <Share2 class="w-3.5 h-3.5" />
                        </Button>
                    </div>
                </header>

                <!-- Cover Image (If Any) -->
                <div v-if="activity.cover_image" class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-slate-100 aspect-video">
                    <img 
                        :src="getImageUrl(activity.cover_image)" 
                        :alt="activity.title"
                        class="w-full h-full object-cover"
                    />
                </div>

                <!-- Article Content -->
                <div class="prose prose-lg prose-sky max-w-none wrap-break-word prose-img:rounded-xl prose-img:shadow-md prose-headings:wrap-break-word prose-p:wrap-break-word">
                    <div v-if="activity.content" v-html="activity.content"></div>
                    <div v-else class="text-center italic text-slate-500 my-12">
                        Belum ada konten artikel untuk kegiatan ini.
                    </div>
                </div>
                </div>

            </div>
        </article>
    </AppLayout>
</template>
