<?php
header("Content-type: text/css");
?>
/* Proje için özel stiller */
body {
    font-family: 'Inter', sans-serif;
    background-color: #f8fafc; /* Açık gri arka plan */
    cursor: auto; /* Varsayılan imleci geri getir */
}

/* Sayfa menü açıkken kaydırmayı engellemek için */
body.mobile-menu-open {
    overflow: hidden;
}

/* 1250px maks. genişlik için özel konteyner */
.container-custom {
    width: 100%;
    max-width: 1250px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 1rem; /* 16px */
    padding-right: 1rem; /* 16px */
}

/* Navbar başlangıç durumu (hafif saydam ve koyu) */
#navbar {
    background-color: rgba(30, 41, 59, 0.2); /* Yarı saydam koyu mavi */
    backdrop-filter: blur(4px);
    transition: all 0.3s ease; /* Tüm geçişlere yumuşaklık ekle */
    border-bottom: 1px solid transparent; /* Varsayılan ince çizgi */
}

/* Navbar kaydırıldığında aktifleşen durum (tam opak beyaz) */
#navbar.navbar-scrolled {
    background-color: white; /* Tam opak beyaz arka plan */
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    backdrop-filter: blur(0px);
    border-bottom: 1px solid rgba(226, 232, 240, 1); /* Kaydırıldığında gri çizgi */
}

/* Navbar en üstteyken altına gelen ince beyaz çizgi */
#navbar.navbar-top {
    border-bottom: 1px solid rgba(255, 255, 255, 0.3); /* Yarı saydam beyaz çizgi */
}

/* Mobil menü içeriği (her zaman opak ve sol taraftan gelir) */
#mobile-menu {
    background-color: #ffffff; /* Tam opak beyaz arka plan */
    backdrop-filter: none;
    z-index: 50; /* Tailwind z-50'yi garanti altına almak için */
}
#mobile-menu a {
    color: #1e293b; /* Menü linklerini koyu renk yaptım */
}
#mobile-menu .flex button {
    color: #1e293b; /* Menü kapatma ikonunu koyu renk yaptım */
}

/* Mobil menü overlay */
#mobile-menu-overlay {
    background-color: rgba(0, 0, 0, 0.5); /* Daha belirgin bir karartma */
    z-index: 40; /* Tailwind z-40'ı garanti altına almak için */
    transition: opacity 0.3s ease;
}
#mobile-menu-overlay.hidden {
    opacity: 0;
    pointer-events: none;
}

/* Swiper slider stilleri */
.main-slider .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Tam ekran yüksekliği */
    background-size: cover;
    background-position: center;
    color: white;
    position: relative; /* Sahte eleman için eklendi */
}

/* Tam slayt üzerine bindirme katmanı */
.main-slider .swiper-slide::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3); /* %30 siyah bindirme */
    z-index: 1;
}

.main-slider .slide-content {
    text-align: center;
    padding: 2rem 3rem;
    border-radius: 1rem;
    position: relative; /* İçeriği bindirme katmanının üstüne yerleştirmek için eklendi */
    z-index: 2; /* İçeriği bindirme katmanının üstüne yerleştirmek için eklendi */
}

/* Bölüm dolgusu */
.section-padding {
    padding-top: 4rem; /* 64px */
    padding-bottom: 4rem; /* 64px */
}

/* Kart üzerine gelme efekti */
.blog-card {
    transition: box-shadow 0.3s ease; /* Sadece gölge geçişi */
}
.blog-card:hover {
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); /* Daha sade bir gölge (shadow-lg) */
}

/* lightGallery özel stillendirme */
.lg-backdrop {
    background-color: rgba(0, 0, 0, 0.8);
}
.lg-sub-html {
    background-color: rgba(0, 0, 0, 0.7) !important;
    text-align: center !important;
    font-size: 1rem !important;
    padding: 1rem !important;
}

/* Hızlı İletişim Butonları CSS */
:root {
    --whatsapp-color: #25D366;
    --phone-color: #34B7F1;
    --email-color: #F57C00;
    --location-color: #9b59b6;
}

