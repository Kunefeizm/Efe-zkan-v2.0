<?php
require_once 'helper.php';

$columnIndex = isset($_GET['id']) ? (int)$_GET['id'] : -1;
$data = getFooterData();

if ($columnIndex === -1 || !isset($data['link_columns'][$columnIndex])) {
    header("Location: index.php?status=" . urlencode('Hata: Geçersiz sütun.'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posted = $_POST['column'];
    $data['link_columns'][$columnIndex]['title'] = trim($posted['title'] ?? '');
    
    $newLinks = [];
    if (!empty($posted['links'])) {
        foreach($posted['links'] as $link) {
            if (!empty(trim($link['label'])) && !empty(trim($link['url']))) {
                $newLinks[] = [
                    'label' => trim($link['label']),
                    'url' => trim($link['url'])
                ];
            }
        }
    }
    $data['link_columns'][$columnIndex]['links'] = $newLinks;
    
    saveFooterData($data);
    header("Location: duzenle.php?id=$columnIndex&status=" . urlencode('Sütun başarıyla güncellendi.'));
    exit;
}

$column = $data['link_columns'][$columnIndex];
$page_title = 'Footer Yönetimi';
$page_subtitle = 'Sütun Düzenle: ' . htmlspecialchars($column['title']);
require_once __DIR__ . '/../tools/header.php';
?>

<form action="duzenle.php?id=<?php echo $columnIndex; ?>" method="post">
    <div class="bg-brand-paper p-6 md:p-8 rounded-2xl shadow-custom">
        <div class="mb-6">
            <label for="title" class="block text-sm font-bold text-brand-navy mb-2">Sütun Başlığı</label>
            <input id="title" type="text" name="column[title]" value="<?php echo htmlspecialchars($column['title']); ?>" required class="input-style">
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-brand-navy">Bu Sütundaki Linkler</h3>
            <button type="button" id="add-link" class="btn-primary-sm"><i class="fas fa-plus"></i> Link Ekle</button>
        </div>

        <div id="links-container" class="space-y-3">
            <?php foreach ($column['links'] as $l_idx => $link): ?>
            <div class="link-item flex items-center gap-2 p-2 border rounded-xl bg-gray-50">
                <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i>
                <input type="text" name="column[links][<?php echo $l_idx ?>][label]" value="<?php echo htmlspecialchars($link['label']); ?>" placeholder="Etiket" class="input-style">
                <input type="text" name="column[links][<?php echo $l_idx ?>][url]" value="<?php echo htmlspecialchars($link['url']); ?>" placeholder="URL" class="input-style">
                <button type="button" class="remove-link text-brand-danger hover:text-red-700 p-2" title="Linki Sil"><i class="fas fa-trash"></i></button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="pt-6 mt-6 flex items-center gap-4 border-t border-gray-200">
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Değişiklikleri Kaydet</button>
        <a href="index.php" class="text-brand-secondary-gray hover:text-brand-navy font-semibold">Geri Dön</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const linksContainer = document.getElementById('links-container');
    
    // DÜZELTME: Bu fonksiyon, yeni eklenen inputları da doğru şekilde bulup
    // isimlendirecek şekilde güncellendi.
    const reindexLinks = () => {
        const items = linksContainer.querySelectorAll('.link-item');
        items.forEach((item, index) => {
            const inputs = item.querySelectorAll('input');
            // İki input alanı olduğunu varsayarak (label ve url)
            if (inputs.length >= 2) {
                inputs[0].name = `column[links][${index}][label]`;
                inputs[1].name = `column[links][${index}][url]`;
            }
        });
    };

    new Sortable(linksContainer, {
        animation: 150,
        handle: '.handle',
        ghostClass: 'sortable-ghost',
        onEnd: reindexLinks
    });

    document.getElementById('add-link').addEventListener('click', () => {
        const newLinkHTML = `
            <div class="link-item flex items-center gap-2 p-2 border rounded-xl bg-gray-50">
                <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i>
                <input type="text" name="" placeholder="Etiket" class="input-style">
                <input type="text" name="" placeholder="URL" class="input-style">
                <button type="button" class="remove-link text-brand-danger hover:text-red-700 p-2" title="Linki Sil"><i class="fas fa-trash"></i></button>
            </div>`;
        linksContainer.insertAdjacentHTML('beforeend', newLinkHTML);
        reindexLinks(); // Yeni link eklendikten sonra isimleri güncelle
    });

    linksContainer.addEventListener('click', e => {
        if (e.target.closest('.remove-link')) {
            e.target.closest('.link-item').remove();
            reindexLinks(); // Bir link silindikten sonra isimleri güncelle
        }
    });
});
</script>
<style>.input-style{display:block;width:100%;background-color:#F4F7FE;border:1px solid #E0E5F2;border-radius:.75rem;padding:.75rem 1rem;transition:all .2s}.input-style:focus{outline:none;box-shadow:0 0 0 2px #4318FF;border-color:#4318FF}.btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.75rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s}.btn-primary:hover{background-color:#3715d8}.btn-primary-sm{display:inline-flex;align-items:center;gap:.5rem;padding:.5rem 1rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.5rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s;font-size:.875rem}.btn-primary-sm:hover{background-color:#3715d8}</style>

<?php require_once __DIR__ . '/../tools/footer.php'; ?>
