<?php
require_once 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title'] ?? '');
    if (!empty($title)) {
        $data = getFooterData();
        $data['link_columns'][] = [
            'title' => $title,
            'links' => []
        ];
        saveFooterData($data);
        header("Location: index.php?status=" . urlencode('Yeni sütun başarıyla eklendi.'));
        exit;
    }
}

$page_title = 'Footer Yönetimi';
$page_subtitle = 'Yeni Sütun Ekle';
require_once __DIR__ . '/../tools/header.php';
?>

<div class="bg-brand-paper p-6 md:p-8 rounded-2xl shadow-custom max-w-lg mx-auto">
    <form action="ekle.php" method="post">
        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-bold text-brand-navy mb-2">Sütun Başlığı</label>
                <input id="title" type="text" name="title" required class="input-style">
            </div>
            <div class="pt-4 flex items-center gap-4 border-t border-gray-200">
                <button type="submit" class="btn-primary"><i class="fas fa-plus"></i> Sütunu Ekle</button>
                <a href="index.php" class="text-brand-secondary-gray hover:text-brand-navy font-semibold">İptal</a>
            </div>
        </div>
    </form>
</div>
<style>.input-style { display: block; width: 100%; background-color: #F4F7FE; border: 1px solid #E0E5F2; border-radius: 0.75rem; padding: 0.75rem 1rem; transition: all .2s; } .input-style:focus{outline:none;box-shadow:0 0 0 2px #4318FF;border-color:#4318FF} .btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding: .75rem 1.5rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.75rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s}.btn-primary:hover{background-color:#3715d8}</style>

<?php require_once __DIR__ . '/../tools/footer.php'; ?>
