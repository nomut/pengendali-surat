<script setup>
defineProps({
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <footer class="border-t border-slate-900/10 text-slate-500 py-8 mt-20 bg-white/50">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <p>&copy; {{ new Date().getFullYear() }} PKK-YGK.ID. Inovasi untuk Kesejahteraan.</p>
            <p class="text-sm mt-2">
                Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </p>
        </div>
    </footer>
</template>