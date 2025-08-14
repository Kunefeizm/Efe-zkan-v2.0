<?php
require_once 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posted = $_POST['contact'];
    $newData = [];

    // Dinamik listeleri işle
    foreach (['phones', 'whatsapps', 'emails'] as $key) {
        $newData[$key] = [];
        if (!empty($posted[$key])) {
            foreach ($posted[$key] as $item) {
                if ($key === 'emails') {
                    if (!empty(trim($item))) $newData[$key][] = trim($item);
                } else {
                    if (!empty(trim($item['name'])) && !empty(trim($item['number']))) {
                        $newData[$key][] = ['name' => trim($item['name']), 'number' => trim($item['number'])];
                    }
                }
            }
        }
    }
    
    // Adres ve Harita bilgilerini işle
    $newData['address'] = trim($posted['address'] ?? '');
    $newData['map_embed_url'] = trim($posted['map_embed_url'] ?? '');
    $newData['map_url'] = trim($posted['map_url'] ?? '');

    saveContactData($newData);
    header("Location: index.php?status=" . urlencode('İletişim bilgileri başarıyla güncellendi.'));
    exit;
}

$contactData = getContactData();
$page_title = 'Site Ayarları';
$page_subtitle = 'İletişim Yönetimi';
require_once __DIR__ . '/../tools/header.php';
?>

<form action="index.php" method="post">
    <!-- max-w-4xl'den max-w-7xl'ye değiştirildi. Bu, kartların yanal uzunluğunu artırır. -->
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Telefon Numaraları -->
        <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-brand-navy">Telefon Numaraları</h3>
                <button type="button" class="btn-primary-sm add-item-btn" data-container="phones-container" data-template="phone-template"><i class="fas fa-plus"></i> Ekle</button>
            </div>
            <div id="phones-container" class="space-y-3">
                <?php foreach ($contactData['phones'] as $idx => $item): ?>
                <div class="item-group flex items-center gap-2">
                    <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i>
                    <input type="text" name="contact[phones][<?php echo $idx; ?>][name]" value="<?php echo htmlspecialchars($item['name']); ?>" placeholder="Açıklama (örn: Ofis)" class="input-style">
                    <input type="text" name="contact[phones][<?php echo $idx; ?>][number]" value="<?php echo htmlspecialchars($item['number']); ?>" placeholder="Numara (örn: +90...)" class="input-style">
                    <button type="button" class="remove-item-btn text-brand-danger hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- WhatsApp Numaraları -->
        <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-brand-navy">WhatsApp Hatları</h3>
                <button type="button" class="btn-primary-sm add-item-btn" data-container="whatsapps-container" data-template="whatsapp-template"><i class="fas fa-plus"></i> Ekle</button>
            </div>
            <div id="whatsapps-container" class="space-y-3">
                 <?php foreach ($contactData['whatsapps'] as $idx => $item): ?>
                <div class="item-group flex items-center gap-2">
                    <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i>
                    <input type="text" name="contact[whatsapps][<?php echo $idx; ?>][name]" value="<?php echo htmlspecialchars($item['name']); ?>" placeholder="Açıklama (örn: Destek)" class="input-style">
                    <input type="text" name="contact[whatsapps][<?php echo $idx; ?>][number]" value="<?php echo htmlspecialchars($item['number']); ?>" placeholder="Numara (örn: +90...)" class="input-style">
                    <button type="button" class="remove-item-btn text-brand-danger hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- E-posta Adresleri -->
        <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-brand-navy">E-posta Adresleri</h3>
                <button type="button" class="btn-primary-sm add-item-btn" data-container="emails-container" data-template="email-template"><i class="fas fa-plus"></i> Ekle</button>
            </div>
            <div id="emails-container" class="space-y-3">
                <?php foreach ($contactData['emails'] as $idx => $item): ?>
                <div class="item-group flex items-center gap-2">
                    <i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i>
                    <input type="email" name="contact[emails][<?php echo $idx; ?>]" value="<?php echo htmlspecialchars($item); ?>" placeholder="info@alanadi.com" class="input-style w-full">
                    <button type="button" class="remove-item-btn text-brand-danger hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Adres ve Harita Bilgileri -->
        <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
            <h3 class="text-xl font-bold text-brand-navy mb-4">Adres ve Harita Bilgileri</h3>
            <div class="space-y-4">
                <div>
                    <label for="address" class="label-style">Açık Adres</label>
                    <textarea id="address" name="contact[address]" rows="3" placeholder="Şirketinizin açık adresini girin" class="input-style"><?php echo htmlspecialchars($contactData['address']); ?></textarea>
                </div>
                <div>
                    <label for="map_url" class="label-style">Yol Tarifi Linki (Paylaşım Linki)</label>
                    <input id="map_url" type="url" name="contact[map_url]" value="<?php echo htmlspecialchars($contactData['map_url']); ?>" placeholder="Google Haritalar paylaşım linki" class="input-style">
                    <p class="text-xs text-brand-gray mt-1">Örn: https://maps.app.goo.gl/xxxxxxxxxxxx</p>
                </div>
                <div>
                    <label for="map_embed_url" class="label-style">Harita Gömme Linki (Embed URL)</label>
                    <input id="map_embed_url" type="url" name="contact[map_embed_url]" value="<?php echo htmlspecialchars($contactData['map_embed_url']); ?>" placeholder="Google Haritalar'dan alınan gömme linki" class="input-style">
                    <p class="text-xs text-brand-gray mt-1">Google Haritalar > Paylaş > Harita Yerleştir > <strong>src="..."</strong> içindeki linki kopyalayın.</p>
                </div>
            </div>
        </div>

        <!-- YENİ: Harita Önizlemesi -->
        <div class="bg-brand-paper p-6 rounded-2xl shadow-custom">
            <h3 class="text-xl font-bold text-brand-navy mb-4">Harita Önizlemesi</h3>
            <div id="map-preview-container" class="w-full aspect-video bg-brand-light-blue rounded-lg flex items-center justify-center text-brand-gray border border-gray-200">
                <p id="map-preview-placeholder">Gömme linki girildiğinde harita burada görünecektir.</p>
                <iframe id="map-preview-iframe" class="w-full h-full rounded-lg hidden" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Kaydet Butonu -->
        <div class="text-right">
            <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Tüm Bilgileri Kaydet</button>
        </div>
    </div>
