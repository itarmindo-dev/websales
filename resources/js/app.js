import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import TcoCalculator from './Components/TcoCalculator.vue';

window.Alpine = Alpine;

Alpine.data('salesSectionBuilder', (initialSections = []) => ({
    sections: initialSections,
    nextKey: Date.now(),

    addSection() {
        this.sections.push({
            key: `new-${this.nextKey++}`,
            id: null,
            type: 'image_text',
            layout: 'media_left',
            eyebrow: '',
            title: '',
            body: '',
            media_url: '',
            media_preview_url: null,
            media_name: null,
            button_label: '',
            button_url: '',
            is_active: true,
            remove_media: false,
            _delete: false,
        });
    },

    move(index, direction) {
        const target = index + direction;

        if (target < 0 || target >= this.sections.length) {
            return;
        }

        [this.sections[index], this.sections[target]] = [this.sections[target], this.sections[index]];
    },

    removeSection(index) {
        if (this.sections[index].id) {
            this.sections[index]._delete = true;

            return;
        }

        this.sections.splice(index, 1);
    },

    normalizeLayout(section) {
        if (section.type === 'video') {
            section.layout = 'full_width';

            return;
        }

        if (section.type === 'image_text') {
            section.layout = 'media_left';

            return;
        }

        section.layout = 'full_width';
    },

    typeLabel(type) {
        return {
            image_text: 'Gambar + teks',
            video: 'Video',
            text: 'Teks editorial',
        }[type] ?? 'Section';
    },
}));

Alpine.start();

const calculator = document.getElementById('tco-calculator-app');

if (calculator) {
    createApp(TcoCalculator, {
        submitUrl: calculator.dataset.submitUrl,
        salesSlug: calculator.dataset.salesSlug || '',
        salesName: calculator.dataset.salesName || '',
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
