<?php
require_once 'helper.php';

$settings = getSliderSettings();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $settings['autoplay_delay'] = (int)($_POST['autoplay_delay'] ?? 5000);
    $settings['overlay_opacity'] = (float)($_POST['overlay_opacity'] ?? 0.3);
    
    saveSliderSettings($settings);
    
    header("Location: index.php?status=" . urlencode('Ayarlar başarıyla güncellendi.'));
    exit;
}

// Dinamik sayfa başlıkları
$page_title = 'Slider Yönetimi';
$page_subtitle = 'Genel Ayarlar';

// Layout'un üst kısmını çağır
require_once __DIR__ . '/../tools/header.php';
?>

<!-- max-w-4xl'den max-w-7xl'ye değiştirildi. Bu, formun yanal uzunluğunu artırır. -->
<div class="bg-brand-paper p-6 md:p-8 rounded-2xl shadow-custom max-w-7xl mx-auto">
    <form action="ayarlar.php" method="post">
         <div class="space-y-6">
            <div>
                <label for="autoplay_delay" class="block text-sm font-bold text-brand-navy mb-2">Otomatik Geçiş Süresi (milisaniye)</label>
                <input id="autoplay_delay" type="number" name="autoplay_delay" value="<?php echo htmlspecialchars($settings['autoplay_delay']); ?>" required placeholder="Örn: 5000" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition">
                <p class="text-xs text-brand-gray mt-2">Slaytların kaç milisaniyede bir değişeceğini belirtir. 1000 = 1 saniye.</p>
            </div>
             <div>
                <label for="overlay_opacity" class="block text-sm font-bold text-brand-navy mb-2">Görsel Üzeri Karartma (0 ile 1 arası)</label>
                <input id="overlay_opacity" type="number" step="0.1" min="0" max="1" name="overlay_opacity" value="<?php echo htmlspecialchars($settings['overlay_opacity']); ?>" required placeholder="Örn: 0.3" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition">
                <p class="text-xs text-brand-gray mt-2">Slayt görsellerinin üzerindeki siyah katmanın yoğunluğu. 0 = yok, 1 = tam siyah.</p>
            </div>
            <div class="pt-4 flex items-center gap-4 border-t border-gray-200">
                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-brand-purple text-white font-semibold rounded-xl shadow-sm hover:bg-purple-700 transition-colors">
                    <i class="fas fa-save"></i>Ayarları Kaydet
                </button>
                <a href="index.php" class="text-brand-secondary-gray hover:text-brand-navy font-semibold">İptal</a>
            </div>
        </div>
    </form>
</div>

<?php
// Layout'un alt kısmını çağır
require_once __DIR__ . '/../tools/footer.php';
?>
