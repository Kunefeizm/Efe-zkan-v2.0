<?php
// panel/tools/sidebar.php - Merkezi ve dinamik sidebar (Alt menü destekli)

$current_uri = $_SERVER['REQUEST_URI'];
$panel_base_url = '/panel/';

$menuItems = [
    [
        'label' => 'Ana Panel',
        'icon' => 'fas fa-tachometer-alt',
        'href' => $panel_base_url . 'index.php',
        'active_path' => $panel_base_url . 'index.php'
    ],
    [
        'label' => 'Slider Yönetimi',
        'icon' => 'fas fa-images',
        'href' => $panel_base_url . 'slider/index.php',
        'active_path' => $panel_base_url . 'slider/'
    ],
    [
        'label' => 'Site Ayarları',
        'icon' => 'fas fa-cogs',
        'active_paths' => [
            $panel_base_url . 'ayarlar/',
            $panel_base_url . 'navbar/',
            $panel_base_url . 'footer/',
            $panel_base_url . 'iletisim/' // Yeni yolu ekle
        ],
        'sub_items' => [
            [
                'label' => 'Genel Ayarlar',
                'icon' => 'fas fa-sliders-h',
                'href' => $panel_base_url . 'ayarlar/index.php',
                'active_path' => $panel_base_url . 'ayarlar/'
            ],
            [
                'label' => 'Navbar Yönetimi',
                'icon' => 'fas fa-bars',
                'href' => $panel_base_url . 'navbar/index.php',
                'active_path' => $panel_base_url . 'navbar/'
            ],
            [
                'label' => 'Footer Yönetimi',
                'icon' => 'fas fa-shoe-prints',
                'href' => $panel_base_url . 'footer/index.php',
                'active_path' => $panel_base_url . 'footer/'
            ],
            [ // YENİ LİNK
                'label' => 'İletişim Yönetimi',
                'icon' => 'fas fa-address-book',
                'href' => $panel_base_url . 'iletisim/index.php',
                'active_path' => $panel_base_url . 'iletisim/'
            ],
        ]
    ],
];
?>
<!-- Sidebar HTML'i (değişiklik yok, öncekiyle aynı) -->
<aside class="w-64 bg-brand-paper flex-shrink-0 p-6 flex-col hidden md:flex border-r border-gray-200">
    <a href="<?php echo $panel_base_url; ?>index.php" class="text-3xl font-bold text-brand-purple mb-10">Horizon</a>
    <nav class="flex flex-col gap-2">
        <?php
            foreach ($menuItems as $item) {
                if (isset($item['sub_items'])) {
                    $isParentActive = false;
                    foreach ($item['active_paths'] as $path) {
                        if (strpos($current_uri, $path) === 0) {
                            $isParentActive = true;
                            break;
                        }
                    }
                    $parentClasses = 'flex items-center justify-between w-full gap-3 px-4 py-3 rounded-xl font-semibold transition-colors duration-200 cursor-pointer ' . ($isParentActive ? 'bg-brand-light-blue text-brand-purple' : 'text-brand-secondary-gray hover:bg-brand-light-blue hover:text-brand-purple');
                    echo '<div class="submenu-container">';
                    echo '  <button type="button" class="' . $parentClasses . '">';
                    echo '    <div class="flex items-center gap-3"><i class="' . htmlspecialchars($item['icon']) . ' w-5 text-center text-lg"></i><span>' . htmlspecialchars($item['label']) . '</span></div>';
                    echo '    <i class="fas fa-chevron-down transition-transform duration-300 ' . ($isParentActive ? '' : '-rotate-90') . '"></i>';
                    echo '  </button>';
                    echo '  <div class="submenu-list overflow-hidden transition-all duration-300 ease-in-out ' . ($isParentActive ? 'max-h-screen' : 'max-h-0') . '">';
                    echo '    <div class="pt-2 pl-6 space-y-1">';
                    foreach ($item['sub_items'] as $subItem) {
                        $isSubActive = (strpos($current_uri, $subItem['active_path']) === 0);
                        $subLinkClasses = 'flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors ' . ($isSubActive ? 'text-brand-purple' : 'text-brand-secondary-gray hover:text-brand-purple');
                        echo '<a href="' . htmlspecialchars($subItem['href']) . '" class="' . $subLinkClasses . '">';
                        echo '  <i class="' . htmlspecialchars($subItem['icon']) . ' w-5 text-center"></i><span>' . htmlspecialchars($subItem['label']) . '</span>';
                        echo '</a>';
                    }
                    echo '    </div></div></div>';
                } else {
                    $isActive = (strpos($current_uri, $item['active_path']) === 0);
                    $linkClasses = 'flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors duration-200 ' . ($isActive ? 'bg-brand-light-blue text-brand-purple' : 'text-brand-secondary-gray hover:bg-brand-light-blue hover:text-brand-purple');
                    echo '<a href="' . htmlspecialchars($item['href']) . '" class="' . $linkClasses . '">';
                    echo '  <i class="' . htmlspecialchars($item['icon']) . ' w-5 text-center text-lg"></i><span>' . htmlspecialchars($item['label']) . '</span>';
                    echo '</a>';
                }
            }
        ?>
    </nav>
    <div class="mt-auto flex flex-col gap-4">
        <div class="p-4 rounded-2xl bg-gradient-to-br from-brand-purple to-blue-500 text-white">
            <div class="bg-white/20 rounded-full w-10 h-10 flex items-center justify-center mb-3"><i class="fas fa-question-circle text-xl"></i></div>
            <h3 class="font-bold">Yardım Merkezi</h3>
            <p class="text-xs mt-1 mb-3 opacity-80">Dokümantasyonu inceleyerek destek alabilirsiniz.</p>
            <a href="#" class="block w-full bg-white text-brand-purple font-semibold text-center px-4 py-2 rounded-lg text-sm hover:bg-gray-100 transition-colors">DOKÜMANTASYON</a>
        </div>
        <a href="<?php echo $panel_base_url; ?>logout.php" class="flex items-center justify-center gap-3 px-4 py-3 text-brand-secondary-gray bg-brand-light-blue hover:bg-red-100 hover:text-red-600 rounded-xl font-medium transition-colors">
            <i class="fas fa-sign-out-alt w-5 text-center"></i><span>Güvenli Çıkış</span>
        </a>
    </div>
</aside>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.submenu-container > button').forEach(button => {
        const submenu = button.nextElementSibling;
        const chevron = button.querySelector('.fa-chevron-down');
        if (submenu.classList.contains('max-h-screen')) {
            submenu.style.maxHeight = submenu.scrollHeight + "px";
        } else {
            submenu.style.maxHeight = '0px';
        }
        button.addEventListener('click', () => {
            if (submenu.style.maxHeight !== '0px') {
                submenu.style.maxHeight = '0px';
                chevron.classList.add('-rotate-90');
            } else {
                document.querySelectorAll('.submenu-list').forEach(list => list.style.maxHeight = '0px');
                document.querySelectorAll('.submenu-container > button .fa-chevron-down').forEach(chev => chev.classList.add('-rotate-90'));
                submenu.style.maxHeight = submenu.scrollHeight + "px";
                chevron.classList.remove('-rotate-90');
            }
        });
    });
});
</script>
