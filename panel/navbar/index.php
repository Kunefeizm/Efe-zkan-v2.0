<?php
require_once 'helper.php';

$navbarData = getNavbarData();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posted_data = $_POST['navbar'];
    
    // Menü elemanlarını işle (boş olanları kaydetme)
    $menu_items = [];
    if (isset($posted_data['menu_items'])) {
        foreach ($posted_data['menu_items'] as $item) {
            if (!empty($item['label']) && !empty($item['url'])) {
                $menu_items[] = $item;
            }
        }
    }
    $navbarData['menu_items'] = $menu_items;

    saveNavbarData($navbarData);
    header("Location: index.php?status=" . urlencode('Navbar linkleri başarıyla güncellendi.'));
    exit;
}

$page_title = 'Site Ayarları';
$page_subtitle = 'Navbar Link Yönetimi';
require_once __DIR__ . '/../tools/header.php';
?>

<form action="index.php" method="post">
    <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-brand-navy">Menü Linkleri</h3>
            <button type="button" id="add-menu-item" class="btn-primary-sm"><i class="fas fa-plus mr-2"></i>Link Ekle</button>
        </div>
        <p class="text-sm text-brand-gray mb-4">Sitenin ana menüsünde görünecek linkleri buradan yönetebilirsiniz. Logo ve site kimliği için <a href="../ayarlar/" class="text-brand-purple font-semibold hover:underline">Genel Ayarlar</a> sayfasına gidin.</p>
        <div id="menu-items-container" class="space-y-3">
            <?php foreach ($navbarData['menu_items'] as $index => $item): ?>
                <div class="menu-item flex items-center gap-3 p-3 border rounded-xl">
                    <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab"></i>
                    <input type="text" name="navbar[menu_items][<?php echo $index; ?>][label]" value="<?php echo htmlspecialchars($item['label']); ?>" placeholder="Etiket (Örn: Anasayfa)" class="input-style flex-1">
                    <input type="text" name="navbar[menu_items][<?php echo $index; ?>][url]" value="<?php echo htmlspecialchars($item['url']); ?>" placeholder="URL (Örn: #anasayfa)" class="input-style flex-1">
                    <button type="button" class="remove-menu-item text-brand-danger hover:text-red-700"><i class="fas fa-trash"></i></button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="mt-8 text-right">
        <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Linkleri Kaydet</button>
    </div>
</form>

<style>.input-style{width:100%;background-color:#F4F7FE;border:1px solid #E0E5F2;border-radius:0.75rem;padding:0.75rem 1rem;transition:all .2s}.input-style:focus{ring:2px;ring-color:#4318FF;border-color:#4318FF}.btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding: .75rem 1.5rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.75rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s}.btn-primary:hover{background-color:#3715d8}.btn-primary-sm{padding:.5rem 1rem;font-size:.875rem;border-radius:.5rem;gap:.4rem;}</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('menu-items-container');
    let itemIndex = <?php echo count($navbarData['menu_items']); ?>;
    document.getElementById('add-menu-item').addEventListener('click', () => {
        const newItem = `<div class="menu-item flex items-center gap-3 p-3 border rounded-xl"><i class="fas fa-grip-vertical handle text-brand-gray cursor-grab"></i><input type="text" name="navbar[menu_items][${itemIndex}][label]" placeholder="Etiket" class="input-style flex-1"><input type="text" name="navbar[menu_items][${itemIndex}][url]" placeholder="URL" class="input-style flex-1"><button type="button" class="remove-menu-item text-brand-danger hover:text-red-700"><i class="fas fa-trash"></i></button></div>`;
        container.insertAdjacentHTML('beforeend', newItem);
        itemIndex++;
    });
    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-menu-item')) {
            e.target.closest('.menu-item').remove();
        }
    });
    new Sortable(container, { animation: 150, handle: '.handle' });
});
</script>

<?php
require_once __DIR__ . '/../tools/footer.php';
?>
