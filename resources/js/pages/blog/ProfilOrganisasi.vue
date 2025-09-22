<script setup>
import AppLayout from '@/layouts-blog/AppLayout.vue';
import { ref } from 'vue';
import { Target, ClipboardCheck } from 'lucide-vue-next';

// Impor komponen OrganizationChart dari PrimeVue
import OrganizationChart from 'primevue/organizationchart';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

// --- DATA BARU UNTUK ORGANIZATION CHART ---
const chartData = ref({
    key: '0',
    type: 'person',
    styleClass: 'bg-sky-500 text-white border-sky-700', // Root node style
    data: {
        image: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961&auto=format&fit=crop',
        name: 'Nama Ketua',
        title: 'Ketua Umum'
    },
    children: [
        {
            key: '0_0',
            type: 'person',
            styleClass: 'bg-sky-200 text-sky-900 border-sky-400',
            data: {
                image: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=1887&auto=format&fit=crop',
                name: 'Nama Wakil Ketua',
                title: 'Wakil Ketua'
            },
            children: [
                {
                    key: '0_0_0',
                    type: 'department',
                    styleClass: 'bg-slate-100 text-slate-700 border-slate-300',
                    label: 'Seksi Pendidikan',
                },
                {
                    key: '0_0_1',
                    type: 'department',
                    styleClass: 'bg-slate-100 text-slate-700 border-slate-300',
                    label: 'Seksi Ekonomi',
                }
            ]
        },
        {
            key: '0_1',
            type: 'person',
            styleClass: 'bg-sky-200 text-sky-900 border-sky-400',
            data: {
                image: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=1888&auto=format&fit=crop',
                name: 'Nama Sekretaris',
                title: 'Sekretaris'
            },
            children: [
                {
                    key: '0_1_0',
                    type: 'department',
                    styleClass: 'bg-slate-100 text-slate-700 border-slate-300',
                    label: 'Seksi Sosial Budaya',
                }
            ]
        },
        {
            key: '0_2',
            type: 'person',
            styleClass: 'bg-sky-200 text-sky-900 border-sky-400',
            data: {
                image: 'https://images.unsplash.com/photo-1554151228-14d9def656e4?q=80&w=1886&auto=format&fit=crop',
                name: 'Nama Bendahara',
                title: 'Bendahara'
            },
             children: [
                {
                    key: '0_2_0',
                    type: 'department',
                    styleClass: 'bg-slate-100 text-slate-700 border-slate-300',
                    label: 'Seksi Lingkungan',
                }
            ]
        }
    ]
});

