<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import Divider from 'primevue/divider'; // Komponen ini seharusnya ada
// Impor Ikon dari Lucide (disamakan dengan patokan Anda)
import { FileEdit, ArrowLeft, User, Hash, Calendar, Paperclip, FileText } from 'lucide-vue-next';

const props = defineProps({
    surat: Object,
});

const breadcrumbs = [
    { label: 'Dashboard', route: route('dashboard') },
    { label: 'Surat Keluar', route: route('surat-keluar.index') }, // Diubah
    { label: 'Detail Surat' }
];

// Fungsi format tanggal (sama persis dengan patokan Anda)
const formatDate = (value) => {
    if (!value) return '-';
    return new Date(value).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric'
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead :title="`Detail Surat: ${surat.nomor_surat}`" />

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <div class="lg:col-span-3">
                <Card class="h-full">
                    <template #content>
                        <div class="flex flex-col gap-8">
                            
                            <div class="flex flex-col gap-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="flex items-center gap-3">
                                        <User class="w-5 h-5 text-slate-400 flex-shrink-0" />
                                        <div>
                                            <span class="block text-sm text-slate-500">Tujuan</span>
                                            <span class="font-semibold text-base">{{ surat.tujuan }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <Hash class="w-5 h-5 text-slate-400 flex-shrink-0" />
                                        <div>
                                            <span class="block text-sm text-slate-500">Nomor Surat</span>
                                            <span class="font-semibold text-base">{{ surat.nomor_surat }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <Calendar class="w-5 h-5 text-slate-400 flex-shrink-0" />
                                        <div>
                                            <span class="block text-sm text-slate-500">Tanggal Surat</span>
                                            <span class="font-semibold text-base">{{ formatDate(surat.tanggal_surat) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <Divider />
                            
                            <div>
                                <h4 class="font-semibold text-lg text-slate-800 dark:text-slate-200 mb-4">Perihal</h4>
                                <div class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ surat.perihal }}</div>
                            </div>

                            <div>
                                <h4 class="font-semibold text-lg text-slate-800 dark:text-slate-200 mb-4">Tembusan</h4>
                                <div class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ surat.tembusan || '-' }}</div>
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-lg text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2"><Paperclip class="w-5 h-5" /><span>Lampiran</span></h4>
                                <div v-if="surat.files && surat.files.length > 0">
                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                        <div v-for="file in surat.files" :key="file.id" class="relative group rounded-lg shadow-sm overflow-hidden transition-shadow hover:shadow-lg">
                                            <a :href="file.url" target="_blank" class="block w-full aspect-square flex items-center justify-center bg-slate-100 dark:bg-slate-700">
                                                <img v-if="file.mime_type.includes('image')" :src="file.preview_url" :alt="file.original_name" class="w-full h-full object-cover">
                                                <i v-else-if="file.mime_type.includes('pdf')" class="pi pi-file-pdf text-red-500 text-5xl"></i>
                                                <i v-else-if="file.mime_type.includes('word')" class="pi pi-file-word text-blue-500 text-5xl"></i>
                                                <i v-else class="pi pi-file text-slate-500 text-5xl"></i>
                                            </a>
                                            <div class="p-2 bg-white dark:bg-slate-800 text-center">
                                                <p class="font-medium text-xs text-slate-800 dark:text-slate-200 truncate" :title="file.original_name">
                                                    {{ file.original_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>

            <div class="lg:col-span-1">
                <Card class="h-full">
                    <template #title>
                        <h3 class="text-lg font-semibold">Detail Pencatatan</h3>
                    </template>
                    <template #content>
                         <div class="flex flex-col gap-4">
                            <div>
                                 <h4 class="font-semibold text-sm mb-2 text-slate-800 dark:text-slate-200">Tags / Label</h4>
                                 <div v-if="surat.tags && surat.tags.length" class="flex flex-wrap gap-2">
                                    <Tag v-for="tag in surat.tags" :key="tag.id" :value="tag.name.en" severity="info" rounded></Tag>
                                </div>
                                <p v-else class="text-sm text-muted-color italic">Tidak ada tag.</p>
                            </div>
                        </div>
                    </template>
                    <template #footer>
                        <div class="flex flex-col gap-3 pt-4">
                            <Link :href="route('surat-keluar.edit', surat.id)">
                                <Button label="Edit Surat" class="w-full">
                                    <template #icon><FileEdit class="w-4 h-4 mr-2" /></template>
                                </Button>
                            </Link>
                            <Link :href="route('surat-keluar.index')">
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