import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';

// Import Vue components here
import TcoCalculator from './Components/TcoCalculator.vue';
import HeroTruckShowcase from './Components/HeroTruckShowcase.vue';
import JavaInteractiveMap from './Components/JavaInteractiveMap.vue';

const app = createApp({});

// Register components
app.component('tco-calculator', TcoCalculator);
app.component('hero-truck-showcase', HeroTruckShowcase);
app.component('java-interactive-map', JavaInteractiveMap);

// Mount to an element if it exists
if (document.getElementById('vue-app')) {
    app.mount('#vue-app');
}
