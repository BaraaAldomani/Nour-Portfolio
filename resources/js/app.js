/*
| ============================================================================
| Motion
| ============================================================================
|
| One file, no framework. Scroll reveals with stagger, count-up statistics, the
| mobile navigation, header state and the portfolio filter.
|
| Everything decorative is gated on prefers-reduced-motion. When motion is
| reduced we do not merely shorten the animations -- we skip them and put the
| content into its final state immediately.
*/

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

/**
 * Mark the document as JS-capable. The reveal styles are scoped to `.js`, so
 * until this line runs the content is plainly visible -- which is also exactly
 * what a crawler or a reader without JavaScript gets.
 */
document.documentElement.classList.add('js');

/* ---------------------------------------------------------------------------
| Hero entrance
| ---------------------------------------------------------------------------
| One choreographed sequence: the masked lines rise and the portrait sharpens
| once the display fonts are ready, so nothing animates in a fallback face and
| then jumps. A timeout race guarantees the page never stays hidden if a font
| stalls.
| ------------------------------------------------------------------------- */
function initHeroSequence() {
    const hero = document.querySelector('[data-hero]');

    if (!hero) {
        return;
    }

    const ready = () => hero.classList.add('hero-ready');

    if (reduceMotion.matches) {
        ready();

        return;
    }

    Promise.race([
        document.fonts?.ready ?? Promise.resolve(),
        new Promise((resolve) => setTimeout(resolve, 700)),
    ]).then(() => requestAnimationFrame(ready));
}

/* ---------------------------------------------------------------------------
| Scroll-linked motion: progress rail + parallax drift
| ---------------------------------------------------------------------------
| One rAF loop drives both. Parallax measures the untransformed PARENT of each
| target — transforming the target itself would move its own rect and feed
| back into the next measurement.
| ------------------------------------------------------------------------- */
function initScrollMotion() {
    const rail = document.querySelector('[data-progress]');

    const layers = reduceMotion.matches
        ? []
        : [...document.querySelectorAll('[data-parallax]')]
            .filter((el) => el.parentElement)
            .map((el) => ({
                el,
                parent: el.parentElement,
                speed: Number(el.dataset.parallax) || 0,
            }));

    if (!rail && layers.length === 0) {
        return;
    }

    let ticking = false;

    const update = () => {
        if (rail) {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            const progress = max > 0 ? Math.min(window.scrollY / max, 1) : 0;
            rail.style.transform = `scaleX(${progress.toFixed(4)})`;
        }

        for (const { el, parent, speed } of layers) {
            const rect = parent.getBoundingClientRect();
            const offset = (rect.top + rect.height / 2 - window.innerHeight / 2) * speed;
            el.style.transform = `translate3d(0, ${offset.toFixed(1)}px, 0)`;
        }

        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(update);
            }
        },
        { passive: true },
    );

    window.addEventListener('resize', update, { passive: true });

    update();
}

/* ---------------------------------------------------------------------------
| Scroll reveals
| ------------------------------------------------------------------------- */
function initReveals() {
    const targets = document.querySelectorAll(
        '.reveal, .reveal-blur, .reveal-side, .reveal-stagger, .grow-y',
    );

    if (targets.length === 0) {
        return;
    }

    if (reduceMotion.matches || !('IntersectionObserver' in window)) {
        targets.forEach((el) => el.setAttribute('data-revealed', 'true'));

        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const el = entry.target;

                // Stagger siblings within a group so a grid resolves as a sweep
                // rather than all at once. Capped so a long list never leaves
                // the reader waiting.
                const index = Number(el.dataset.revealIndex ?? 0);
                el.style.setProperty('--reveal-delay', `${Math.min(index, 8) * 70}ms`);
                el.setAttribute('data-revealed', 'true');

                observer.unobserve(el);
            });
        },
        { rootMargin: '0px 0px -12% 0px', threshold: 0.12 },
    );

    targets.forEach((el) => observer.observe(el));
}

/* ---------------------------------------------------------------------------
| Count-up statistics
| ------------------------------------------------------------------------- */
function initCounters() {
    const counters = document.querySelectorAll('[data-count-to]');

    if (counters.length === 0) {
        return;
    }

    // The final value is rendered server-side, so with reduced motion (or no
    // observer) there is simply nothing to do.
    if (reduceMotion.matches || !('IntersectionObserver' in window)) {
        return;
    }

    const run = (el) => {
        const target = Number(el.dataset.countTo ?? 0);
        const duration = 1400;
        const start = performance.now();
        const formatter = new Intl.NumberFormat(document.documentElement.lang || 'en');

        const tick = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            // easeOutExpo -- quick start, long settle.
            const eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);

            el.textContent = formatter.format(Math.round(target * eased));

            if (progress < 1) {
                requestAnimationFrame(tick);
            }
        };

        requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                run(entry.target);
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.6 },
    );

    counters.forEach((el) => observer.observe(el));
}

/* ---------------------------------------------------------------------------
| Mobile navigation
| ------------------------------------------------------------------------- */
function initNav() {
    const toggle = document.querySelector('[data-nav-toggle]');
    const panel = document.querySelector('[data-nav-panel]');

    if (!toggle || !panel) {
        return;
    }

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        panel.toggleAttribute('hidden', !open);
        document.body.style.overflow = open ? 'hidden' : '';
    };

    toggle.addEventListener('click', () => {
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    panel.addEventListener('click', (event) => {
        if (event.target instanceof HTMLAnchorElement) {
            setOpen(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            toggle.focus();
        }
    });
}

/* ---------------------------------------------------------------------------
| Header state on scroll
| ------------------------------------------------------------------------- */
function initHeader() {
    const header = document.querySelector('[data-header]');

    if (!header) {
        return;
    }

    let ticking = false;

    const update = () => {
        header.toggleAttribute('data-scrolled', window.scrollY > 24);
        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(update);
            }
        },
        { passive: true },
    );

    update();
}

/* ---------------------------------------------------------------------------
| Portfolio category filter
| ------------------------------------------------------------------------- */
function initFilter() {
    const buttons = document.querySelectorAll('[data-filter]');
    const items = document.querySelectorAll('[data-category]');

    if (buttons.length === 0 || items.length === 0) {
        return;
    }

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const wanted = button.dataset.filter;

            buttons.forEach((other) => {
                other.setAttribute('aria-pressed', String(other === button));
            });

            items.forEach((item) => {
                const matches = wanted === 'all' || item.dataset.category === wanted;
                item.toggleAttribute('hidden', !matches);
            });
        });
    });
}

function init() {
    initHeroSequence();
    initScrollMotion();
    initReveals();
    initCounters();
    initNav();
    initHeader();
    initFilter();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
