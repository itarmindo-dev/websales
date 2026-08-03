import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';

// Import Vue components here
import TcoCalculator from './Components/TcoCalculator.vue';
import HeroTruckShowcase from './Components/HeroTruckShowcase.vue';

const app = createApp({});

// Register components
app.component('tco-calculator', TcoCalculator);
app.component('hero-truck-showcase', HeroTruckShowcase);

// Mount to an element if it exists
if (document.getElementById('vue-app')) {
    app.mount('#vue-app');
}
