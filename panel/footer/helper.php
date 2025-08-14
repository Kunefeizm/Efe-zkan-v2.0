<?php
// panel/footer/helper.php - Footer yönetimi için ortak fonksiyonlar

define('FOOTER_DATA_FILE', __DIR__ . '/../../data/footer.json');

if (!is_dir(dirname(FOOTER_DATA_FILE))) {
    mkdir(dirname(FOOTER_DATA_FILE), 0755, true);
}

function getFooterData() {
    $defaults = [
        'description' => 'Yenilikçi çözümlerle geleceği şekillendiriyoruz.',
        'copyright' => '© ' . date("Y") . ' Şirket Adı. Tüm hakları saklıdır.',
        'logo' => [
            'choice' => 'light' // 'light' veya 'default'
        ],
        'link_columns' => [],
        'socials' => [] // Artık dinamik bir dizi
    ];

    if (!file_exists(FOOTER_DATA_FILE)) {
        // Varsayılan sosyal medya linkleri
        $defaults['socials'] = [
            ['icon' => 'fab fa-facebook-f', 'url' => 'https://facebook.com'],
            ['icon' => 'fab fa-twitter', 'url' => 'https://twitter.com']
        ];
        return $defaults;
    }

    $data = json_decode(file_get_contents(FOOTER_DATA_FILE), true);
    $data = array_replace_recursive($defaults, $data ?? []);

    // --- OTOMATİK VERİ DÖNÜŞTÜRME ---
    // Eski obje yapısındaki sosyal medya verisini yeni dizi yapısına dönüştürür.
    if (isset($data['socials']) && is_array($data['socials']) && !empty($data['socials'])) {
        $keys = array_keys($data['socials']);
        if (isset($keys[0]) && !is_int($keys[0])) {
            $newSocials = [];
            $iconMap = [
                'facebook' => 'fab fa-facebook-f', 'twitter' => 'fab fa-twitter',
                'instagram' => 'fab fa-instagram', 'linkedin' => 'fab fa-linkedin-in',
                'youtube' => 'fab fa-youtube', 'pinterest' => 'fab fa-pinterest'
            ];
            foreach ($data['socials'] as $platform => $url) {
                if (!empty($url)) {
                    $newSocials[] = [
                        'icon' => $iconMap[$platform] ?? 'fas fa-link',
                        'url' => $url
                    ];
                }
            }
            $data['socials'] = $newSocials;
            saveFooterData($data); // Dönüştürülen veriyi hemen kaydet
        }
    }
    
    return $data;
}

function saveFooterData($data) {
    if (isset($data['link_columns'])) {
        $data['link_columns'] = array_values($data['link_columns']);
        foreach ($data['link_columns'] as &$column) {
            if (isset($column['links'])) {
                $column['links'] = array_values($column['links']);
            }
        }
    }
    if (isset($data['socials'])) {
        $data['socials'] = array_values($data['socials']);
    }
    file_put_contents(FOOTER_DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
