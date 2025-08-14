<?php
// panel/iletisim/helper.php - İletişim bilgileri yönetimi için fonksiyonlar

define('CONTACT_DATA_FILE', __DIR__ . '/../../data/iletisim.json');

if (!is_dir(dirname(CONTACT_DATA_FILE))) {
    mkdir(dirname(CONTACT_DATA_FILE), 0755, true);
}

/**
 * İletişim verilerini JSON dosyasından okur.
 * @return array
 */
function getContactData() {
    $defaults = [
        'phones' => [],
        'whatsapps' => [],
        'emails' => [],
        'address' => '', // YENİ: Açık adres alanı eklendi
        'map_embed_url' => '',
        'map_url' => ''
    ];

    if (!file_exists(CONTACT_DATA_FILE)) {
        return $defaults;
    }
    $data = json_decode(file_get_contents(CONTACT_DATA_FILE), true);
    $data = array_replace_recursive($defaults, $data ?? []);

    // Otomatik veri taşıma: Eski iframe verisinden URL'yi çıkar
    if (!empty($data['map_iframe']) && empty($data['map_embed_url'])) {
        preg_match('/src="([^"]+)"/', $data['map_iframe'], $matches);
        if (isset($matches[1])) {
            $data['map_embed_url'] = $matches[1];
            unset($data['map_iframe']); // Eski anahtarı temizle
            saveContactData($data); // Değişikliği hemen kaydet
        }
    }

    return $data;
}

/**
 * İletişim verilerini JSON dosyasına kaydeder.
 * @param array $data
 */
function saveContactData($data) {
    // Dinamik listelerin indislerini sıfırla
    if (isset($data['phones'])) $data['phones'] = array_values($data['phones']);
    if (isset($data['whatsapps'])) $data['whatsapps'] = array_values($data['whatsapps']);
    if (isset($data['emails'])) $data['emails'] = array_values($data['emails']);
    
    unset($data['map_iframe']);

    file_put_contents(CONTACT_DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
