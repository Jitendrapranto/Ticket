import './bootstrap';
import Alpine from 'alpinejs';
import Swup from 'swup';
import SwupHeadPlugin from '@swup/head-plugin';
import SwupScriptsPlugin from '@swup/scripts-plugin';
import SwupPreloadPlugin from '@swup/preload-plugin';

// Initializing Alpine
window.Alpine = Alpine;
Alpine.start();

/**
 * Page Components & Utilities
 */
const initScrollReveal = () => {
    const revealElements = document.querySelectorAll('section, .reveal-item');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px 100px 0px' });

    revealElements.forEach(el => {
        el.classList.add('reveal-init');
        // Ensure first section or hero items show immediately
        if (el.tagName === 'SECTION' && el === document.querySelector('section')) {
            el.classList.add('revealed');
        } else {
            revealObserver.observe(el);
        }
    });
};

const initHeaderScroll = () => {
    const header = document.querySelector('header');
    if (!header) return;

    const handleScroll = () => {
        if (window.scrollY > 20) {
            header.classList.add('shadow-xl', 'bg-white/100');
        } else {
            header.classList.remove('shadow-xl', 'bg-white/100');
        }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // Initial check
};

const setupProgress = () => {
    const loader = document.getElementById('top-loader');
    if (!loader) return;

    // Reset loader
    loader.style.width = '0%';
    loader.style.opacity = '1';
    loader.style.transition = 'width 0.4s ease-out, opacity 0.3s ease-in';
};

/**
 * Initialize Swup for SPA-like transitions
 */
const swup = new Swup({
    plugins: [
        new SwupHeadPlugin(),
        new SwupScriptsPlugin(),
        new SwupPreloadPlugin({ preloadHoveredLinks: true })
    ],
    containers: ['#swup-container'],
    // Only intercept links that are NOT marked with data-no-swup
    // and skip links to pages that don't use the #swup-container layout
    linkSelector: 'a[href]:not([data-no-swup]):not([href*="/events/create"]):not([href*="/events/"][href$="/edit"])'
});

// Run on every page load
const initAll = () => {
    initScrollReveal();
    initHeaderScroll();

    // Sidebar Toggle for Organizer Dashboard
    const sidebar = document.getElementById('organizer-sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar');
    if (toggleBtn && sidebar) {
        const setSidebar = (open) => {
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
        };

        toggleBtn.addEventListener('click', () => {
            const isOpen = sidebar.classList.contains('translate-x-0');
            setSidebar(!isOpen);
        });

        // Auto-close on link click (mobile)
        sidebar.addEventListener('click', (e) => {
            if ((e.target.closest('a') || e.target.closest('button')) && window.innerWidth < 1024) {
                setSidebar(false);
            }
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
};

// Initial run
document.addEventListener('DOMContentLoaded', () => {
    initAll();
});

// Swup Events for smooth loading experience
swup.hooks.on('visit:start', () => {
    const loader = document.getElementById('top-loader');
    if (loader) {
        loader.style.opacity = '1';
        loader.style.width = '70%';
    }
});

swup.hooks.on('visit:end', () => {
    const loader = document.getElementById('top-loader');
    if (loader) {
        loader.style.width = '100%';
        setTimeout(() => {
            loader.style.opacity = '0';
            setTimeout(() => { loader.style.width = '0%'; }, 300);
        }, 100);
    }
});

swup.hooks.on('page:view', () => {
    initAll();
    // Scroll to top on page change
    window.scrollTo({ top: 0, behavior: 'instant' });
});

// Support for Alpine.js with Swup
swup.hooks.on('content:replace', () => {
    if (window.Alpine) {
        window.Alpine.initTree(document.getElementById('swup-container'));
    }
});
