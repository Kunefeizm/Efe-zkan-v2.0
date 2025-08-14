<?php
require_once 'helper.php';

$settings = getSiteSettings();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posted = $_POST['settings'];
    $settings['seo'] = $posted['seo'];
    $settings['logo']['type'] = $posted['logo']['type'];
    $settings['logo']['text'] = $posted['logo']['text'];
    $settings['logo']['color_light'] = $posted['logo']['color_light'];
    $settings['logo']['color_dark'] = $posted['logo']['color_dark'];

    $logo_files = $_FILES['logos'];
    if (!empty($logo_files['name']['image_default']) && $logo_files['error']['image_default'] === 0) {
        deleteSiteImage($settings['logo']['image_default']);
        $name = 'logo_default_' . time() . '_' . basename($logo_files['name']['image_default']);
        move_uploaded_file($logo_files['tmp_name']['image_default'], SETTINGS_UPLOAD_DIR . $name);
        $settings['logo']['image_default'] = SETTINGS_UPLOAD_URL . $name;
    }
    if (!empty($logo_files['name']['image_light']) && $logo_files['error']['image_light'] === 0) {
        deleteSiteImage($settings['logo']['image_light']);
        $name = 'logo_light_' . time() . '_' . basename($logo_files['name']['image_light']);
        move_uploaded_file($logo_files['tmp_name']['image_light'], SETTINGS_UPLOAD_DIR . $name);
        $settings['logo']['image_light'] = SETTINGS_UPLOAD_URL . $name;
    }
    
    // --- FAVICON YÜKLEME MANTIĞI GÜNCELLENDİ ---
    $favicon_file = $_FILES['favicon'];
    if (!empty($favicon_file['name']) && $favicon_file['error'] === 0) {
        // 1. Önceki favicon'u sil
        if (!empty($settings['favicon_url'])) {
            // Dosyanın tam sunucu yolunu oluştur
            $old_favicon_path = realpath(IMAGES_DIR . basename($settings['favicon_url']));
            if ($old_favicon_path && file_exists($old_favicon_path)) {
                unlink($old_favicon_path);
            }
        }
        
        // 2. Yeni favicon'u /images/ klasörüne yükle
        $name = 'favicon_' . time() . '_' . preg_replace("/[^a-zA-Z0-9-_\.]/", "", basename($favicon_file['name']));
        move_uploaded_file($favicon_file['tmp_name'], IMAGES_DIR . $name);
        $settings['favicon_url'] = IMAGES_URL . $name;
    }

    saveSiteSettings($settings);
    header("Location: index.php?status=" . urlencode('Genel ayarlar başarıyla güncellendi.'));
    exit;
}

$page_title = 'Site Ayarları';
$page_subtitle = 'Genel Ayarlar';
require_once __DIR__ . '/../tools/header.php';
?>

