<?php
require_once 'helper.php';

// Dinamik sayfa başlıkları
$page_title = 'Slider Yönetimi';
$page_subtitle = 'Tüm Slaytlar';

// Layout'un üst kısmını çağır
require_once __DIR__ . '/../tools/header.php';

// Gerekli verileri ve SEO durumunu hesapla
$sliderData = getSliderData();
$totalSlides = count($sliderData);

// H1 etiket sayısını say
$h1_count = 0;
foreach ($sliderData as $slide) {
    if (isset($slide['title_tag']) && $slide['title_tag'] === 'h1') {
        $h1_count++;
    }
}
?>

<!-- İstatistik ve SEO Durum Kartları -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Toplam Slayt Kartı -->
    <div class="bg-brand-paper p-5 rounded-2xl shadow-custom flex items-center gap-4">
        <div class="bg-brand-light-blue rounded-full p-3">
            <i class="fas fa-layer-group text-brand-purple text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-brand-gray">Toplam Slayt</p>
            <p class="text-2xl font-bold text-brand-navy"><?php echo $totalSlides; ?></p>
        </div>
    </div>
    <!-- SEO Durum Kartı -->
    <?php
        $seo_card_class = 'bg-brand-success'; // Varsayılan: Her şey yolunda
        $seo_icon = 'fa-check-circle';
        $seo_title = 'SEO Durumu Mükemmel';
        $seo_message = 'Slaytlarınızda 1 adet H1 etiketi bulunuyor.';

        if ($h1_count > 1) {
            $seo_card_class = 'bg-brand-danger';
            $seo_icon = 'fa-exclamation-triangle';
            $seo_title = 'SEO Uyarısı!';
            $seo_message = "Slaytlarınızda {$h1_count} adet H1 etiketi var. Bu durum SEO için olumsuzdur.";
        } elseif ($h1_count === 0) {
            $seo_card_class = 'bg-yellow-500';
            $seo_icon = 'fa-exclamation-circle';
            $seo_title = 'SEO Önerisi';
            $seo_message = 'Slaytlarınızda hiç H1 etiketi yok. En önemli slayta eklemeniz önerilir.';
        }
    ?>
    <div class="p-5 rounded-2xl shadow-custom flex items-center gap-4 <?php echo $seo_card_class; ?> text-white">
        <div class="bg-white/20 rounded-full p-3">
            <i class="fas <?php echo $seo_icon; ?> text-xl"></i>
        </div>
        <div>
            <p class="text-sm font-bold"><?php echo $seo_title; ?></p>
            <p class="text-xs opacity-90"><?php echo $seo_message; ?></p>
        </div>
    </div>
</div>

<!-- Slayt Listesi Kartı -->
<div class="bg-brand-paper p-6 md:p-8 rounded-2xl shadow-custom">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h3 class="text-xl font-bold text-brand-navy">Slayt Listesi</h3>
        <div class="flex items-center gap-3">
            <a href="ayarlar.php" class="flex items-center justify-center w-11 h-11 bg-brand-light-blue hover:bg-gray-200 text-brand-blue rounded-full transition-colors" title="Slider Ayarları">
                <i class="fas fa-cog text-lg"></i>
            </a>
            <a href="ekle.php" class="flex items-center gap-2 px-5 py-2.5 bg-brand-purple text-white font-semibold rounded-2xl shadow-sm hover:bg-purple-700 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Yeni Slayt Ekle</span>
            </a>
        </div>
    </div>

    <!-- Slayt Listesi -->
    <div id="slider-list" class="space-y-3">
        <?php if (empty($sliderData)): ?>
            <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                <i class="fas fa-photo-video fa-3x text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-brand-navy">Henüz Slayt Eklenmemiş</h3>
                <p class="text-brand-gray mt-1 mb-6">İlk slaytınızı ekleyerek başlayın.</p>
                <a href="ekle.php" class="inline-flex items-center px-5 py-2.5 bg-brand-purple text-white font-semibold rounded-2xl shadow-sm hover:bg-purple-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Yeni Slayt Ekle
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($sliderData as $index => $slide): ?>
                <div class="slider-item flex items-center gap-4 p-3 border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors" data-id="<?php echo $index; ?>">
                    <div class="handle text-brand-gray hover:text-brand-purple transition-colors p-2">
                        <i class="fas fa-grip-vertical fa-lg"></i>
                    </div>
                    <img src="<?php echo '../..' . htmlspecialchars($slide['image_url']); ?>" alt="Slayt Görseli" class="w-24 h-14 object-cover rounded-xl bg-gray-200 flex-shrink-0" onerror="this.onerror=null;this.src='https://placehold.co/96x56/E0E5F2/A3AED0?text=Hata';">
                    <div class="flex-grow min-w-0">
                        <h4 class="font-bold text-brand-navy truncate"><?php echo htmlspecialchars($slide['title'] ?: 'Başlıksız Slayt'); ?></h4>
                        <p class="text-sm text-brand-secondary-gray truncate"><?php echo htmlspecialchars($slide['description'] ?: 'Açıklama yok'); ?></p>
                    </div>
                    <?php if(isset($slide['title_tag']) && $slide['title_tag'] === 'h1'): ?>
                        <span class="bg-brand-purple text-white text-xs font-bold px-2.5 py-1 rounded-full flex-shrink-0" title="Bu slayt H1 etiketi kullanıyor">H1</span>
                    <?php endif; ?>
                    <div class="flex items-center gap-4 flex-shrink-0">
                        <a href="duzenle.php?id=<?php echo $index; ?>" class="text-brand-purple hover:text-purple-800 transition-colors" title="Düzenle"><i class="fas fa-edit fa-lg"></i></a>
                        <a href="sil.php?id=<?php echo $index; ?>" data-delete-url="sil.php?id=<?php echo $index; ?>" class="text-brand-danger hover:text-red-700 transition-colors delete-btn" title="Sil"><i class="fas fa-trash fa-lg"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('slider-list');
    if(list && list.children.length > 1) {
        new Sortable(list, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.handle',
            onEnd: function (evt) {
                const items = list.querySelectorAll('.slider-item');
                const newOrder = Array.from(items).map(item => item.getAttribute('data-id'));
                
                fetch('sirala.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order: newOrder }),
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) { console.error('Sıralama güncellenemedi.'); }
                }).catch(err => console.error('Sıralama isteği başarısız:', err));
            }
        });
    }
});
</script>

<?php
// Layout'un alt kısmını çağır
require_once __DIR__ . '/../tools/footer.php';
?>
