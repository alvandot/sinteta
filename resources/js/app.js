import './bootstrap';
import Alpine from 'alpinejs';

// Plugin configuration
const PLUGINS = {
    focus: () => import('@alpinejs/focus'),
    collapse: () => import('@alpinejs/collapse'),
    persist: () => import('@alpinejs/persist'),
    mask: () => import('@alpinejs/mask'),
    intersect: () => import('@alpinejs/intersect')
};

// Plugin cache using WeakMap for better memory management
const pluginCache = new WeakMap();

// Optimized plugin loader with caching
const loadPlugin = async (name) => {
    try {
        if (!pluginCache.has(Alpine)) {
            pluginCache.set(Alpine, new Map());
        }
        const cache = pluginCache.get(Alpine);

        if (!cache.has(name)) {
            const module = await PLUGINS[name]();
            cache.set(name, module.default);
        }

        return cache.get(name);
    } catch (error) {
        console.error(`Failed to load plugin: ${name}`, error);
        throw error;
    }
};

// Performance monitoring utility
const measurePerformance = async (label, fn) => {
    if (process.env.NODE_ENV === 'development') {
        console.time(label);
        const result = await fn();
        console.timeEnd(label);
        return result;
    }
    return fn();
};

// Optimized smooth scroll with IntersectionObserver
const initSmoothScroll = () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        },
        { threshold: 0.1 }
    );

    document.addEventListener('click', (e) => {
        const anchor = e.target.closest('a[href^="#"]');
        if (!anchor) return;

        e.preventDefault();
        const target = document.querySelector(anchor.getAttribute('href'));

        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            observer.observe(target);
        }
    });
};

// Initialize Alpine with error boundary
const initializeAlpine = async () => {
    if (window.Alpine) return;

    try {
        // Disable transitions during initialization
        document.documentElement.classList.add('no-transitions');

        // Load plugins concurrently
        await measurePerformance('Plugin Loading', async () => {
            const plugins = await Promise.all(
                Object.keys(PLUGINS).map(async name => {
                    const plugin = await loadPlugin(name);
                    Alpine.plugin(plugin);
                    return plugin;
                })
            );
            return plugins;
        });

        // Initialize Alpine
        window.Alpine = Alpine;
        await measurePerformance('Alpine Init', () => Alpine.start());

        // Setup smooth scroll after DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSmoothScroll);
        } else {
            initSmoothScroll();
        }

        // Re-enable transitions
        requestAnimationFrame(() => {
            document.documentElement.classList.remove('no-transitions');
        });

    } catch (error) {
        console.error('Alpine initialization failed:', error);
        // Fallback initialization
        window.Alpine = Alpine;
        Alpine.start();
    }
};

// Start initialization with error boundary
(() => {
    initializeAlpine()
        .catch(error => {
            console.error('Critical initialization error:', error);
            // Log to error monitoring service in production
            if (process.env.NODE_ENV === 'production') {
                // errorMonitoringService.log(error);
            }
        });
})();