<form action="index.php" method="post" enctype="multipart/form-data">
    <div class="space-y-8">
        <!-- Site Kimliği & Logo -->
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
                    <h3 class="text-xl font-bold text-brand-navy mb-4">Site Kimliği & SEO</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="seo_title" class="label-style">Site Başlığı</label>
                            <input id="seo_title" type="text" name="settings[seo][title]" value="<?php echo htmlspecialchars($settings['seo']['title']); ?>" class="input-style">
                        </div>
                        <div>
                            <label for="seo_desc" class="label-style">Meta Açıklaması</label>
                            <textarea id="seo_desc" name="settings[seo][description]" rows="3" class="input-style"><?php echo htmlspecialchars($settings['seo']['description']); ?></textarea>
                        </div>
                        <div>
                            <label class="label-style">Favicon</label>
                            <input type="file" name="favicon" class="input-file-style" accept="image/png, image/x-icon, image/svg+xml">
                            <?php if ($settings['favicon_url']): ?><img src="<?php echo '../..' . htmlspecialchars($settings['favicon_url']); ?>" class="mt-2 h-8 w-8 object-contain bg-gray-200 p-1 rounded"><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 bg-brand-paper p-6 rounded-2xl shadow-custom">
                <h3 class="text-xl font-bold text-brand-navy mb-4">Logo Ayarları</h3>
                <div class="space-y-4">
                     <div>
                        <label class="label-style">Kullanılacak Logo Türü</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="settings[logo][type]" value="text" class="form-radio" <?php if ($settings['logo']['type'] == 'text') echo 'checked'; ?>> Metin Logo</label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="settings[logo][type]" value="image" class="form-radio" <?php if ($settings['logo']['type'] == 'image') echo 'checked'; ?>> Görsel Logo</label>
                        </div>
                    </div>
                    <div id="logo-text-fields" class="p-4 border rounded-xl space-y-4">
                        <h4 class="font-bold text-brand-navy">Metin Logo Ayarları</h4>
                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <label for="logo_text" class="label-style">Logo Metni</label>
                                <input id="logo_text" type="text" name="settings[logo][text]" value="<?php echo htmlspecialchars($settings['logo']['text']); ?>" class="input-style">
                            </div>
                            <div>
                                <label for="logo_color_light" class="label-style">Açık Renk (Koyu Zeminde)</label>
                                <input id="logo_color_light" type="color" name="settings[logo][color_light]" value="<?php echo htmlspecialchars($settings['logo']['color_light']); ?>" class="w-full h-11 p-1 bg-white border rounded-lg cursor-pointer">
                            </div>
                            <div>
                                <label for="logo_color_dark" class="label-style">Koyu Renk (Açık Zeminde)</label>
                                <input id="logo_color_dark" type="color" name="settings[logo][color_dark]" value="<?php echo htmlspecialchars($settings['logo']['color_dark']); ?>" class="w-full h-11 p-1 bg-white border rounded-lg cursor-pointer">
                            </div>
                        </div>
                    </div>
                    <div id="logo-image-fields" class="p-4 border rounded-xl space-y-4">
                        <h4 class="font-bold text-brand-navy">Görsel Logo Ayarları</h4>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-style">Beyaz Logo (Üst)</label>
                                <input type="file" name="logos[image_light]" class="input-file-style">
                                <?php if ($settings['logo']['image_light']): ?><img src="<?php echo '../..' . htmlspecialchars($settings['logo']['image_light']); ?>" class="mt-2 h-8 bg-gray-800 p-1 rounded"><?php endif; ?>
                            </div>
                            <div>
                                <label class="label-style">Varsayılan Logo (Genel)</label>
                                <input type="file" name="logos[image_default]" class="input-file-style">
                                <?php if ($settings['logo']['image_default']): ?><img src="<?php echo '../..' . htmlspecialchars($settings['logo']['image_default']); ?>" class="mt-2 h-8 bg-gray-200 p-1 rounded"><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-8 text-right">
        <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Tüm Ayarları Kaydet</button>
    </div>
</form>

<style>.label-style{display:block;font-size:0.875rem;font-weight:700;color:#1B2559;margin-bottom:0.5rem}.input-style{width:100%;background-color:#F4F7FE;border:1px solid #E0E5F2;border-radius:0.75rem;padding:0.75rem 1rem;transition:all .2s}.input-style:focus{outline:none;box-shadow:0 0 0 2px #4318FF;border-color:#4318FF}.input-file-style{width:100%;font-size:.875rem;color:#707EAE;file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-semibold file:bg-brand-light-blue file:text-brand-purple hover:file:bg-purple-100}.btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding: .75rem 1.5rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.75rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s}.btn-primary:hover{background-color:#3715d8}.form-radio{color:#4318FF;focus:ring-brand-purple}</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const logoTypeRadios = document.querySelectorAll('input[name="settings[logo][type]"]');
    const textFields = document.getElementById('logo-text-fields');
    const imageFields = document.getElementById('logo-image-fields');
    function toggleLogoFields() {
        if (document.querySelector('input[name="settings[logo][type]"]:checked').value === 'text') {
            textFields.style.display = 'block';
            imageFields.style.display = 'none';
        } else {
            textFields.style.display = 'none';
            imageFields.style.display = 'block';
        }
    }
    logoTypeRadios.forEach(radio => radio.addEventListener('change', toggleLogoFields));
    toggleLogoFields();
});
</script>

<?php
require_once __DIR__ . '/../tools/footer.php';
?>
