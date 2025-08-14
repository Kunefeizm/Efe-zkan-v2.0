<?php
// panel/ayarlar/helper.php - Genel site ayarları için fonksiyonlar

define('SETTINGS_DATA_FILE', __DIR__ . '/../../data/settings.json');

// Ayarlara özel görseller için (logolar vb.)
define('SETTINGS_UPLOAD_DIR', __DIR__ . '/../../images/settings/');
define('SETTINGS_UPLOAD_URL', '/images/settings/');

// Favicon gibi kök dizine yakın olması gereken görseller için YENİ sabitler
define('IMAGES_DIR', __DIR__ . '/../../images/');
define('IMAGES_URL', '/images/');


if (!is_dir(dirname(SETTINGS_DATA_FILE))) { mkdir(dirname(SETTINGS_DATA_FILE), 0755, true); }
if (!is_dir(SETTINGS_UPLOAD_DIR)) { mkdir(SETTINGS_UPLOAD_DIR, 0755, true); }
if (!is_dir(IMAGES_DIR)) { mkdir(IMAGES_DIR, 0755, true); }

/**
 * Genel site ayarlarını JSON dosyasından okur.
 * @return array
 */
function getSiteSettings() {
    $defaults = [
        'seo' => [
            'title' => 'Modern Kurumsal Web Sitesi',
            'description' => 'Yenilikçi çözümlerle geleceği şekillendiriyoruz.'
        ],
        'logo' => [
            'type' => 'text',
            'text' => 'Horizon',
            'color_light' => '#FFFFFF',
            'color_dark' => '#1B2559',
            'image_default' => '', // Varsayılan (Renkli) Logo
            'image_light' => ''    // Açık Renk (Beyaz) Logo
        ],
        'favicon_url' => ''
    ];
    if (!file_exists(SETTINGS_DATA_FILE)) {
        return $defaults;
    }
    $data = json_decode(file_get_contents(SETTINGS_DATA_FILE), true);
    return array_replace_recursive($defaults, $data ?? []);
}

/**
 * Genel site ayarlarını JSON dosyasına kaydeder.
 * @param array $data
 */
function saveSiteSettings($data) {
    file_put_contents(SETTINGS_DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Site ayarları için yüklenen bir görseli siler.
 * @param string|null $imageUrl
 */
function deleteSiteImage($imageUrl) {
    if (!$imageUrl) return;
    // DİKKAT: Bu fonksiyon sadece /images/settings/ içindeki görselleri siler.
    // Genel silme işlemi için yolun manuel olarak kontrol edilmesi gerekir.
    $filename = basename($imageUrl);
    if ($filename && file_exists(SETTINGS_UPLOAD_DIR . $filename)) {
        unlink(SETTINGS_UPLOAD_DIR . $filename);
    }
}
