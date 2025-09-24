<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from 'primevue/button';
import ClientOnly from '@/components/ClientOnly.vue';

import AppHeader from '@/layouts-blog/AppHeader.vue';
import AppFooter from '@/layouts-blog/AppFooter.vue';

import {
    Home, Landmark, ListChecks, Menu, ChevronsUpDown
} from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div>
        <div class="scroll-container">
            <div class="relative font-sans text-slate-800">
                <div class="light-futuristic-bg">
                    <div class="circles">
                        <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li>
                    </div>
                </div>

                <div class="relative z-10">
                    <AppHeader 
                        :can-login="canLogin" 
                        :can-register="canRegister"
                    />
                    
                    <slot />

                    <AppFooter />
                </div>
            </div>
        </div>
    </div>
</template>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
:root {
    --bg-light: #f8fafc;
    --accent-blue: #0ea5e9;
}
.font-sans { font-family: 'Poppins', sans-serif; }
.scroll-container {
  height: 100vh;
  overflow-y: auto;
  overflow-x: hidden;
  scroll-behavior: smooth;
  -webkit-transform: translateZ(0);
  transform: translateZ(0);
}
.light-futuristic-bg {
    background: linear-gradient(135deg, #ffffff 0%, #e0f7fa 100%);
    position: absolute; 
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}
.circles{
    position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden;
}
.circles li{
    position: absolute; display: block; list-style: none; width: 20px; height: 20px;
    background: rgba(14, 165, 233, 0.1); animation: animate-circles 25s linear infinite; bottom: -150px;
}
.circles li:nth-child(1){ left: 25%; width: 80px; height: 80px; animation-delay: 0s; }
.circles li:nth-child(2){ left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s; }
.circles li:nth-child(3){ left: 70%; width: 20px; height: 20px; animation-delay: 4s; }
.circles li:nth-child(4){ left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s; }
.circles li:nth-child(5){ left: 65%; width: 20px; height: 20px; animation-delay: 0s; }
.circles li:nth-child(6){ left: 75%; width: 110px; height: 110px; animation-delay: 3s; }
.circles li:nth-child(7){ left: 35%; width: 150px; height: 150px; animation-delay: 7s; }
.circles li:nth-child(8){ left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; }
.circles li:nth-child(9){ left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; }
.circles li:nth-child(10){ left: 85%; width: 150px; height: 150px; animation-delay: 0s; animation-duration: 11s; }

@keyframes animate-circles {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; border-radius: 0; }
    100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; border-radius: 50%; }
}
.frosted-glass-header, .frosted-glass-card {
    background: rgba(255, 255, 255, 0.6); -webkit-backdrop-filter: blur(12px);
    backdrop-filter: blur(12px); border: 1px solid rgba(0, 0, 0, 0.05);
}
.nav-link-light {
    position: relative; color: #334155; text-decoration: none; transition: color 0.3s;
}
.nav-link-light:hover { color: #000; }
.nav-link-light::after {
    content: ''; position: absolute; width: 100%; transform: scaleX(0); height: 2px;
    bottom: -4px; left: 0; background-color: var(--accent-blue);
    transform-origin: bottom right; transition: transform 0.3s ease-out;
}
.nav-link-light:hover::after { transform: scaleX(1); transform-origin: bottom left; }
.futuristic-button-light {
    background: var(--accent-blue); border: none; color: white;
    font-weight: bold; transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(14, 165, 233, 0.4);
    display: inline-flex;
    align-items: center;
}
.futuristic-button-light:hover {
    transform: scale(1.05); box-shadow: 0 6px 25px rgba(14, 165, 233, 0.5);
}
.animate-on-scroll {
  opacity: 0; transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}
.animate-on-scroll.is-visible {
  opacity: 1; transform: translateY(0);
}

.nav-link-light:visited span {
    color:#334155;
}

header a, header a:visited span,
header a:visited svg {
    text-decoration: none;
}

header a:visited span {
    color:#0d76b6;
}

header a:visited svg {
    color:#0d76b6;
}

.custom-shape-divider-bottom-light {
    position: absolute; bottom: -1px; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(0);
}
.custom-shape-divider-bottom-light svg {
    position: relative; display: block; width: calc(100% + 1.3px); height: 80px;
}
.custom-shape-divider-bottom-light .shape-fill {
    fill: #f9fefe;
}
</style>