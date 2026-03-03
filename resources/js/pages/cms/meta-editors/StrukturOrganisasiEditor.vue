<script setup>
import { ref } from 'vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { Plus, Trash, Upload, X } from 'lucide-vue-next';
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

const updateSection = (sectionKey, newArray) => {
    emit('update:modelValue', { ...props.modelValue, [sectionKey]: newArray });
};

// Generic Add/Remove for arrays
const addItem = (sectionKey, defaultItem = {}) => {
    const current = props.modelValue[sectionKey] || [];
    updateSection(sectionKey, [...current, { ...defaultItem }]);
};

const removeItem = (sectionKey, index) => {
    const current = [...(props.modelValue[sectionKey] || [])];
    current.splice(index, 1);
    updateSection(sectionKey, current);
};

// Add/Remove for Nested Pokja Anggota
const addAnggota = (pokjaIndex) => {
    const pokjaList = [...(props.modelValue.pokja || [])];
    if (!pokjaList[pokjaIndex].anggota) pokjaList[pokjaIndex].anggota = [];
    pokjaList[pokjaIndex].anggota.push({ nama: '', jabatan: '' });
    updateSection('pokja', pokjaList);
};

const removeAnggota = (pokjaIndex, anggotaIndex) => {
    const pokjaList = [...(props.modelValue.pokja || [])];
    pokjaList[pokjaIndex].anggota.splice(anggotaIndex, 1);
    updateSection('pokja', pokjaList);
};


/** 
 * Handle Image Upload 
 * @param {Event} event
 * @param {Array} list - Reference to the array containing the item
 * @param {Number} index - Index of the item in the list
 * @param {String} sectionKey - The key in modelValue to trigger reactivity update
 */
