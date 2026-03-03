<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { Calendar, Eye, ArrowRight } from 'lucide-vue-next';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Paginator from 'primevue/paginator';

const props = defineProps({
    activities: Object,
});

const getImageUrl = (path) => path ? `/storage/${path}` : null;

const onPageChange = (event) => {
    const page = event.page + 1;
    router.visit(route('kegiatan', { page }), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Kegiatan" />

        <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                        Kegiatan
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400">
                        Berita dan dokumentasi kegiatan terkini.
                    </p>
                </div>

                <div v-if="activities.data.length === 0" class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 mb-4">
                        <Calendar class="w-8 h-8" />
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Belum ada kegiatan</h3>
                    <p class="text-slate-500">Kegiatan akan segera dipublikasikan di sini.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article 
                        v-for="activity in activities.data" 
                        :key="activity.id"
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-slate-100 dark:border-slate-700 hover:-translate-y-1"
                    >
                        <!-- Cover Image -->
                        <Link :href="route('kegiatan.show', activity.slug)" class="block relative aspect-[16/9] overflow-hidden bg-slate-100 dark:bg-slate-900">
                            <img 
                                v-if="activity.cover_image"
                                :src="getImageUrl(activity.cover_image)" 
                                :alt="activity.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            />
                            <div v-else class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                <Calendar class="w-10 h-10 mb-2 opacity-50" />
                                <span class="text-sm font-medium">PKK Umbulharjo</span>
                            </div>
                            
                            <!-- Date Badge -->
                            <div v-if="activity.date" class="absolute top-4 left-4 bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm font-medium text-sm text-sky-700 dark:text-sky-400 border border-white/20">
                                {{ new Date(activity.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                            </div>
                        </Link>

                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center gap-4 text-xs font-medium text-slate-500 mb-3">
                                <span class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-700/50 px-2 py-1 rounded-md">
                                    <Eye class="w-3.5 h-3.5" /> {{ activity.views }} x dibaca
                                </span>
                            </div>

                            <Link :href="route('kegiatan.show', activity.slug)" class="block mb-3">
                                <h2 class="text-xl font-bold text-slate-900 dark:text-white leading-tight group-hover:text-blue-600 dark:group-hover:text-sky-400 transition-colors line-clamp-2">
                                    {{ activity.title }}
                                </h2>
                            </Link>

                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6 line-clamp-3 flex-grow">
                                {{ activity.excerpt || (activity.content ? activity.content.replace(/<[^>]*>?/gm, '').substring(0, 120) + '...' : 'Tidak ada ringkasan.') }}
                            </p>

                            <Link :href="route('kegiatan.show', activity.slug)" class="mt-auto">
                                <Button link class="!px-0 !py-0 w-full justify-between group/btn text-blue-600 dark:text-sky-400 hover:text-blue-700 dark:hover:text-sky-300">
                                    <span class="font-semibold">Baca Selengkapnya</span>
                                    <ArrowRight class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" />
                                </Button>
                            </Link>
                        </div>
                    </article>
                </div>

                <!-- Pagination -->
                <div v-if="activities.total > activities.per_page" class="mt-12 flex justify-center pb-8">
                    <Paginator 
                        :rows="activities.per_page" 
                        :totalRecords="activities.total" 
                        :first="(activities.current_page - 1) * activities.per_page"
                        @page="onPageChange"
                        class="!bg-transparent"
                    />
                </div>

            </div>
        </div>
    </AppLayout>
</template>
