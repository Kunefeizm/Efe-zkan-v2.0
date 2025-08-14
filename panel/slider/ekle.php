<?php
require_once 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newSlide = $_POST['new_slide'];
    $newImage = $_FILES['new_slide_image'];
    $message = '';

    if (!empty($newImage['name']) && $newImage['error'] === 0) {
        $imageName = time() . '_' . preg_replace("/[^a-zA-Z0-9-_\.]/", "", basename($newImage['name']));
        
        if (move_uploaded_file($newImage['tmp_name'], UPLOAD_DIR . $imageName)) {
            $sliderData = getSliderData();
            $sliderData[] = [
                'title' => $newSlide['title'] ?? '',
                'title_tag' => $newSlide['title_tag'] ?? 'strong',
                'description' => $newSlide['description'] ?? '',
                'image_url' => UPLOAD_URL . $imageName
            ];
            saveSliderData($sliderData);
            header("Location: index.php?status=" . urlencode('Yeni slayt başarıyla eklendi.'));
            exit;
        } else {
            $message = 'Hata: Dosya yüklenemedi. Klasör yazma izinlerini kontrol edin.';
        }
    } else {
        $message = 'Hata: Lütfen geçerli bir görsel seçin.';
    }
    header("Location: ekle.php?status=" . urlencode($message));
    exit;
}

// Dinamik sayfa başlıkları
$page_title = 'Slider Yönetimi';
$page_subtitle = 'Yeni Slayt Ekle';

// Layout'un üst kısmını çağır
require_once __DIR__ . '/../tools/header.php';
?>

<!-- max-w-4xl'den max-w-7xl'ye değiştirildi. Bu, formun yanal uzunluğunu artırır. -->
<div class="bg-brand-paper p-6 md:p-8 rounded-2xl shadow-custom max-w-7xl mx-auto">
    <form action="ekle.php" method="post" enctype="multipart/form-data">
         <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-bold text-brand-navy mb-2">Başlık (İsteğe Bağlı)</label>
                <input id="title" type="text" name="new_slide[title]" placeholder="Slayt başlığını girin" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition">
            </div>
             <div>
                <label for="title_tag" class="block text-sm font-bold text-brand-navy mb-2">Başlık Türü (SEO için önemlidir)</label>
                <select id="title_tag" name="new_slide[title_tag]" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition appearance-none">
                    <option value="h1">Ana Başlık (H1 - Sayfada sadece bir tane olmalı)</option>
                    <option value="strong" selected>Vurgulu Başlık (Strong)</option>
                </select>
            </div>
            <div>
                <label for="description" class="block text-sm font-bold text-brand-navy mb-2">Açıklama (İsteğe Bağlı)</label>
                <textarea id="description" name="new_slide[description]" rows="4" placeholder="Slayt için kısa ve etkileyici bir açıklama girin" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition"></textarea>
            </div>
            <div>
                <label for="image" class="block text-sm font-bold text-brand-navy mb-2">Görsel (Zorunlu)</label>
                <input id="image" type="file" name="new_slide_image" required accept="image/jpeg, image/png, image/webp, image/gif" class="block w-full text-sm text-brand-secondary-gray file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-light-blue file:text-brand-purple hover:file:bg-purple-100 transition cursor-pointer">
                <p class="text-xs text-brand-gray mt-2">Önerilen boyut: 1920x1080 piksel. Desteklenen formatlar: JPG, PNG, WEBP, GIF.</p>
            </div>
            <div class="pt-4 flex items-center gap-4 border-t border-gray-200">
                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-brand-purple text-white font-semibold rounded-xl shadow-sm hover:bg-purple-700 transition-colors">
                    <i class="fas fa-plus"></i>Slaytı Ekle
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