const onFileSelect = async (event, list, index, sectionKey, isNested = false, parentIndex = null) => {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    isUploading.value = true;
    try {
        // Use global axios from bootstrap.js
        const response = await axios.post(route('files.store'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        
        // Update the item safely
        const updatedList = [...list];
        updatedList[index] = { ...updatedList[index], foto_path: response.data.path };

        if (isNested && parentIndex !== null && sectionKey === 'pokja') {
            const pokjaList = [...(props.modelValue.pokja || [])];
            pokjaList[parentIndex].anggota = updatedList;
            updateSection(sectionKey, pokjaList);
        } else {
            updateSection(sectionKey, updatedList);
        }

        toast.add({ severity: 'success', summary: 'Sukses', detail: 'Foto berhasil diunggah', life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Gagal', detail: 'Gagal mengunggah foto', life: 3000 });
        console.error(err);
    } finally {
        isUploading.value = false;
        // Reset file input
        event.target.value = '';
    }
};

const removeFoto = (list, index, sectionKey, isNested = false, parentIndex = null) => {
    const updatedList = [...list];
    delete updatedList[index].foto_path;
    
    if (isNested && parentIndex !== null && sectionKey === 'pokja') {
        const pokjaList = [...(props.modelValue.pokja || [])];
        pokjaList[parentIndex].anggota = updatedList;
        updateSection(sectionKey, pokjaList);
    } else {
        updateSection(sectionKey, updatedList);
    }
};

const getImageUrl = (path) => {
    if (!path) return null;
    return `/storage/${path}`;
};

</script>

<template>
    <div class="space-y-12">
        <!-- KETUA & WAKIL -->
        <section>
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h4 class="text-lg font-bold text-slate-800">Ketua & Wakil</h4>
                <Button @click="addItem('ketua_dan_wakil', {nama: '', jabatan: ''})" size="small" outlined>
                    <Plus class="w-4 h-4 mr-2" /> Tambah
                </Button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div v-for="(person, idx) in (modelValue.ketua_dan_wakil || [])" :key="'kw'+idx" class="p-4 bg-slate-50 border rounded-lg relative">
                    <Button @click="removeItem('ketua_dan_wakil', idx)" severity="danger" text rounded class="absolute top-2 right-2 p-2">
                        <X class="w-4 h-4" />
                    </Button>
                    
                    <div class="flex gap-4 items-start">
                        <!-- PHOto UPLOADER -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-20 h-20 bg-slate-200 rounded-full overflow-hidden border border-slate-300 flex items-center justify-center relative group">
                                <img v-if="person.foto_path" :src="getImageUrl(person.foto_path)" class="w-full h-full object-cover" />
                                <span v-else class="text-slate-400 text-sm">Foto</span>
                                
                                <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                    <Upload class="w-5 h-5" />
                                    <input type="file" class="hidden" accept="image/*" @change="e => onFileSelect(e, modelValue.ketua_dan_wakil, idx, 'ketua_dan_wakil')" />
                                </label>
                            </div>
                            <Button v-if="person.foto_path" @click="removeFoto(modelValue.ketua_dan_wakil, idx, 'ketua_dan_wakil')" size="small" text severity="danger" class="p-0 text-xs">Hapus Foto</Button>
                        </div>

                        <!-- DATA -->
                        <div class="flex-1 space-y-3">
                            <div>
                                <label class="text-xs font-semibold text-slate-500 uppercase">Nama Lengkap</label>
                                <InputText v-model="person.nama" class="w-full p-inputtext-sm" @input="updateSection('ketua_dan_wakil', modelValue.ketua_dan_wakil)" />
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 uppercase">Jabatan</label>
                                <InputText v-model="person.jabatan" class="w-full p-inputtext-sm" @input="updateSection('ketua_dan_wakil', modelValue.ketua_dan_wakil)" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PENASEHAT -->
        <section>
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h4 class="text-lg font-bold text-slate-800">Penasehat</h4>
                <Button @click="addItem('penasehat', {nama: ''})" size="small" outlined>
                    <Plus class="w-4 h-4 mr-2" /> Tambah
                </Button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
                <div v-for="(person, idx) in (modelValue.penasehat || [])" :key="'p'+idx" class="p-3 bg-slate-50 rounded border relative flex gap-3">
                    <Button @click="removeItem('penasehat', idx)" severity="danger" text rounded class="absolute top-1 right-1 p-1 h-auto w-auto">
                        <X class="w-3 h-3" />
                    </Button>
                    <div class="flex flex-col items-center gap-1 mt-2">
                        <div class="w-12 h-12 bg-slate-200 rounded-full overflow-hidden flex items-center justify-center relative group">
                            <img v-if="person.foto_path" :src="getImageUrl(person.foto_path)" class="w-full h-full object-cover" />
                            <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                <Upload class="w-3 h-3" />
                                <input type="file" class="hidden" accept="image/*" @change="e => onFileSelect(e, modelValue.penasehat, idx, 'penasehat')" />
                            </label>
                        </div>
                        <span v-if="person.foto_path" @click="removeFoto(modelValue.penasehat, idx, 'penasehat')" class="text-[10px] text-red-500 cursor-pointer hover:underline">Hapus</span>
                    </div>
                    <div class="flex-1 mt-1 mr-4">
                        <InputText v-model="person.nama" class="w-full text-sm p-1 font-bold" placeholder="Nama Penasehat" @input="updateSection('penasehat', modelValue.penasehat)" />
                    </div>
                </div>
            </div>
        </section>

        <!-- BENDAHARA -->
        <section>
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h4 class="text-lg font-bold text-slate-800">Bendahara</h4>
                <Button @click="addItem('bendahara', {nama: ''})" size="small" outlined>
                    <Plus class="w-4 h-4 mr-2" /> Tambah
                </Button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
                <div v-for="(person, idx) in (modelValue.bendahara || [])" :key="'b'+idx" class="p-3 bg-slate-50 rounded border relative flex gap-3">
                    <Button @click="removeItem('bendahara', idx)" severity="danger" text rounded class="absolute top-1 right-1 p-1 h-auto w-auto">
                        <X class="w-3 h-3" />
                    </Button>
                    <div class="flex flex-col items-center gap-1 mt-2">
                        <div class="w-12 h-12 bg-slate-200 rounded-full overflow-hidden flex items-center justify-center relative group">
                            <img v-if="person.foto_path" :src="getImageUrl(person.foto_path)" class="w-full h-full object-cover" />
                            <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                <Upload class="w-3 h-3" />
                                <input type="file" class="hidden" accept="image/*" @change="e => onFileSelect(e, modelValue.bendahara, idx, 'bendahara')" />
                            </label>
                        </div>
                        <span v-if="person.foto_path" @click="removeFoto(modelValue.bendahara, idx, 'bendahara')" class="text-[10px] text-red-500 cursor-pointer hover:underline">Hapus</span>
                    </div>
                    <div class="flex-1 mt-1 mr-4">
                        <InputText v-model="person.nama" class="w-full text-sm p-1 font-bold" placeholder="Nama Bendahara" @input="updateSection('bendahara', modelValue.bendahara)" />
                    </div>
                </div>
            </div>
        </section>

        <!-- SEKERTARIS -->
        <section>
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h4 class="text-lg font-bold text-slate-800">Sekertaris</h4>
                <Button @click="addItem('sekertaris', {nama: '', jabatan: '', sub: ''})" size="small" outlined>
                    <Plus class="w-4 h-4 mr-2" /> Tambah
                </Button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
                <div v-for="(person, idx) in (modelValue.sekertaris || [])" :key="'sek'+idx" class="p-3 bg-slate-50 border rounded-lg relative flex gap-3">
                    <Button @click="removeItem('sekertaris', idx)" severity="danger" text rounded class="absolute top-1 right-1 p-1 h-auto w-auto">
                        <X class="w-3 h-3" />
                    </Button>
                    <div class="flex flex-col items-center gap-1 mt-2">
                        <div class="w-12 h-12 bg-slate-200 rounded-full overflow-hidden flex items-center justify-center relative group">
                            <img v-if="person.foto_path" :src="getImageUrl(person.foto_path)" class="w-full h-full object-cover" />
                            <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                <Upload class="w-3 h-3" />
                                <input type="file" class="hidden" accept="image/*" @change="e => onFileSelect(e, modelValue.sekertaris, idx, 'sekertaris')" />
                            </label>
                        </div>
                        <span v-if="person.foto_path" @click="removeFoto(modelValue.sekertaris, idx, 'sekertaris')" class="text-[10px] text-red-500 cursor-pointer hover:underline">Hapus</span>
                    </div>
                    <div class="flex-1 space-y-2 mt-1 mr-4">
                        <InputText v-model="person.nama" placeholder="Nama" class="w-full text-sm p-1 font-bold" @input="updateSection('sekertaris', modelValue.sekertaris)" />
                        <InputText v-model="person.jabatan" placeholder="Jabatan (cth: SEKRETARIS I)" class="w-full text-xs p-1 text-sky-600" @input="updateSection('sekertaris', modelValue.sekertaris)" />
                        <InputText v-model="person.sub" placeholder="Sub/Bagian" class="w-full text-xs p-1" @input="updateSection('sekertaris', modelValue.sekertaris)" />
                    </div>
                </div>
            </div>
        </section>

        <!-- KETUA BIDANG -->
        <section>
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h4 class="text-lg font-bold text-slate-800">Ketua Bidang</h4>
                <Button @click="addItem('ketua_bidang', {nama: '', jabatan: '', sub: ''})" size="small" outlined>
                    <Plus class="w-4 h-4 mr-2" /> Tambah
                </Button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
                <div v-for="(person, idx) in (modelValue.ketua_bidang || [])" :key="'kb'+idx" class="p-3 bg-sky-50 border border-sky-100 rounded-lg relative flex gap-3">
                    <Button @click="removeItem('ketua_bidang', idx)" severity="danger" text rounded class="absolute top-1 right-1 p-1 h-auto w-auto">
                        <X class="w-3 h-3" />
                    </Button>
                    <div class="flex flex-col items-center gap-1 mt-2">
                        <div class="w-12 h-12 bg-slate-200 rounded-full overflow-hidden flex items-center justify-center relative group">
                            <img v-if="person.foto_path" :src="getImageUrl(person.foto_path)" class="w-full h-full object-cover" />
                            <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                <Upload class="w-3 h-3" />
                                <input type="file" class="hidden" accept="image/*" @change="e => onFileSelect(e, modelValue.ketua_bidang, idx, 'ketua_bidang')" />
                            </label>
                        </div>
                        <span v-if="person.foto_path" @click="removeFoto(modelValue.ketua_bidang, idx, 'ketua_bidang')" class="text-[10px] text-red-500 cursor-pointer hover:underline">Hapus</span>
                    </div>
                    <div class="flex-1 space-y-2 mt-1 mr-4">
                        <InputText v-model="person.nama" placeholder="Nama" class="w-full text-sm p-1 font-bold" @input="updateSection('ketua_bidang', modelValue.ketua_bidang)" />
                        <InputText v-model="person.jabatan" placeholder="Jabatan (cth: KETUA I)" class="w-full text-xs p-1 text-sky-600" @input="updateSection('ketua_bidang', modelValue.ketua_bidang)" />
                        <InputText v-model="person.sub" placeholder="Sub/Kelompok" class="w-full text-xs p-1" @input="updateSection('ketua_bidang', modelValue.ketua_bidang)" />
                    </div>
                </div>
            </div>
        </section>

        <!-- POKJA -->
        <section>
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h4 class="text-lg font-bold text-slate-800">Kelompok Kerja (POKJA)</h4>
                <Button @click="addItem('pokja', {nama: 'POKJA BARU', anggota: []})" size="small" outlined>
                    <Plus class="w-4 h-4 mr-2" /> Tambah Pokja
                </Button>
            </div>
            
            <div class="space-y-6">
                <div v-for="(pokja, pIdx) in (modelValue.pokja || [])" :key="'pok'+pIdx" class="p-4 border rounded-xl bg-white shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <InputText v-model="pokja.nama" class="font-bold text-lg" @input="updateSection('pokja', modelValue.pokja)" />
                        <div>
                            <Button @click="addAnggota(pIdx)" size="small" class="mr-2 px-3 py-2">
                                <Plus class="w-4 h-4 mr-1" /> Tambah Anggota
                            </Button>
                            <Button @click="removeItem('pokja', pIdx)" size="small" severity="danger" class="p-2">
                                <Trash class="w-4 h-4" />
                            </Button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div v-for="(anggota, aIdx) in (pokja.anggota || [])" :key="'pa'+pIdx+'-'+aIdx" class="p-3 bg-slate-50 rounded border relative">
                            <Button @click="removeAnggota(pIdx, aIdx)" severity="danger" text rounded class="absolute top-1 right-1 p-1 h-auto w-auto">
                                <X class="w-3 h-3" />
                            </Button>
                            
                            <div class="flex gap-3">
                                <!-- Photo uploader for Anggota Pokja -->
                                <div class="flex flex-col items-center gap-1 mt-2">
                                    <div class="w-12 h-12 bg-slate-200 rounded-full overflow-hidden flex items-center justify-center relative group">
                                        <img v-if="anggota.foto_path" :src="getImageUrl(anggota.foto_path)" class="w-full h-full object-cover" />
                                            <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer text-white z-10 w-full h-full">
                                                <Upload class="w-3 h-3" />
                                                <input type="file" class="hidden" accept="image/*" @change="e => onFileSelect(e, pokja.anggota, aIdx, 'pokja', true, pIdx)" />
                                            </label>
                                    </div>
                                    <span v-if="anggota.foto_path" @click="removeFoto(pokja.anggota, aIdx, 'pokja', true, pIdx)" class="text-[10px] text-red-500 cursor-pointer hover:underline">Hapus</span>
                                </div>
                                
                                <div class="flex-1 space-y-2 mt-1">
                                    <InputText v-model="anggota.nama" placeholder="Nama Anggota" class="w-full text-sm p-1" @input="updateSection('pokja', modelValue.pokja)" />
                                    <InputText v-model="anggota.jabatan" placeholder="Jabatan (KETUA/ANGGOTA)" class="w-full text-xs p-1 text-sky-600" @input="updateSection('pokja', modelValue.pokja)" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
