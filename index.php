<?php
    // Panel ile entegrasyon için helper dosyalarını dahil et
    require_once 'panel/slider/helper.php';
    require_once 'panel/iletisim/helper.php'; // İletişim verileri için eklendi

    // tools/ klasöründeki head.php dosyasını dahil et
    include 'tools/head.php';
    // tools/ klasöründeki navbar.php dosyasını dahil et
    include 'tools/navbar.php';

    // Panelden verileri çek
    $fullData = getFullData();
    $sliderData = $fullData['slides'] ?? [];
    $sliderSettings = $fullData['settings'] ?? [];
    $contactData = getContactData(); // İletişim verileri çekildi
?>
    <main>
        <!-- ========== SLIDER ========== -->
        <?php if (!empty($sliderData)): ?>
        <section id="slider" class="relative">
            <div class="swiper main-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($sliderData as $slide): ?>
                    <?php
                        // Başlık etiketini belirle, eğer tanımlı değilse varsayılan olarak 'strong' kullan
                        $titleTag = $slide['title_tag'] ?? 'strong';
                    ?>
                    <!-- Slayt -->
                    <div class="swiper-slide" style="background-image: url('<?php echo htmlspecialchars($slide['image_url']); ?>');">
                        <!-- Panelden gelen opaklık ayarı için overlay eklendi -->
                        <div class="absolute inset-0 bg-black" style="opacity: <?php echo htmlspecialchars($sliderSettings['overlay_opacity'] ?? 0.3); ?>"></div>
                        <div class="slide-content relative z-10">
                            <<?php echo $titleTag; ?> class="text-4xl md:text-6xl font-extrabold mb-4"><?php echo htmlspecialchars($slide['title']); ?></<?php echo $titleTag; ?>>
                            <p class="max-w-2xl mx-auto"><?php echo htmlspecialchars($slide['description']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Sayfalama Ekle -->
                <div class="swiper-pagination"></div>
                <!-- Navigasyon Ekle -->
                <div class="swiper-button-next text-white"></div>
                <div class="swiper-button-prev text-white"></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ========== HAKKIMIZDA ========== -->
        <section id="hakkimizda" class="section-padding bg-white">
            <div class="container-custom grid md:grid-cols-2 gap-12 items-center">
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://placehold.co/600x400/e2e8f0/334155?text=Hakkımızda+Görseli" alt="Hakkımızda" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Biz Kimiz?</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero.
                    </p>
                    <a href="/hakkimizda" class="inline-block mt-6 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">Daha Fazla Bilgi Edinin</a>
                </div>
            </div>
        </section>

        <!-- ========== HİZMETLERİMİZ ========== -->
        <section id="hizmetler" class="section-padding">
            <div class="container-custom">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Hizmetlerimiz</h2>
                    <p class="text-gray-600 mt-2">Sunduğumuz profesyonel çözümler</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Hizmet Kartı 1 -->
                    <a href="#" class="blog-card bg-white rounded-lg shadow-md overflow-hidden block group">
                        <img src="https://placehold.co/600x400/a5b4fc/1e1b4b?text=Web+Tasarım" alt="Web Tasarım" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Web Tasarım</h3>
                            <p class="text-gray-600 mb-4">Modern, mobil uyumlu ve kullanıcı odaklı web siteleri tasarlıyoruz.</p>
                            <span class="font-semibold text-blue-600 group-hover:underline">Detayları Gör &rarr;</span>
                        </div>
                    </a>
                    <!-- Hizmet Kartı 2 -->
                    <a href="#" class="blog-card bg-white rounded-lg shadow-md overflow-hidden block group">
                        <img src="https://placehold.co/600x400/a7f3d0/052e16?text=Dijital+Pazarlama" alt="Dijital Pazarlama" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Dijital Pazarlama</h3>
                            <p class="text-gray-600 mb-4">Marka bilinirliğinizi artırmak için etkili dijital pazarlama stratejileri.</p>
                            <span class="font-semibold text-blue-600 group-hover:underline">Detayları Gör &rarr;</span>
                        </div>
                    </a>
                    <!-- Hizmet Kartı 3 -->
                    <a href="#" class="blog-card bg-white rounded-lg shadow-md overflow-hidden block group">
                        <img src="https://placehold.co/600x400/f9a8d4/500724?text=Mobil+Uygulama" alt="Mobil Uygulama" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mobil Uygulama</h3>
                            <p class="text-gray-600 mb-4">iOS ve Android platformları için yenilikçi mobil uygulamalar geliştiriyoruz.</p>
                            <span class="font-semibold text-blue-600 group-hover:underline">Detayları Gör &rarr;</span>
                        </div>
                    </a>
                </div>
                <div class="text-center mt-12">
                    <a href="/hizmetlerimiz" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">Tüm Hizmetleri Gör</a>
                </div>
            </div>
        </section>

        <!-- ========== REFERANSLAR ========== -->
        <section id="referanslar" class="section-padding bg-gray-100">
            <div class="container-custom">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Referanslar</h2>
                    <p class="text-gray-600 mt-2">Müşterilerimizden gelen yorumlar</p>
                </div>
                <div class="swiper testimonials-slider">
                    <div class="swiper-wrapper">
                        <!-- Müşteri Yorumu 1 -->
                        <div class="swiper-slide">
                            <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto text-center">
                                <p class="text-gray-600 italic mb-4">"Harika bir ekip! Projemizi zamanında ve beklentilerimizin üzerinde bir kalitede teslim ettiler. Kesinlikle tavsiye ederim."</p>
                                <img src="https://placehold.co/80x80/c7d2fe/3730a3?text=AY" alt="Müşteri" class="w-16 h-16 rounded-full mx-auto mb-2">
                                <h4 class="font-bold text-gray-800">Ayşe Yılmaz</h4>
                                <p class="text-sm text-gray-500">CEO, Teknoloji A.Ş.</p>
                            </div>
                        </div>
                        <!-- Müşteri Yorumu 2 -->
                        <div class="swiper-slide">
                            <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto text-center">
                                <p class="text-gray-600 italic mb-4">"Dijital pazarlama konusundaki uzmanlıkları sayesinde satışlarımızda gözle görülür bir artış yaşadık. Teşekkürler!"</p>
                                <img src="https://placehold.co/80x80/bbf7d0/166534?text=MK" alt="Müşteri" class="w-16 h-16 rounded-full mx-auto mb-2">
                                <h4 class="font-bold text-gray-800">Mehmet Kaya</h4>
                                <p class="text-sm text-gray-500">Pazarlama Müdürü, E-Ticaret Ltd.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination mt-8 !relative"></div>
                </div>
            </div>
        </section>

        <!-- ========== BLOG ========== -->
        <section id="blog" class="section-padding bg-white">
            <div class="container-custom">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Blog</h2>
                    <p class="text-gray-600 mt-2">Sektörden en son haberler ve makaleler</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Blog Kartı 1 -->
                    <a href="#" class="blog-card bg-white rounded-lg shadow-md overflow-hidden block group">
                        <img src="https://placehold.co/600x400/a5b4fc/1e1b4b?text=Blog+1" alt="Blog Yazısı" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Web Tasarımında 2024 Trendleri</h3>
                            <p class="text-gray-600 mb-4">Minimalizm, koyu mod ve yapay zeka entegrasyonları hakkında her şey.</p>
                            <span class="font-semibold text-blue-600 group-hover:underline">Devamını Oku &rarr;</span>
                        </div>
                    </a>
                    <!-- Blog Kartı 2 -->
                    <a href="#" class="blog-card bg-white rounded-lg shadow-md overflow-hidden block group">
                        <img src="https://placehold.co/600x400/a7f3d0/052e16?text=Blog+2" alt="Blog Yazısı" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">SEO'nun Altın Kuralları</h3>
                            <p class="text-gray-600 mb-4">Arama motorlarında üst sıralara çıkmak için bilmeniz gerekenler.</p>
                            <span class="font-semibold text-blue-600 group-hover:underline">Devamını Oku &rarr;</span>
                        </div>
                    </a>
                    <!-- Blog Kartı 3 -->
                    <a href="#" class="blog-card bg-white rounded-lg shadow-md overflow-hidden block group">
                        <img src="https://placehold.co/600x400/f9a8d4/500724?text=Blog+3" alt="Blog Yazısı" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mobil Uygulama Geliştirme Süreci</h3>
                            <p class="text-gray-600 mb-4">Fikirden App Store'a uzanan yolculuk ve dikkat edilmesi gerekenler.</p>
                            <span class="font-semibold text-blue-600 group-hover:underline">Devamını Oku &rarr;</span>
                        </div>
                    </a>
                </div>
                <div class="text-center mt-12">
                    <a href="/blog" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">Tüm Blog Yazılarını Gör</a>
                </div>
            </div>
        </section>

        <!-- ========== GALERİ ========== -->
        <section id="galeri" class="section-padding">
            <div class="container-custom">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Galeri</h2>
                    <p class="text-gray-600 mt-2">Projelerimizden ve ekibimizden kareler</p>
                </div>
                <div id="lightgallery" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="https://placehold.co/1200x800/93c5fd/1e3a8a?text=Galeri+1" class="group block overflow-hidden rounded-lg">
                        <img src="https://placehold.co/600x400/93c5fd/1e3a8a?text=Galeri+1" alt="Galeri 1" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    </a>
                    <a href="https://placehold.co/1200x800/6ee7b7/064e3b?text=Galeri+2" class="group block overflow-hidden rounded-lg">
                        <img src="https://placehold.co/600x400/6ee7b7/064e3b?text=Galeri+2" alt="Galeri 2" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    </a>
                    <a href="https://placehold.co/1200x800/fca5a5/7f1d1d?text=Galeri+3" class="group block overflow-hidden rounded-lg">
                        <img src="https://placehold.co/600x400/fca5a5/7f1d1d?text=Galeri+3" alt="Galeri 3" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    </a>
                    <a href="https://placehold.co/1200x800/c4b5fd/4c1d95?text=Galeri+4" class="group block overflow-hidden rounded-lg">
                        <img src="https://placehold.co/600x400/c4b5fd/4c1d95?text=Galeri+4" alt="Galeri 4" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    </a>
                </div>
                <div class="text-center mt-12">
                    <a href="/galeri" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">Tüm Galeriye Git</a>
                </div>
            </div>
        </section>

        <!-- ========== İLETİŞİM (DİNAMİK) ========== -->
        <section id="iletisim" class="section-padding bg-white">
            <div class="container-custom">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">İletişim</h2>
                    <p class="text-gray-600 mt-2">Sorularınız için her zaman buradayız.</p>
                    
                    <!-- YENİ: Açık Adres Alanı -->
                    <?php if (!empty($contactData['address'])): ?>
                    <div class="mt-4 max-w-2xl mx-auto">
                        <p class="text-gray-700 flex items-center justify-center gap-2">
                            <i class="fas fa-map-marker-alt text-gray-500"></i>
                            <span><?php echo nl2br(htmlspecialchars($contactData['address'])); ?></span>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php
                    // Gösterilecek iletişim kartlarını bir dizide topla
                    $contact_cards = [];
                    if (!empty($contactData['phones'])) {
                        $contact_cards[] = [
                            'type' => 'phone', 'icon' => 'fas fa-phone', 'color' => 'blue',
                            'title' => 'Telefon', 'text' => htmlspecialchars($contactData['phones'][0]['number']),
                            'href' => 'tel:' . htmlspecialchars(preg_replace('/[^0-9+]/', '', $contactData['phones'][0]['number']))
                        ];
                    }
                    if (!empty($contactData['whatsapps'])) {
                        $contact_cards[] = [
                            'type' => 'whatsapp', 'icon' => 'fab fa-whatsapp', 'color' => 'green',
                            'title' => 'WhatsApp', 'text' => 'Hemen Mesaj Atın',
                            'href' => 'https://wa.me/' . htmlspecialchars(preg_replace('/[^0-9]/', '', $contactData['whatsapps'][0]['number']))
                        ];
                    }
                    if (!empty($contactData['emails'])) {
                        $contact_cards[] = [
                            'type' => 'email', 'icon' => 'fas fa-envelope', 'color' => 'red',
                            'title' => 'E-Posta', 'text' => htmlspecialchars($contactData['emails'][0]),
                            'href' => 'mailto:' . htmlspecialchars($contactData['emails'][0])
                        ];
                    }
                ?>

                <?php if (!empty($contact_cards)): ?>
                <div class="grid grid-cols-1 md:grid-cols-<?php echo count($contact_cards); ?> gap-8 mb-12">
                    <?php foreach ($contact_cards as $card): ?>
                    <a href="<?php echo $card['href']; ?>" <?php if($card['type'] === 'whatsapp') echo 'target="_blank"'; ?> class="group block bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-<?php echo $card['color']; ?>-400">
                        <div class="p-6 text-center">
                            <i class="<?php echo $card['icon']; ?> mx-auto text-<?php echo $card['color']; ?>-600 text-4xl mb-4 group-hover:scale-110 transition-transform duration-300"></i>
                            <h3 class="font-bold text-lg text-gray-800 mb-2"><?php echo $card['title']; ?></h3>
                            <p class="text-gray-600"><?php echo $card['text']; ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($contactData['map_embed_url'])): ?>
                <div class="w-full h-96 rounded-lg overflow-hidden shadow-md">
                    <iframe 
                        src="<?php echo htmlspecialchars($contactData['map_embed_url']); ?>" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
<?php
    // tools/ klasöründeki diğer dosyaları dahil et
    include 'tools/button.php';
    include 'tools/footer.php';
?>
<!-- Swiper.js'i panelden gelen ayarlarla başlatmak için script -->
<script>
    // Ana slider'ı başlatırken paneldeki ayarları kullan
    const mainSlider = new Swiper('.main-slider', {
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        loop: true,
        autoplay: {
            delay: <?php echo htmlspecialchars($sliderSettings['autoplay_delay'] ?? 5000); ?>,
            disableOnInteraction: false,
        },
    });

    // Referans slider'ını başlat
    const testimonialsSlider = new Swiper('.testimonials-slider', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
        },
    });

    // LightGallery'yi başlat
    // Not: lgZoom ve lgThumbnail eklentilerinin head.php içinde yüklendiğinden emin olun.
    if (typeof lightGallery !== 'undefined') {
        lightGallery(document.getElementById('lightgallery'), {
            plugins: (typeof lgThumbnail !== 'undefined') ? [lgThumbnail] : [],
            speed: 500,
        });
    }
</script>
