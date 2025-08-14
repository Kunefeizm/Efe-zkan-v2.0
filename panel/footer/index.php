<?php
require_once 'helper.php';

$footerData = getFooterData();
$columns = $footerData['link_columns'];

$page_title = 'Footer Yönetimi';
$page_subtitle = 'Link Sütunları';
require_once __DIR__ . '/../tools/header.php';
?>

<div class="bg-brand-paper p-6 md:p-8 rounded-2xl shadow-custom">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h3 class="text-xl font-bold text-brand-navy">Link Sütunları Listesi</h3>
        <div class="flex items-center gap-3">
            <a href="ayarlar.php" class="flex items-center justify-center w-11 h-11 bg-brand-light-blue hover:bg-gray-200 text-brand-blue rounded-full transition-colors" title="Genel Footer Ayarları">
                <i class="fas fa-cog text-lg"></i>
            </a>
            <a href="ekle.php" class="flex items-center gap-2 px-5 py-2.5 bg-brand-purple text-white font-semibold rounded-2xl shadow-sm hover:bg-purple-700 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Yeni Sütun Ekle</span>
            </a>
        </div>
    </div>

    <div id="columns-list" class="space-y-3">
        <?php if (empty($columns)): ?>
            <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                <p class="text-brand-gray">Henüz link sütunu eklenmemiş.</p>
            </div>
        <?php else: ?>
            <?php foreach ($columns as $index => $column): ?>
                <div class="column-item flex items-center gap-4 p-3 border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors" data-id="<?php echo $index; ?>">
                    <div class="handle text-brand-gray hover:text-brand-purple transition-colors p-2 cursor-grab"><i class="fas fa-grip-vertical fa-lg"></i></div>
                    <div class="flex-grow min-w-0">
                        <h4 class="font-bold text-brand-navy truncate"><?php echo htmlspecialchars($column['title']); ?></h4>
                        <p class="text-sm text-brand-secondary-gray"><?php echo count($column['links']); ?> link</p>
                    </div>
                    <div class="flex items-center gap-4 flex-shrink-0">
                        <a href="duzenle.php?id=<?php echo $index; ?>" class="text-brand-purple hover:text-purple-800 transition-colors" title="Düzenle"><i class="fas fa-edit fa-lg"></i></a>
                        <a href="sil.php?type=column&id=<?php echo $index; ?>" class="text-brand-danger hover:text-red-700 transition-colors delete-btn" title="Sil"><i class="fas fa-trash fa-lg"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('columns-list');
    if(list && list.children.length > 1) {
        new Sortable(list, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.handle',
            onEnd: function () {
                const newOrder = Array.from(list.querySelectorAll('.column-item')).map(item => item.getAttribute('data-id'));
                fetch('sirala.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ type: 'columns', order: newOrder }),
                }).catch(err => console.error('Sıralama isteği başarısız:', err));
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../tools/footer.php'; ?>
