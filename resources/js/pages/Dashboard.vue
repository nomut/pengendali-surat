<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Users, FileText } from 'lucide-vue-next';

const props = defineProps({
    stats: Object,
    auth: Object,
});

const breadcrumbs = [{ label: 'Dashboard' }];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <InertiaHead title="Dashboard" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <Card>
                <template #content>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-muted-color">Total Pengguna</p>
                            <p class="text-2xl font-bold">{{ stats.total_users }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <Users class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <Card>
            <template #content>
                <div class="text-center py-12">
                    <FileText class="w-12 h-12 text-muted-color mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">Selamat Datang di Dashboard</h3>
                    <p class="text-muted-color">Kelola konten halaman website melalui menu CMS.</p>
                </div>
            </template>
        </Card>
    </AppLayout>
</template>