<script setup>
import ApplicationLogo from '@/components/ApplicationLogo.vue';
</script>

<template>
    <Button
        :href="route('home')"
        pt:root:class="flex items-center justify-start gap-4 no-underline p-0"
        variant="link"
        as="InertiaLink"
    >
        <ApplicationLogo class="text-sky-500 group-hover:text-sky-600 transition-colors duration-300" />
        <span class="font-bold">PKK DIY</span>
    </Button>
</template>