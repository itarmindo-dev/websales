import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import TcoCalculator from './Components/TcoCalculator.vue';

window.Alpine = Alpine;
Alpine.start();

const calculator = document.getElementById('tco-calculator-app');

if (calculator) {
    createApp(TcoCalculator, {
        submitUrl: calculator.dataset.submitUrl,
    }).mount(calculator);
}

const sectionLinks = [...document.querySelectorAll('[data-nav-section]')];
const pageSections = [...new Set(sectionLinks.map((link) => link.dataset.navSection))]
    .map((sectionId) => document.getElementById(sectionId))
    .filter(Boolean);

if (sectionLinks.length && pageSections.length) {
    const header = document.querySelector('.site-header');
    let scrollFrame = null;

    const setActiveSection = (sectionId) => {
        sectionLinks.forEach((link) => {
            const isActive = link.dataset.navSection === sectionId;

            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'location');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    const updateActiveSection = () => {
        const sectionScrollMargin = Number.parseFloat(window.getComputedStyle(pageSections[0]).scrollMarginTop) || 0;
        const activationLine = Math.max((header?.offsetHeight ?? 0) + 24, sectionScrollMargin + 1);
        let activeSection = pageSections[0].id;

        pageSections.forEach((section) => {
            if (section.getBoundingClientRect().top <= activationLine) {
                activeSection = section.id;
            }
        });

        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) {
            activeSection = pageSections.at(-1).id;
        }

        setActiveSection(activeSection);
        scrollFrame = null;
    };

    const requestActiveSectionUpdate = () => {
        if (scrollFrame === null) {
            scrollFrame = window.requestAnimationFrame(updateActiveSection);
        }
    };

    sectionLinks.forEach((link) => {
        link.addEventListener('click', () => setActiveSection(link.dataset.navSection));
    });

    window.addEventListener('scroll', requestActiveSectionUpdate, { passive: true });
    window.addEventListener('resize', requestActiveSectionUpdate);
    window.addEventListener('hashchange', requestActiveSectionUpdate);
    window.requestAnimationFrame(updateActiveSection);
}
