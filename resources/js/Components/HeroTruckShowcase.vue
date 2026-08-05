<template>
    <div class="relative w-full h-full flex items-center justify-center perspective-1000">
        <!-- Floating animation container -->
        <div 
            class="transition-transform duration-700 ease-out z-10 w-full flex items-end justify-end"
            :style="{ transform: `translateY(${offsetY}px)`, transformOrigin: 'center right' }"
            @mouseenter="hovering = true"
            @mouseleave="hovering = false"
        >
            <!-- Truck Image - BESAR dan meluap ke kanan -->
            <img 
                :src="currentTruckImage" 
                alt="Hino 500 Dump Truck" 
                class="w-[130%] max-w-none h-auto object-contain drop-shadow-[0_20px_30px_rgba(0,155,68,0.3)]"
                style="margin-right: -10%;"
                @load="imageLoaded = true"
            />
            
            <!-- Loading skeleton -->
            <div v-if="!imageLoaded" class="absolute inset-0 flex items-center justify-center">
                <div class="w-3/4 h-3/4 bg-green-100/50 rounded-xl animate-pulse backdrop-blur-sm border border-green-200"></div>
            </div>
        </div>

        <!-- Interactive glow effect on hover -->
        <div 
            class="absolute inset-0 rounded-full mix-blend-screen pointer-events-none transition-opacity duration-500"
            :class="hovering ? 'opacity-40' : 'opacity-0'"
            style="background: radial-gradient(circle at center, rgba(0, 155, 68, 0.4) 0%, transparent 70%); z-index: 5;"
        ></div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const imageLoaded = ref(false);
const hovering = ref(false);
const offsetY = ref(0);
let animationFrame;
let startTime;

const currentTruckImage = ref('/img/slider/truck-slide3.png');

// Gentle floating animation
const animateFloat = (timestamp) => {
    if (!startTime) startTime = timestamp;
    const progress = timestamp - startTime;
    
    if (!hovering.value) {
        offsetY.value = Math.sin(progress / 600) * 8;
    } else {
        offsetY.value = -15;
    }
    
    animationFrame = requestAnimationFrame(animateFloat);
};

onMounted(() => {
    animationFrame = requestAnimationFrame(animateFloat);
});

onUnmounted(() => {
    cancelAnimationFrame(animationFrame);
});
</script>

<style scoped>
.perspective-1000 {
    perspective: 1000px;
}
</style>
