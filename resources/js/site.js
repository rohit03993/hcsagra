document.addEventListener('DOMContentLoaded', () => {
    initHeroSlider();
    initHomeCarousels();
    initMobileMenu();
    initNewsTabs();
    initGalleryLightbox();
    initYoutubeEmbeds();
});

function initHeroSlider() {
    const track = document.querySelector('.hero-track');
    if (!track) return;

    const slides = track.querySelectorAll('.hero-slide');
    if (slides.length < 2) return;

    const prevBtn = document.querySelector('.hero-prev');
    const nextBtn = document.querySelector('.hero-next');

    const getIndex = () => Math.round(track.scrollLeft / track.clientWidth);

    const goTo = (index) => {
        const i = ((index % slides.length) + slides.length) % slides.length;
        track.scrollTo({ left: slides[i].offsetLeft, behavior: 'smooth' });
    };

    prevBtn?.addEventListener('click', () => {
        goTo(getIndex() - 1);
        resetTimer();
    });

    nextBtn?.addEventListener('click', () => {
        goTo(getIndex() + 1);
        resetTimer();
    });

    let timer;

    const resetTimer = () => {
        clearInterval(timer);
        timer = setInterval(() => goTo(getIndex() + 1), 6000);
    };

    resetTimer();

    track.addEventListener('touchstart', resetTimer, { passive: true });
}

function initHomeCarousels() {
    const mobileQuery = window.matchMedia('(max-width: 767px)');

    document.querySelectorAll('.home-carousel').forEach((carousel) => {
        const track = carousel.querySelector('.home-carousel__track');
        if (!track) return;

        const slides = track.querySelectorAll('.home-carousel__slide');
        if (slides.length < 2) return;

        const prevBtn = carousel.querySelector('.home-carousel__prev');
        const nextBtn = carousel.querySelector('.home-carousel__next');
        const interval = parseInt(carousel.dataset.autoplay || '6000', 10);

        const getIndex = () => Math.round(track.scrollLeft / track.clientWidth);

        const goTo = (index) => {
            const i = ((index % slides.length) + slides.length) % slides.length;
            track.scrollTo({ left: slides[i].offsetLeft, behavior: 'smooth' });
        };

        let timer;

        const resetTimer = () => {
            clearInterval(timer);
            if (!mobileQuery.matches) return;
            timer = setInterval(() => goTo(getIndex() + 1), interval);
        };

        prevBtn?.addEventListener('click', () => {
            goTo(getIndex() - 1);
            resetTimer();
        });

        nextBtn?.addEventListener('click', () => {
            goTo(getIndex() + 1);
            resetTimer();
        });

        track.addEventListener('touchstart', resetTimer, { passive: true });

        mobileQuery.addEventListener('change', () => {
            clearInterval(timer);
            track.scrollTo({ left: 0 });
            if (mobileQuery.matches) resetTimer();
        });

        if (mobileQuery.matches) resetTimer();
    });
}

function initMobileMenu() {
    const toggles = document.querySelectorAll('.js-menu-toggle');
    const drawer = document.getElementById('mobile-menu');
    if (!toggles.length || !drawer) return;

    const setOpen = (open) => {
        document.body.classList.toggle('menu-open', open);
        toggles.forEach((btn) => btn.setAttribute('aria-expanded', open ? 'true' : 'false'));
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
    };

    toggles.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            setOpen(!document.body.classList.contains('menu-open'));
        });
    });

    document.querySelectorAll('.menu-close, .menu-backdrop').forEach((el) => {
        el.addEventListener('click', () => setOpen(false));
    });

    document.querySelectorAll('.menu-link').forEach((el) => {
        el.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && document.body.classList.contains('menu-open')) {
            setOpen(false);
        }
    });
}

function initGalleryLightbox() {
    const lightbox = document.getElementById('gallery-lightbox');
    if (!lightbox) return;

    const triggers = document.querySelectorAll('.gallery-lightbox-trigger');
    if (!triggers.length) return;

    const img = lightbox.querySelector('.gallery-lightbox-img');
    const caption = lightbox.querySelector('.gallery-lightbox-caption');
    const prevBtn = lightbox.querySelector('.gallery-lightbox-prev');
    const nextBtn = lightbox.querySelector('.gallery-lightbox-next');

    const items = Array.from(triggers).map((el) => ({
        src: el.dataset.fullSrc,
        caption: el.dataset.caption || '',
    }));

    let index = 0;

    const show = (i) => {
        index = ((i % items.length) + items.length) % items.length;
        const item = items[index];
        img.src = item.src;
        img.alt = item.caption;
        caption.textContent = item.caption;
        caption.classList.toggle('hidden', !item.caption);
        prevBtn.classList.toggle('hidden', items.length < 2);
        nextBtn.classList.toggle('hidden', items.length < 2);
    };

    const open = (i) => {
        show(i);
        lightbox.classList.remove('hidden');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.classList.add('gallery-lightbox-open');
    };

    const close = () => {
        lightbox.classList.add('hidden');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('gallery-lightbox-open');
        img.src = '';
    };

    triggers.forEach((el, i) => {
        el.addEventListener('click', () => open(i));
    });

    lightbox.querySelectorAll('[data-lightbox-close]').forEach((el) => {
        el.addEventListener('click', close);
    });

    prevBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        show(index - 1);
    });

    nextBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        show(index + 1);
    });

    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(index - 1);
        if (e.key === 'ArrowRight') show(index + 1);
    });
}

function initYoutubeEmbeds() {
    document.querySelectorAll('[data-youtube-play]').forEach((button) => {
        button.addEventListener('click', () => {
            const host = button.closest('[data-youtube-embed]');
            const id = host?.dataset.youtubeId;
            if (!host || !id) return;

            const iframe = document.createElement('iframe');
            iframe.src = `https://www.youtube-nocookie.com/embed/${id}?autoplay=1&rel=0&modestbranding=1`;
            iframe.title = button.getAttribute('aria-label') || 'YouTube video';
            iframe.allow =
                'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
            iframe.allowFullscreen = true;
            iframe.className = 'absolute inset-0 w-full h-full border-0';
            iframe.loading = 'lazy';

            host.replaceChildren(iframe);
        });
    });
}

function initNewsTabs() {
    const tabs = document.querySelectorAll('.news-tab');
    const panels = document.querySelectorAll('.news-panel');
    if (!tabs.length) return;

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const id = tab.dataset.tab;
            tabs.forEach((t) => {
                const active = t.dataset.tab === id;
                t.classList.toggle('is-active', active);
                t.setAttribute('aria-selected', active ? 'true' : 'false');
            });
            panels.forEach((p) => p.classList.toggle('hidden', p.dataset.panel !== id));
        });
    });
}
