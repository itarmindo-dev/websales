<template>
    <div class="java-map-wrapper">
        
        <!-- Peta Dasar (map-4.png) - Pure Image -->
        <div class="java-map-bg"></div>
        
    </div>
</template>

<script setup>
// No interactive elements needed - pure map image only
</script>

<style scoped>
/* ============================================
   CONTAINER UTAMA PETA
   ============================================ */
.java-map-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: visible;
}

/* Background Peta Pulau Jawa (map-4.png) - Pure Image, fades on right */
.java-map-bg {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('/img/shape/map-4.png');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: contain;
    opacity: 0.55;
    mix-blend-mode: multiply;
    pointer-events: none;
    filter: drop-shadow(0 4px 12px rgba(0,155,68,0.12));
    -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,1) 60%, rgba(0,0,0,0.3) 85%, transparent 100%);
    mask-image: linear-gradient(to right, rgba(0,0,0,1) 60%, rgba(0,0,0,0.3) 85%, transparent 100%);
    transform: scaleX(1.25);
    transform-origin: right center;
}
</style>
