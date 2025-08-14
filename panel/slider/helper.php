<?php
// helper.php - Slider yönetimi için ortak fonksiyonlar

// --- CONFIGURATION ---
define('DATA_FILE_PATH', __DIR__ . '/../../data/slider.json');
define('UPLOAD_DIR', __DIR__ . '/../../images/slider/');
define('UPLOAD_URL', '/images/slider/');

if (!is_dir(dirname(DATA_FILE_PATH))) { mkdir(dirname(DATA_FILE_PATH), 0755, true); }
if (!is_dir(UPLOAD_DIR)) { mkdir(UPLOAD_DIR, 0755, true); }

/**
 * Tüm JSON verisini (slaytlar ve ayarlar) okur.
 * @return array
 */
function getFullData() {
    $defaults = [
        'slides' => [],
        'settings' => [
            'autoplay_delay' => 5000,
            'overlay_opacity' => 0.3,
        ]
    ];
    if (!file_exists(DATA_FILE_PATH)) {
        return $defaults;
    }
    $data = json_decode(file_get_contents(DATA_FILE_PATH), true);
    // Eskiden sadece dizi olan JSON'u destekle
    if (isset($data[0])) {
        return ['slides' => $data, 'settings' => $defaults['settings']];
    }
    return array_merge($defaults, $data);
}

/**
 * Sadece slayt verilerini alır.
 * @return array
 */
function getSliderData() {
    $data = getFullData();
    return $data['slides'] ?? [];
}

/**
 * Sadece ayar verilerini alır.
 * @return array
 */
function getSliderSettings() {
    $data = getFullData();
    return $data['settings'];
}

/**
 * Sadece slayt verilerini kaydeder.
 * @param array $slides
 */
function saveSliderData($slides) {
    $data = getFullData();
    $data['slides'] = array_values($slides);
    file_put_contents(DATA_FILE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Sadece ayar verilerini kaydeder.
 * @param array $settings
 */
function saveSliderSettings($settings) {
    $data = getFullData();
    $data['settings'] = $settings;
    file_put_contents(DATA_FILE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Belirtilen görsel URL'sinden dosyayı sunucudan siler.
 * @param string|null $imageUrl
 */
function deleteImage($imageUrl) {
    if (!$imageUrl) return;
    $filename = basename($imageUrl);
    if ($filename && file_exists(UPLOAD_DIR . $filename)) {
        unlink(UPLOAD_DIR . $filename);
    }
}
?>