/* Genel Konteyner Stilleri */
.contact-widget-container {
    position: relative;
    display: flex;
    align-items: center;
    height: 72px;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    min-width: 360px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    background-color: rgba(30, 41, 59, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    transition: height 0.35s cubic-bezier(0.4, 0, 0.2, 1), width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Mobil Konteyner */
.contact-widget-container.mobile {
    min-width: 100%;
    height: 72px;
    border-radius: 0;
    box-shadow: 0 -4px 15px rgba(0,0,0,0.2);
    padding: 0;
    border: none;
    background-color: rgba(30, 41, 59, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    transition: none;
}

/* Görünüm Geçişleri */
.contact-view {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: space-around;
    transition: opacity 0.25s ease-in-out;
}
.contact-view:not(.active) {
    opacity: 0;
    pointer-events: none;
}
.contact-widget-container.is-expanded .contact-main-view {
    opacity: 0;
    pointer-events: none;
}
.contact-widget-container.is-expanded .contact-list-view {
    opacity: 1;
    pointer-events: auto;
    transition-delay: 0.1s;
}

/* Buton Stilleri */
.contact-item {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    padding: 0.5rem;
    text-decoration: none;
    flex: 1;
    text-align: center;
    height: 100%;
    background-color: transparent;
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    transition: background-color 0.2s ease;
}
.contact-item:hover {
     background-color: rgba(255, 255, 255, 0.1);
}
.contact-item:last-child {
    border-right: none;
}
.contact-item i {
    font-size: 28px;
}

/* Masaüstü Buton Metni */
.contact-item-text {
    font-size: 13px;
    font-weight: 500;
    color: #e5e7eb;
    white-space: nowrap;
}

/* Mobil Buton Stilleri */
.contact-item.mobile {
    flex-direction: row;
    gap: 0;
    border-right: none;
}
.contact-item.mobile:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Renkler */
.contact-item.whatsapp i { color: var(--whatsapp-color); }
.contact-item.phone i { color: var(--phone-color); }
.contact-item.email i { color: var(--email-color); }
.contact-item.location i { color: var(--location-color); }

/* Liste Görünümü (Birden fazla numara/mail olduğunda) */
.contact-list-view {
    flex-direction: column;
    align-items: stretch;
    justify-content: flex-start;
    padding: 0;
}
.contact-list-header {
    display: flex;
    align-items: center;
    padding: 0 0.5rem;
    height: 56px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    flex-shrink: 0;
}
.contact-back-button {
    background: transparent;
    border: none;
    color: #cbd5e1;
    cursor: pointer;
    padding: 0 1rem;
    font-size: 1.1rem;
    transition: color 0.2s;
}
.contact-back-button:hover {
    color: white;
}
.contact-list-title {
    font-size: 1rem;
    font-weight: 600;
    margin-left: 0.5rem;
    color: white;
}
.contact-list-items {
    display: flex;
    flex-direction: column;
    padding: 0.75rem;
    gap: 0.5rem;
}
.contact-list-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.85rem 1rem;
    border-radius: 0.6rem;
    color: white;
    text-decoration: none;
    background-color: rgba(255, 255, 255, 0.05);
    transition: background-color 0.2s;
}
.contact-list-item:hover {
    background-color: rgba(255, 255, 255, 0.15);
}
.contact-list-item span {
    flex-grow: 1;
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #e5e7eb;
}
.contact-list-item .fa-chevron-right {
    color: #6b7280;
    font-size: 0.8rem;
}
.contact-list-item i:first-child {
    width: 20px;
    text-align: center;
    transition: color 0.2s;
}
.contact-list-item.whatsapp i:first-child { color: var(--whatsapp-color); }
.contact-list-item.phone i:first-child { color: var(--phone-color); }
.contact-list-item.email i:first-child { color: var(--email-color); }

/* Mobil liste görünümü */
#contact-mobile-overlay {
    transition: opacity 0.3s ease;
}
#contact-mobile-overlay.hidden {
    opacity: 0;
    pointer-events: none;
}
#contact-mobile-sheet {
    transform: translateY(100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
#contact-mobile-overlay.is-open #contact-mobile-sheet {
    transform: translateY(0);
}
.contact-list-view.mobile {
    position: relative;
    background-color: rgba(30, 41, 59, 0.9);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-bottom: env(safe-area-inset-bottom, 1rem);
    display: none; /* Hide by default */
}
.contact-list-view.mobile.active {
    display: flex; /* Show only active list */
}
.contact-list-view.mobile .contact-list-header {
    justify-content: center;
}
.contact-list-view.mobile .contact-list-header .contact-list-title {
    margin-left: 0;
}