// Data lain yang sudah ada di file Anda
const galeriKegiatan = ref([
    { src: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop', alt: 'Kegiatan Pelatihan' },
    { src: 'https://images.unsplash.com/photo-1576267423445-b2e0074d68a4?q=80&w=2070&auto=format&fit=crop', alt: 'Diskusi Kelompok' },
    { src: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop', alt: 'Rapat Organisasi' },
    { src: 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1932&auto=format&fit=crop', alt: 'Kolaborasi dengan Mitra' },
    { src: 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=2070&auto=format&fit=crop', alt: 'Workshop Teknologi' },
    { src: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop', alt: 'Kegiatan Luar Ruangan' }
]);

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
    <InertiaHead title="Profil Organisasi" />

    <AppLayout
        :can-login="canLogin" 
        :can-register="canRegister"
        :laravel-version="laravelVersion"
        :php-version="phpVersion"
    >
        <main>
            <section class="py-24 md:py-32 text-center bg-white/30">
                <div v-animate-on-scroll class="animate-on-scroll container mx-auto px-4 sm:px-6">
                    <h1 class="text-4xl md:text-6xl font-bold text-slate-900 leading-tight tracking-tighter mb-4">
                        Tentang Kami
                    </h1>
                    <p class="text-lg text-slate-600 max-w-3xl mx-auto">
                        Mengenal lebih dekat Gerakan Pemberdayaan dan Kesejahteraan Keluarga (PKK) di Daerah Istimewa Yogyakarta.
                    </p>
                </div>
            </section>

            <section class="py-20 sm:py-24">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                        <div v-animate-on-scroll class="animate-on-scroll">
                            <h2 class="text-3xl font-bold text-slate-800 mb-4">Sejarah Singkat</h2>
                            <p class="text-slate-600 space-y-4">
                                Gerakan Pemberdayaan dan Kesejahteraan Keluarga (PKK) sebagai gerakan pembangunan masyarakat bermula dari seminar Home Economic di Bogor pada tahun 1957. Sebagai tindak lanjut dari seminar tersebut, pada tahun 1961 panitia penyusunan tata susunan pelajaran pada Pendidikan Kesejahteraan Keluarga (PKK) Kementerian Pendidikan.
                                <br><br>
                                Di Daerah Istimewa Yogyakarta, gerakan ini telah menjadi tulang punggung dalam upaya peningkatan kualitas hidup keluarga, adaptif terhadap perubahan zaman, dan terus berinovasi untuk memberdayakan perempuan dan masyarakat secara luas.
                            </p>
                        </div>
                        <div v-animate-on-scroll class="animate-on-scroll w-full h-80 rounded-2xl p-2 frosted-glass-card" style="transition-delay: 200ms">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Gedung bersejarah di Yogyakarta" class="w-full h-full object-cover rounded-xl shadow-lg">
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 sm:py-24 bg-white/50">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 text-center">
                            <div class="inline-flex p-4 bg-sky-100 rounded-full mb-4">
                                <Target class="w-8 h-8 text-sky-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800 mb-2">Visi</h2>
                            <p class="text-slate-600">Terwujudnya keluarga yang beriman dan bertaqwa kepada Tuhan Yang Maha Esa, berakhlak mulia dan berbudi luhur, sehat sejahtera, maju dan mandiri, kesetaraan dan keadilan gender serta kesadaran hukum dan lingkungan.</p>
                        </div>
                        <div v-animate-on-scroll class="animate-on-scroll frosted-glass-card rounded-2xl p-8 text-center" style="transition-delay: 200ms">
                            <div class="inline-flex p-4 bg-sky-100 rounded-full mb-4">
                                <ClipboardCheck class="w-8 h-8 text-sky-600" />
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800 mb-2">Misi</h2>
                            <p class="text-slate-600">Meningkatkan kualitas sumber daya manusia, memperkuat ketahanan ekonomi keluarga, serta melestarikan lingkungan hidup sambil meningkatkan kesadaran hukum dan partisipasi masyarakat.</p>
                        </div>
                    </div>
                </div>
            </section>

             <section class="py-20 sm:py-24">
                <div class="container mx-auto px-4 sm:px-6">
                    <div v-animate-on-scroll class="text-center mb-16 animate-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Struktur Organisasi</h2>
                        <p class="mt-4 text-lg text-slate-600">Tim penggerak di balik layar program-program kami.</p>
                    </div>
                    
                    <OrganizationChart :value="chartData" collapsible>
                        <template #person="slotProps">
                            <div class="flex flex-col items-center p-4">
                                <img :src="slotProps.node.data.image" :alt="slotProps.node.data.name" class="w-24 h-24 rounded-full mb-2 object-cover shadow-lg">
                                <span class="font-bold text-slate-800">{{ slotProps.node.data.name }}</span>
                                <span class="text-sky-600 text-sm">{{ slotProps.node.data.title }}</span>
                            </div>
                        </template>
                        <template #department="slotProps">
                            <div class="p-4 bg-opacity-50">
                                <span class="font-semibold text-slate-700">{{ slotProps.node.label }}</span>
                            </div>
                        </template>
                    </OrganizationChart>
                </div>
            </section>

            <section class="py-20 sm:py-24 bg-white/50">
                <div class="container mx-auto px-4 sm:px-6">
                    <div v-animate-on-scroll class="text-center mb-16 animate-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Galeri Kegiatan</h2>
                        <p class="mt-4 text-lg text-slate-600">Momen-momen berharga dari berbagai program kami.</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div v-for="(foto, index) in galeriKegiatan" :key="foto.src" v-animate-on-scroll class="animate-on-scroll" :style="{ 'transition-delay': `${index * 50}ms` }">
                            <div class="frosted-glass-card rounded-xl p-2 aspect-w-4 aspect-h-3">
                                <img :src="foto.src" :alt="foto.alt" class="w-full h-full object-cover rounded-lg shadow-md">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>

<style>
/* Style Kustom untuk Organization Chart agar sesuai tema */
.p-organizationchart-node-content {
    border-radius: 0.75rem; /* rounded-xl */
    border-width: 1px;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
}

.p-organizationchart .p-node-toggler {
    color: #0ea5e9 !important; /* sky-500 */
}

.p-organizationchart-line {
    background-color: #cbd5e1 !important; /* slate-300 */
}
</style>