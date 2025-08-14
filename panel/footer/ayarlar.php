<?php
require_once 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posted = $_POST['footer'];
    $newData = getFooterData();

    // Genel metinleri ve logo seçimini güncelle
    $newData['description'] = $posted['description'] ?? '';
    $newData['copyright'] = $posted['copyright'] ?? '';
    $newData['logo']['choice'] = $posted['logo']['choice'] ?? 'light';

    // Dinamik sosyal medya linklerini işle
    $newData['socials'] = [];
    if (!empty($posted['socials'])) {
        foreach ($posted['socials'] as $social) {
            if (!empty(trim($social['icon'])) && !empty(trim($social['url']))) {
                $newData['socials'][] = [
                    'icon' => trim($social['icon']),
                    'url' => trim($social['url'])
                ];
            }
        }
    }

    saveFooterData($newData);
    header("Location: ayarlar.php?status=" . urlencode('Genel ayarlar başarıyla güncellendi.'));
    exit;
}

$footerData = getFooterData();
$page_title = 'Footer Yönetimi';
$page_subtitle = 'Genel Ayarlar ve Sosyal Medya';
require_once __DIR__ . '/../tools/header.php';
?>

<form action="ayarlar.php" method="post">
    <div class="space-y-8">
        <!-- Genel Metinler ve Logo Seçimi -->
        <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
            <h3 class="text-xl font-bold text-brand-navy mb-4">Genel Metinler ve Logo</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="desc" class="block text-sm font-bold text-brand-navy mb-2">Kısa Açıklama</label>
                    <textarea id="desc" name="footer[description]" rows="3" class="input-style"><?php echo htmlspecialchars($footerData['description']); ?></textarea>
                </div>
                <div>
                    <label for="copyright" class="block text-sm font-bold text-brand-navy mb-2">Copyright Metni</label>
                    <input id="copyright" type="text" name="footer[copyright]" value="<?php echo htmlspecialchars($footerData['copyright']); ?>" class="input-style">
                </div>
                <div class="md:col-span-2">
                    <label for="logo_choice" class="block text-sm font-bold text-brand-navy mb-2">Footer'da Gösterilecek Logo</label>
                    <select id="logo_choice" name="footer[logo][choice]" class="input-style">
                        <option value="light" <?php echo ($footerData['logo']['choice'] ?? 'light') === 'light' ? 'selected' : ''; ?>>Açık Renk Logo (Genellikle koyu zeminler için)</option>
                        <option value="default" <?php echo ($footerData['logo']['choice'] ?? '') === 'default' ? 'selected' : ''; ?>>Varsayılan Logo (Genellikle açık zeminler için)</option>
                    </select>
                    <p class="text-xs text-brand-gray mt-2">Logoların kendisi <a href="../ayarlar/" class="text-brand-purple font-semibold hover:underline">Genel Ayarlar</a> sayfasından yönetilir.</p>
                </div>
            </div>
        </div>

        <!-- Dinamik Sosyal Medya -->
        <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-brand-navy">Sosyal Medya Linkleri</h3>
                <button type="button" id="add-social" class="btn-primary-sm"><i class="fas fa-plus"></i> Link Ekle</button>
            </div>
            <div id="socials-container" class="space-y-3">
                <?php foreach($footerData['socials'] as $s_idx => $social): ?>
                <div class="social-item flex items-center gap-2 p-2 border rounded-xl bg-gray-50">
                    <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i>
                    <input type="text" name="footer[socials][<?php echo $s_idx; ?>][icon]" value="<?php echo htmlspecialchars($social['icon']); ?>" placeholder="Font Awesome İkon Sınıfı (örn: fab fa-facebook-f)" class="input-style">
                    <input type="url" name="footer[socials][<?php echo $s_idx; ?>][url]" value="<?php echo htmlspecialchars($social['url']); ?>" placeholder="URL (örn: https://facebook.com/profil)" class="input-style">
                    <button type="button" class="remove-item text-brand-danger hover:text-red-700 p-2" title="Linki Sil"><i class="fas fa-trash"></i></button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="pt-6 mt-6 flex items-center gap-4 border-t border-gray-200">
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Ayarları Kaydet</button>
        <a href="index.php" class="text-brand-secondary-gray hover:text-brand-navy font-semibold">İptal</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const socialsContainer = document.getElementById('socials-container');

    const reindexSocials = () => {
        const items = socialsContainer.querySelectorAll('.social-item');
        items.forEach((item, index) => {
            item.querySelector('input[name*="[icon]"]').name = `footer[socials][${index}][icon]`;
            item.querySelector('input[name*="[url]"]').name = `footer[socials][${index}][url]`;
        });
    };

    new Sortable(socialsContainer, {
        animation: 150,
        handle: '.handle',
        ghostClass: 'sortable-ghost',
        onEnd: reindexSocials
    });

    document.getElementById('add-social').addEventListener('click', () => {
        const newSocialHTML = `
            <div class="social-item flex items-center gap-2 p-2 border rounded-xl bg-gray-50">
                <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i>
                <input type="text" name="" placeholder="Font Awesome İkon Sınıfı (örn: fab fa-twitter)" class="input-style">
                <input type="url" name="" placeholder="URL (örn: https://twitter.com/profil)" class="input-style">
                <button type="button" class="remove-item text-brand-danger hover:text-red-700 p-2" title="Linki Sil"><i class="fas fa-trash"></i></button>
            </div>`;
        socialsContainer.insertAdjacentHTML('beforeend', newSocialHTML);
        reindexSocials();
    });

    socialsContainer.addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('.social-item').remove();
            reindexSocials();
        }
    });
});
</script>
<style>.input-style{display:block;width:100%;background-color:#F4F7FE;border:1px solid #E0E5F2;border-radius:.75rem;padding:.75rem 1rem;transition:all .2s}.input-style:focus{outline:none;box-shadow:0 0 0 2px #4318FF;border-color:#4318FF}.btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.75rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s}.btn-primary:hover{background-color:#3715d8}.btn-primary-sm{display:inline-flex;align-items:center;gap:.5rem;padding:.5rem 1rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.5rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s;font-size:.875rem}.btn-primary-sm:hover{background-color:#3715d8}</style>

<?php require_once __DIR__ . '/../tools/footer.php'; ?>
