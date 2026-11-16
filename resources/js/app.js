import './bootstrap';

let revealObserver;

function initializePageMotion() {
    if (!document.body.classList.contains('public-site')) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    document.documentElement.classList.toggle('motion-ready', !reducedMotion);

    if (!reducedMotion && 'IntersectionObserver' in window) {
        revealObserver ??= new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.12 });
    }

    document.querySelectorAll('[data-reveal], main > section, main > div > section, main .service-card, main .content-card, main .tool-card, main .public-card, main .public-page-hero, main .cta-panel').forEach((element) => {
        if (element.dataset.revealReady) return;

        element.classList.add('reveal');
        element.dataset.revealReady = 'true';

        if (element.dataset.revealDelay) {
            element.style.transitionDelay = `${Number(element.dataset.revealDelay)}ms`;
        }

        if (reducedMotion || !revealObserver) {
            element.classList.add('is-visible');
        } else {
            revealObserver.observe(element);
        }
    });

    if (reducedMotion || window.matchMedia('(hover: none)').matches) return;

    document.querySelectorAll('[data-tilt], main .public-card, main .public-page-hero, main .public-workbench, main .service-card, main .content-card, main .tool-card, main .cta-panel').forEach((element) => {
        if (element.dataset.tiltReady) return;

        element.dataset.tiltReady = 'true';
        element.addEventListener('pointermove', (event) => {
            if (event.pointerType === 'touch') return;

            const bounds = element.getBoundingClientRect();
            const x = (event.clientX - bounds.left) / bounds.width - 0.5;
            const y = (event.clientY - bounds.top) / bounds.height - 0.5;
            const strength = element.classList.contains('hero-scene') ? 6.5 : element.classList.contains('hero-glass-card') ? 5 : element.classList.contains('public-page-hero') ? 1.4 : 3.2;
            const base = element.classList.contains('hero-glass-card') ? ' rotateY(-9deg) rotateX(4deg)' : '';

            element.style.transform = `perspective(1000px) rotateX(${-y * strength}deg) rotateY(${x * strength}deg)${base} translateY(-3px)`;
            element.style.willChange = 'transform';
            element.style.setProperty('--pointer-x', `${(x + 0.5) * 100}%`);
            element.style.setProperty('--pointer-y', `${(y + 0.5) * 100}%`);
        });
        element.addEventListener('pointerleave', () => {
            element.style.transform = '';
            element.style.willChange = '';
            element.style.removeProperty('--pointer-x');
            element.style.removeProperty('--pointer-y');
        });
    });
}

document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-nav-toggle]');

    if (toggle) {
        const menu = document.getElementById(toggle.getAttribute('aria-controls'));
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';

        if (!menu) return;

        menu.hidden = isOpen;
        toggle.setAttribute('aria-expanded', String(!isOpen));
        toggle.setAttribute('aria-label', isOpen ? 'Open menu' : 'Close menu');
        return;
    }

    if (event.target.closest('#mobile-nav a')) {
        const menu = document.getElementById('mobile-nav');
        const menuToggle = document.querySelector('[data-nav-toggle]');

        menu.hidden = true;
        menuToggle?.setAttribute('aria-expanded', 'false');
        menuToggle?.setAttribute('aria-label', 'Open menu');
    }
});

initializePageMotion();
document.addEventListener('livewire:navigated', initializePageMotion);
