<?php
require_once 'helper.php';

$slideId = isset($_GET['id']) ? (int)$_GET['id'] : -1;
$sliderData = getSliderData();

if ($slideId === -1 || !isset($sliderData[$slideId])) {
    header("Location: index.php?status=" . urlencode('Hata: Geçersiz slayt ID.'));
    exit;
}

$slide = $sliderData[$slideId];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updatedSlide = $_POST['slide'];
    $newImage = $_FILES['slide_image'];

    $sliderData[$slideId]['title'] = $updatedSlide['title'] ?? '';
    $sliderData[$slideId]['title_tag'] = $updatedSlide['title_tag'] ?? 'strong';
    $sliderData[$slideId]['description'] = $updatedSlide['description'] ?? '';

    // Eğer yeni bir görsel yüklendiyse...
    if (!empty($newImage['name']) && $newImage['error'] === 0) {
        $imageName = time() . '_' . preg_replace("/[^a-zA-Z0-9-_\.]/", "", basename($newImage['name']));
        
        if (move_uploaded_file($newImage['tmp_name'], UPLOAD_DIR . $imageName)) {
            deleteImage($sliderData[$slideId]['image_url']);
            $sliderData[$slideId]['image_url'] = UPLOAD_URL . $imageName;
        }
    }
    
    saveSliderData($sliderData);
    header("Location: index.php?status=" . urlencode('Slayt başarıyla güncellendi.'));
    exit;
}

// Dinamik sayfa başlıkları
$page_title = 'Slider Yönetimi';
$page_subtitle = 'Slayt Düzenle';

// Layout'un üst kısmını çağır
require_once __DIR__ . '/../tools/header.php';
?>

<!-- max-w-6xl'den max-w-7xl'ye değiştirildi. Bu, kartın yanal uzunluğunu artırır. -->
<div class="bg-brand-paper p-6 md:p-8 rounded-2xl shadow-custom max-w-7xl mx-auto">
    <form action="duzenle.php?id=<?php echo $slideId; ?>" method="post" enctype="multipart/form-data">
        <div class="grid md:grid-cols-3 gap-x-8 gap-y-6">
            
            <!-- Sol Sütun: Görsel Yükleyici -->
            <div class="md:col-span-1">
                <label class="block text-sm font-bold text-brand-navy mb-2">Slayt Görseli</label>
                <div id="image-upload-container" class="relative group cursor-pointer">
                    <img id="image-preview" src="<?php echo '../..' . htmlspecialchars($slide['image_url']); ?>" alt="Mevcut Görsel" class="w-full aspect-video object-cover rounded-xl bg-gray-200 border-2 border-dashed border-gray-300 group-hover:border-brand-purple transition-colors">
                    <div class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity rounded-xl">
                        <i class="fas fa-camera fa-2x"></i>
                        <span class="mt-2 font-semibold">Görseli Değiştir</span>
                    </div>
                </div>
                <input id="image-input" type="file" name="slide_image" accept="image/jpeg, image/png, image/webp, image/gif" class="hidden">
                <p class="text-xs text-brand-gray mt-2">Görseli değiştirmek için üzerine tıklayın. Önerilen boyut: 1920x1080px.</p>
            </div>

            <!-- Sağ Sütun: Form Alanları -->
            <div class="md:col-span-2 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-bold text-brand-navy mb-2">Başlık (İsteğe Bağlı)</label>
                    <input id="title" type="text" name="slide[title]" value="<?php echo htmlspecialchars($slide['title']); ?>" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition">
                </div>
                 <div>
                    <label for="title_tag" class="block text-sm font-bold text-brand-navy mb-2">Başlık Türü</label>
                    <select id="title_tag" name="slide[title_tag]" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition appearance-none">
                        <option value="h1" <?php if(isset($slide['title_tag']) && $slide['title_tag'] == 'h1') echo 'selected'; ?>>Ana Başlık (H1)</option>
                        <option value="strong" <?php if(!isset($slide['title_tag']) || $slide['title_tag'] == 'strong') echo 'selected'; ?>>Vurgulu Başlık (Strong)</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="block text-sm font-bold text-brand-navy mb-2">Açıklama (İsteğe Bağlı)</label>
                    <textarea id="description" name="slide[description]" rows="5" class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition"><?php echo htmlspecialchars($slide['description']); ?></textarea>
                </div>
            </div>
        </div>

        <!-- Form Butonları -->
        <div class="pt-6 mt-6 flex items-center gap-4 border-t border-gray-200">
            <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-brand-purple text-white font-semibold rounded-xl shadow-sm hover:bg-purple-700 transition-colors">
                <i class="fas fa-save"></i>Değişiklikleri Kaydet
            </button>
            <a href="index.php" class="text-brand-secondary-gray hover:text-brand-navy font-semibold">İptal</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const uploadContainer = document.getElementById('image-upload-container');
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');

    uploadContainer.addEventListener('click', () => { imageInput.click(); });

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];
        if (file) { imagePreview.src = URL.createObjectURL(file); }
    });
});
</script>

<?php
require_once __DIR__ . '/../tools/footer.php';
?>
