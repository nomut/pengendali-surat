<script setup>
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import { Plus, Trash, Upload, X } from 'lucide-vue-next';
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
    }
});

const emit = defineEmits(['update:modelValue']);
const toast = useToast();
const isUploading = ref(false);

// Pastikan data kelompok_kerja selalu berupa array
const initKelompokKerja = () => {
    if (!props.modelValue || !props.modelValue.kelompok_kerja) {
        return [];
    }
    return props.modelValue.kelompok_kerja;
};

const updateItem = (index, field, value) => {
    const newItems = [...initKelompokKerja()];
    newItems[index] = { ...newItems[index], [field]: value };
    emit('update:modelValue', { ...props.modelValue, kelompok_kerja: newItems });
};

const addItem = () => {
    const newItems = [...initKelompokKerja(), { title: '', description: '' }];
    emit('update:modelValue', { ...props.modelValue, kelompok_kerja: newItems });
};

const removeItem = (index) => {
    const newItems = initKelompokKerja().filter((_, i) => i !== index);
    emit('update:modelValue', { ...props.modelValue, kelompok_kerja: newItems });
};

const onFileSelect = async (event, index) => {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    isUploading.value = true;
    try {
        const response = await axios.post(route('files.store'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        
        updateItem(index, 'foto_path', response.data.path);
        toast.add({ severity: 'success', summary: 'Sukses', detail: 'Foto berhasil diunggah', life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal mengunggah foto', life: 3000 });
        console.error(err);
    } finally {
        isUploading.value = false;
        event.target.value = '';
    }
};

const removeFoto = (index) => {
    const newItems = [...initKelompokKerja()];
    delete newItems[index].foto_path;
    emit('update:modelValue', { ...props.modelValue, kelompok_kerja: newItems });
};

const getImageUrl = (path) => {
    if (!path) return null;
    return `/storage/${path}`;
};
</script>

<template>
    <div>
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-semibold text-slate-800">Daftar Kelompok Kerja</h4>
            <Button @click="addItem" size="small" class="p-button-outlined">
                <Plus class="w-4 h-4 mr-2" /> Tambah Kelompok Kerja
            </Button>
        </div>

        <div v-if="initKelompokKerja().length === 0" class="text-center p-6 bg-slate-50 rounded-lg text-slate-500 border border-slate-200">
            Belum ada kelompok kerja.
        </div>

        <div class="space-y-4">
            <div v-for="(item, index) in initKelompokKerja()" :key="index" class="p-4 border border-slate-200 rounded-lg bg-slate-50 relative group">
                <Button 
                    @click="removeItem(index)" 
                    severity="danger" 
                    text 
                    rounded 
                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                    v-tooltip.top="'Hapus'"
                >
                    <Trash class="w-4 h-4" />
                </Button>
                
                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- IMAGE UPLOAD -->
                    <div class="flex flex-col items-center gap-2">
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Gambar</label>
                        <div class="w-32 h-24 bg-slate-200 rounded-lg overflow-hidden border border-slate-300 flex items-center justify-center relative group shrink-0 shadow-inner">
                            <img v-if="item.foto_path" :src="getImageUrl(item.foto_path)" class="w-full h-full object-cover" />
                            <span v-else class="text-slate-400 text-sm">Upload</span>
                            
                            <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                <Upload class="w-5 h-5" />
                                <input type="file" class="hidden" accept="image/*" @change="e => onFileSelect(e, index)" />
                            </label>
                        </div>
                        <Button v-if="item.foto_path" @click="removeFoto(index)" size="small" text severity="danger" class="p-0 text-xs">Hapus Gambar</Button>
                    </div>

                    <!-- DATA -->
                    <div class="flex-1 flex flex-col gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Judul</label>
                            <InputText 
                                :model-value="item.title"
                                @update:model-value="(val) => updateItem(index, 'title', val)"
                                class="w-full" 
                                placeholder="Contoh: Pembinaan Karakter Keluarga" 
                            />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Deskripsi</label>
                            <Textarea 
                                :model-value="item.description"
                                @update:model-value="(val) => updateItem(index, 'description', val)"
                                class="w-full" 
                                rows="3" 
                                placeholder="Penjelasan deskripsi kelompok kerja..." 
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
