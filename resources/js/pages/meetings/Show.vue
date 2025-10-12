<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';

// Impor Ikon dari Lucide
import { FileEdit, ArrowLeft, Users, Calendar, Clock, MapPin, FileText, User } from 'lucide-vue-next';

const props = defineProps({
    meeting: Object, // Menerima data rapat dari controller
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Rapat', route: route('meetings.index') },
    { label: 'Detail Rapat' }
];

// Helper untuk format tanggal saja
const formatDate = (value) => {
    if (!value) return '-';
    return new Date(value).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric'
    });
};

// Helper untuk format waktu saja
const formatTime = (value) => {
    if (!value) return '-';
    return new Date(value).toLocaleTimeString('id-ID', {
        hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta'
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Detail Rapat: ${meeting.title}`" />

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <div class="lg:col-span-3">
                <Card class="h-full">
                    <template #content>
                        <div class="flex flex-col gap-8">
                            
                            <div class="flex flex-col gap-4">
                                <div class="pb-4 border-b border-slate-200 dark:border-slate-700">
                                    <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200">{{ meeting.title }}</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center gap-3">
                                        <Calendar class="w-5 h-5 text-slate-400 flex-shrink-0" />
                                        <div class="text-sm">
                                            <span class="block text-slate-500 dark:text-slate-400">Tanggal</span>
                                            <span class="font-semibold text-base">{{ formatDate(meeting.starts_at) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <Clock class="w-5 h-5 text-slate-400 flex-shrink-0" />
                                        <div class="text-sm">
                                            <span class="block text-slate-500 dark:text-slate-400">Waktu</span>
                                            <span class="font-semibold text-base">{{ formatTime(meeting.starts_at) }} - {{ meeting.ends_at ? formatTime(meeting.ends_at) : 'Selesai' }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <MapPin class="w-5 h-5 text-slate-400 flex-shrink-0" />
                                        <div class="text-sm">
                                            <span class="block text-slate-500 dark:text-slate-400">Lokasi</span>
                                            <span class="font-semibold text-base">{{ meeting.location }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="">
                                <h4 class="font-semibold text-lg text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                                    <FileText class="w-5 h-5" />
                                    <span>Notulensi</span>
                                </h4>
                                <div v-if="meeting.minutes" class="prose prose-sm dark:prose-invert max-w-none whitespace-pre-wrap">
                                    {{ meeting.minutes }}
                                </div>
                                <p v-else class="text-sm text-muted-color italic">Notulensi belum ditambahkan.</p>
                            </div>

                            <div class="border-t border-slate-200 dark:border-slate-700 pt-6 mt-8">
                                <h4 class="font-semibold text-lg text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                                    <Users class="w-5 h-5" />
                                    <span>Peserta Rapat</span>
                                </h4>
                                <div v-if="meeting.person && meeting.person.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    <div v-for="person in meeting.person" :key="person.id" class="text-sm p-3 bg-slate-50 dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                                        <p class="font-semibold capitalize">{{ person.name.toLowerCase() }}</p>
                                        <p class="text-xs text-muted-color">{{ person.position || person.office }}</p>
                                    </div>
                                </div>
                                <p v-else class="text-sm text-muted-color italic">Tidak ada daftar peserta.</p>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>

            <div class="lg:col-span-1">
                <Card class="h-full">
                    <template #title>
                    </template>
                    <template #footer>
                        <div class="flex flex-col gap-3 pt-4">
                            <Link :href="route('meetings.edit', meeting.id)">
                                <Button label="Edit Rapat" class="w-full">
                                    <template #icon><FileEdit class="w-4 h-4 mr-2" /></template>
                                </Button>
                            </Link>
                            <Link :href="route('meetings.index')">
                                <Button label="Kembali" severity="secondary" outlined class="w-full">
                                     <template #icon><ArrowLeft class="w-4 h-4 mr-2" /></template>
                                </Button>
                            </Link>
                        </div>
                    </template>
                </Card>
            </div>

        </div>
    </AppLayout>
</template>