</form>

<!-- Şablonlar -->
<template id="phone-template"><div class="item-group flex items-center gap-2"><i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i><input type="text" name="contact[phones][][name]" placeholder="Açıklama" class="input-style"><input type="text" name="contact[phones][][number]" placeholder="Numara" class="input-style"><button type="button" class="remove-item-btn text-brand-danger hover:text-red-700 p-2"><i class="fas fa-trash"></i></button></div></template>
<template id="whatsapp-template"><div class="item-group flex items-center gap-2"><i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i><input type="text" name="contact[whatsapps][][name]" placeholder="Açıklama" class="input-style"><input type="text" name="contact[whatsapps][][number]" placeholder="Numara" class="input-style"><button type="button" class="remove-item-btn text-brand-danger hover:text-red-700 p-2"><i class="fas fa-trash"></i></button></div></template>
<template id="email-template"><div class="item-group flex items-center gap-2"><i class="fas fa-grip-vertical handle text-brand-gray cursor-grab p-2"></i><input type="email" name="contact[emails][]" placeholder="E-posta adresi" class="input-style w-full"><button type="button" class="remove-item-btn text-brand-danger hover:text-red-700 p-2"><i class="fas fa-trash"></i></button></div></template>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Dinamik Liste Yönetimi (Telefon, WhatsApp, E-posta)
    function reindex(container) { const items = container.querySelectorAll('.item-group'); items.forEach((item, index) => { const inputs = item.querySelectorAll('input, textarea'); inputs.forEach(input => { const oldName = input.getAttribute('name'); if (oldName) { const newName = oldName.replace(/\[\d*\]/, `[${index}]`); input.setAttribute('name', newName); } }); }); }
    function setupContainer(containerId) { const container = document.getElementById(containerId); if (!container) return; new Sortable(container, { animation: 150, handle: '.handle', ghostClass: 'sortable-ghost', onEnd: () => reindex(container) }); container.addEventListener('click', e => { if (e.target.closest('.remove-item-btn')) { e.target.closest('.item-group').remove(); reindex(container); } }); }
    document.querySelectorAll('.add-item-btn').forEach(button => { button.addEventListener('click', () => { const container = document.getElementById(button.dataset.container); const template = document.getElementById(button.dataset.template); if (container && template) { container.appendChild(template.content.cloneNode(true)); reindex(container); } }); });
    setupContainer('phones-container'); setupContainer('whatsapps-container'); setupContainer('emails-container');

    // Harita Önizleme Scripti
    const mapEmbedInput = document.getElementById('map_embed_url');
    const mapPreviewIframe = document.getElementById('map-preview-iframe');
    const mapPreviewPlaceholder = document.getElementById('map-preview-placeholder');

    function updateMapPreview() {
        const url = mapEmbedInput.value.trim();
        if (url) {
            mapPreviewIframe.src = url;
            mapPreviewIframe.classList.remove('hidden');
            mapPreviewPlaceholder.classList.add('hidden');
        } else {
            mapPreviewIframe.classList.add('hidden');
            mapPreviewPlaceholder.classList.remove('hidden');
        }
    }

    mapEmbedInput.addEventListener('input', updateMapPreview);
    updateMapPreview(); // Sayfa yüklendiğinde mevcut link için önizlemeyi göster
});
</script>

<style>.label-style{display:block;font-size:0.875rem;font-weight:700;color:#1B2559;margin-bottom:0.5rem}.input-style{width:100%;background-color:#F4F7FE;border:1px solid #E0E5F2;border-radius:0.75rem;padding:0.75rem 1rem;transition:all .2s}.input-style:focus{outline:none;box-shadow:0 0 0 2px #4318FF;border-color:#4318FF}.btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.75rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s}.btn-primary:hover{background-color:#3715d8}.btn-primary-sm{display:inline-flex;align-items:center;gap:.5rem;padding:.5rem 1rem;background-color:#4318FF;color:white;font-weight:600;border-radius:.5rem;box-shadow:0 4px 6px -1px rgba(0,0,0,.1);transition:background-color .2s;font-size:.875rem}.btn-primary-sm:hover{background-color:#3715d8}</style>

<?php require_once __DIR__ . '/../tools/footer.php'; ?>
