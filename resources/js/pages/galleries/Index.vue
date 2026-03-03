<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import InputGroup from 'primevue/inputgroup';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import Badge from 'primevue/badge';
import { Search, Plus, Edit2, Trash2 } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import Card from 'primevue/card';

const props = defineProps({
    galleries: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

let debounceTimeout = null;
watch(search, (value) => {
    if (debounceTimeout) clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        router.get(
            route('galleries.index'),
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300);
});

const getImageUrl = (path) => path ? `/storage/${path}` : null;

// Extractor for cover image
const getCoverImage = (images) => {
    if (!images || !Array.isArray(images) || images.length === 0) return null;
    return getImageUrl(images[0]);
};

// Form for deletion
const deleteForm = useForm({});
const deleteGallery = (gallery) => {
    if (confirm('Apakah Anda yakin ingin menghapus galeri ini?')) {
        deleteForm.delete(route('galleries.destroy', gallery.id), {
            preserveScroll: true,
        });
    }
};

const onPageChange = (event) => {
    const page = event.page + 1; // PrimeVue is 0-indexed, Laravel is 1-indexed
    router.get(
        route('galleries.index'),
        { search: search.value, page: page },
        { preserveState: true }
    );
};
</script>

<template>
    <AppLayout>
        <InertiaHead title="Manajemen Galeri Kegiatan" />

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                Manajemen Galeri
            </h2>
            <Link :href="route('galleries.create')">
                <Button>
                    <Plus class="w-4 h-4 mr-2" /> Tambah Galeri
                </Button>
            </Link>
        </div>

        <Card>
            <template #content>
            <div class="flex justify-end mb-6">
                <span class="p-input-icon-left w-full sm:w-96 relative">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5" />
                    <InputText v-model="search" placeholder="Cari galeri..." class="w-full pl-10" />
                </span>
            </div>

            <DataTable 
                :value="galleries.data" 
                dataKey="id"
                stripedRows 
                class="p-datatable-sm"
                :lazy="true"
                :paginator="true"
                :rows="galleries.per_page"
                :totalRecords="galleries.total"
                @page="onPageChange"
                :first="(galleries.current_page - 1) * galleries.per_page"
            >
                <template #empty>
                    <div class="text-center p-4 text-slate-500">
                        Tidak ada galeri yang ditemukan.
                    </div>
                </template>

                <Column header="Cover" style="width: 100px">
                    <template #body="{ data }">
                        <img 
                            v-if="getCoverImage(data.images)" 
                            :src="getCoverImage(data.images)" 
                            alt="Cover" 
                            class="w-16 h-12 object-cover rounded-md border border-slate-200"
                        />
                        <div v-else class="w-16 h-12 bg-slate-100 rounded-md border border-slate-200 flex items-center justify-center text-xs text-slate-400">
                            No Image
                        </div>
                    </template>
                </Column>

                <Column field="title" header="Judul Kegiatan" class="font-medium"></Column>
                
                <Column field="date" header="Tanggal" style="width: 15%">
                    <template #body="{ data }">
                        {{ data.date ? new Date(data.date).toLocaleDateString('id-ID', { year:'numeric', month:'long', day:'numeric' }) : '-' }}
                    </template>
                </Column>

                <Column header="Status" style="width: 10%">
                    <template #body="{ data }">
                        <Tag :severity="data.is_published ? 'success' : 'warning'" :value="data.is_published ? 'Publik' : 'Draft'" />
                    </template>
                </Column>

                <Column header="Foto" style="width: 10%" class="text-center">
                    <template #body="{ data }">
                        <Badge :value="Array.isArray(data.images) ? data.images.length : 0" severity="info" class="!bg-sky-100 !text-sky-700 font-bold" />
                    </template>
                </Column>

                <Column :exportable="false" style="min-width:8rem" alignFrozen="right" :frozen="true">
                    <template #body="{ data }">
                        <div class="flex gap-2 justify-end">
                            <Link :href="route('galleries.edit', data.id)">
                                <Button outlined rounded size="small" class="!w-8 !h-8 !p-0" v-tooltip.top="'Edit'">
                                    <Edit2 class="w-4 h-4" />
                                </Button>
                            </Link>
                            <Button @click="deleteGallery(data)" outlined rounded severity="danger" size="small" class="!w-8 !h-8 !p-0" v-tooltip.top="'Hapus'">
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </div>
                    </template>
                </Column>
            </DataTable>
            </template>
        </Card>
    </AppLayout>
</template>
