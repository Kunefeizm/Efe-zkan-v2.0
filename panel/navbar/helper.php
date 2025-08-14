<?php
// panel/navbar/helper.php - Navbar yönetimi için ortak fonksiyonlar

// --- CONFIGURATION ---
// Bu helper, kendi modül dizininden çağrıldığı için yollar buna göre ayarlandı.
define('NAVBAR_DATA_FILE', __DIR__ . '/../../data/navbar.json');
define('NAVBAR_UPLOAD_DIR', __DIR__ . '/../../images/navbar/');
define('NAVBAR_UPLOAD_URL', '/images/navbar/');

// Gerekli klasörlerin varlığını kontrol et ve yoksa oluştur
if (!is_dir(dirname(NAVBAR_DATA_FILE))) { mkdir(dirname(NAVBAR_DATA_FILE), 0755, true); }
if (!is_dir(NAVBAR_UPLOAD_DIR)) { mkdir(NAVBAR_UPLOAD_DIR, 0755, true); }

/**
 * Navbar verilerini (logo ve menü) JSON dosyasından okur.
 * @return array
 */
function getNavbarData() {
    $defaults = [
        'logo' => [
            'type' => 'text', // 'text' or 'image'
            'text' => 'Horizon',
            'image_default' => '', // Şeffaf arkaplan için logo
            'image_scrolled' => ''  // Beyaz arkaplan için logo
        ],
        'menu_items' => [
            ['label' => 'Anasayfa', 'url' => '#slider'],
            ['label' => 'Hakkımızda', 'url' => '#hakkimizda'],
            ['label' => 'Hizmetler', 'url' => '#hizmetler'],
            ['label' => 'İletişim', 'url' => '#iletisim'],
        ]
    ];
    if (!file_exists(NAVBAR_DATA_FILE)) {
        return $defaults;
    }
    $data = json_decode(file_get_contents(NAVBAR_DATA_FILE), true);
    // JSON'dan gelen veriyi varsayılanlarla birleştirerek eksik anahtarları tamamla
    return array_replace_recursive($defaults, $data ?? []);
}

/**
 * Navbar verilerini JSON dosyasına kaydeder.
 * @param array $data
 */
function saveNavbarData($data) {
    file_put_contents(NAVBAR_DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Belirtilen görsel URL'sinden dosyayı sunucudan siler.
 * @param string|null $imageUrl
 */
function deleteNavbarImage($imageUrl) {
    if (!$imageUrl) return;
    $filename = basename($imageUrl);
    if ($filename && file_exists(NAVBAR_UPLOAD_DIR . $filename)) {
        unlink(NAVBAR_UPLOAD_DIR . $filename);
    }
}
