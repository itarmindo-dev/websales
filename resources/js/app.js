import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import TcoCalculator from './Components/TcoCalculator.vue';

window.Alpine = Alpine;
Alpine.start();

const calculator = document.getElementById('tco-calculator-app');

if (calculator) {
    createApp(TcoCalculator).mount(calculator);
}
