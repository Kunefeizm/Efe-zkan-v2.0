<?php
    header("Content-type: application/javascript");
?>

// Swiper.js for Sliders
// Swiper.js kütüphanesini dahil etme
// index.php dosyasından taşındı
const swiperScript = document.createElement('script');
swiperScript.src = "https://unpkg.com/swiper/swiper-bundle.min.js";
document.head.appendChild(swiperScript);

// lightGallery JS
// lightGallery kütüphanelerini dahil etme
// index.php dosyasından taşındı
const lightGalleryScript = document.createElement('script');
lightGalleryScript.src = "https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js";
document.head.appendChild(lightGalleryScript);

const lgThumbnailScript = document.createElement('script');
lgThumbnailScript.src = "https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/thumbnail/lg-thumbnail.min.js";
document.head.appendChild(lgThumbnailScript);


window.addEventListener('load', () => {

    // --- NAVBAR SCROLL & LOGO SWAP (GÜNCELLENDİ) ---
    const navbar = document.getElementById('navbar');
    if (navbar) {
        // GÜNCELLEME: Logo elementlerini yeni yapıya göre seçiyoruz.
        const logoText = navbar.querySelector('.logo-text');
        const logoDefault = document.getElementById('logo-default');
        const logoScrolled = document.getElementById('logo-scrolled');
        const navLinks = navbar.querySelectorAll('.nav-link');
        const mobileMenuButton = document.getElementById('mobile-menu-button');

        const handleScroll = () => {
            const isScrolled = window.scrollY > 50;
            navbar.classList.toggle('navbar-scrolled', isScrolled);
            navbar.classList.toggle('navbar-top', !isScrolled);

            // GÜNCELLEME: Logo türüne göre doğru elementi göster/gizle ve renklendir.
            if (logoText) { // Metin logo varsa
                logoText.classList.toggle('text-white', !isScrolled);
                logoText.classList.toggle('text-gray-800', isScrolled);
            }
            if (logoDefault && logoScrolled) { // Görsel logolar varsa
                logoDefault.classList.toggle('hidden', isScrolled);
                logoScrolled.classList.toggle('hidden', !isScrolled);
            }

            // Linklerin renklerini güncelle
            navLinks.forEach(link => {
                link.classList.toggle('text-white', !isScrolled);
                link.classList.toggle('hover:text-gray-300', !isScrolled);
                link.classList.toggle('text-gray-600', isScrolled);
                link.classList.toggle('hover:text-blue-600', isScrolled);
            });
            
            // Mobil menü ikon rengini güncelle
            if (mobileMenuButton) {
                mobileMenuButton.classList.toggle('text-white', !isScrolled);
                mobileMenuButton.classList.toggle('text-gray-800', isScrolled);
            }
        };

        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Sayfa yüklendiğinde ilk kontrolü yap
    }

    // --- MOBİL MENÜ (KORUNDU VE İYİLEŞTİRİLDİ) ---
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    const openMobileMenu = () => {
        if (!mobileMenu || !mobileMenuOverlay) return;
        mobileMenu.classList.remove('-translate-x-full');
        mobileMenuOverlay.classList.remove('hidden');
        setTimeout(() => mobileMenuOverlay.classList.add('opacity-100'), 10);
        document.body.classList.add('mobile-menu-open');
    };

    const closeMobileMenu = () => {
        if (!mobileMenu || !mobileMenuOverlay) return;
        mobileMenu.classList.add('-translate-x-full');
        mobileMenuOverlay.classList.remove('opacity-100');
        setTimeout(() => mobileMenuOverlay.classList.add('hidden'), 300);
        document.body.classList.remove('mobile-menu-open');
    };

    if (mobileMenuButton) mobileMenuButton.addEventListener('click', openMobileMenu);
    if (closeMobileMenuButton) closeMobileMenuButton.addEventListener('click', closeMobileMenu);
    if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    mobileNavLinks.forEach(link => link.addEventListener('click', closeMobileMenu));

    // --- SLIDER'LAR (MEVCUT KODUNUZ KORUNDU) ---
    const mainSliderEl = document.querySelector('.main-slider');
    if (mainSliderEl && typeof Swiper !== 'undefined') {
        const mainSlider = new Swiper(mainSliderEl, {
            loop: true,
            autoplay: {
                delay: parseInt(mainSliderEl.dataset.autoplayDelay) || 5000,
                disableOnInteraction: false,
            },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    }

    const testimonialsSliderEl = document.querySelector('.testimonials-slider');
    if (testimonialsSliderEl && typeof Swiper !== 'undefined') {
        const testimonialsSlider = new Swiper(testimonialsSliderEl, {
            loop: true,
            autoplay: {
                delay: parseInt(testimonialsSliderEl.dataset.autoplayDelay) || 4000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            slidesPerView: 1,
            spaceBetween: 30,
        });
    }
    
    // --- LIGHTGALLERY (MEVCUT KODUNUZ KORUNDU) ---
    const galleryEl = document.getElementById('lightgallery');
    if (galleryEl && typeof lightGallery !== 'undefined') {
        lightGallery(galleryEl, {
            plugins: (typeof lgThumbnail !== 'undefined') ? [lgThumbnail] : [],
            selector: 'a',
            download: false,
            speed: 500,
        });
    }

    // --- HIZLI İLETİŞİM BUTONLARI (MEVCUT KODUNUZ KORUNDU) ---
    const desktopWidget = document.getElementById('contact-widget-desktop');
    if (desktopWidget) {
        const container = desktopWidget.querySelector('.contact-widget-container');
        desktopWidget.querySelectorAll('[data-view-trigger]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                if (trigger.tagName === 'A' && trigger.getAttribute('href') !== 'javascript:void(0)') return;
                e.preventDefault();
                
                const viewName = trigger.dataset.viewTrigger;
                const currentView = desktopWidget.querySelector('.contact-view.active');
                const targetView = desktopWidget.querySelector(`#contact-${viewName}-view`);
                
                if (targetView && currentView && currentView !== targetView) {
                    currentView.classList.remove('active');
                    targetView.classList.add('active');
                    
                    if (viewName === 'main') {
                        container.style.height = '72px';
                        container.style.width = 'initial';
                    } else {
                        const headerHeight = 56;
                        const listItems = targetView.querySelectorAll('.contact-list-item');
                        const itemCount = listItems.length;
                        const itemRowHeight = 44;
                        const itemGap = 8;
                        const listPadding = 24;
                        const calculatedHeight = headerHeight + listPadding + (itemCount * itemRowHeight) + ((itemCount - 1) * itemGap);
                        container.style.height = (calculatedHeight + 8) + 'px';
                        container.style.width = '400px';
                    }
                }
            });
        });
    }

    const mobileBar = document.getElementById('contact-widget-mobile-bar');
    const mobileOverlay = document.getElementById('contact-mobile-overlay');
    if (mobileBar && mobileOverlay) {
        mobileBar.querySelectorAll('[data-view-trigger]').forEach(trigger => {
            trigger.addEventListener('click', e => {
                if (trigger.getAttribute('href') !== 'javascript:void(0)') return;
                e.preventDefault();
                
                const viewName = trigger.dataset.viewTrigger;
                mobileOverlay.querySelectorAll('.contact-view').forEach(v => v.classList.remove('active'));
                
                const targetView = mobileOverlay.querySelector(`#contact-${viewName}-view-mobile`);
                if (targetView) {
                    targetView.classList.add('active');
                    mobileOverlay.classList.remove('hidden');
                    setTimeout(() => mobileOverlay.classList.add('is-open'), 10);
                }
            });
        });

        mobileOverlay.querySelector('#contact-mobile-backdrop').addEventListener('click', () => {
            mobileOverlay.classList.remove('is-open');
            setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
        });
    }
});
