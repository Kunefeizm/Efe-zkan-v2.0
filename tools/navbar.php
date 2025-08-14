<?php
// tools/navbar.php - Web sayfasının panelden yönetilen navigasyon çubuğu

// Yeni navbar helper'ını çağırıyoruz
require_once __DIR__ . '/../panel/navbar/helper.php';
$navbarData = getNavbarData();
$logo = $navbarData['logo'];
$menuItems = $navbarData['menu_items'];
?>
<!-- ========== NAVBAR ========== -->
<header id="navbar" class="fixed top-0 left-0 w-full z-50">
    <nav class="container-custom flex items-center justify-between py-4">
        <a href="#" class="logo-container">
            <?php if ($logo['type'] === 'text'): ?>
                <span class="text-2xl font-bold text-white transition-colors duration-300 logo-text"><?php echo htmlspecialchars($logo['text']); ?></span>
            <?php else: ?>
                <!-- İki logo görselini de ekliyoruz, JS ile görünürlüklerini değiştireceğiz -->
                <img id="logo-default" src="<?php echo htmlspecialchars($logo['image_default']); ?>" alt="Logo" class="h-8 transition-opacity duration-300">
                <img id="logo-scrolled" src="<?php echo htmlspecialchars($logo['image_scrolled']); ?>" alt="Logo" class="h-8 transition-opacity duration-300 hidden">
            <?php endif; ?>
        </a>
        
        <!-- Masaüstü menü -->
        <div class="hidden md:flex items-center space-x-8">
            <?php foreach ($menuItems as $item): ?>
                <a href="<?php echo htmlspecialchars($item['url']); ?>" class="text-white hover:text-gray-300 transition-colors duration-300 nav-link"><?php echo htmlspecialchars($item['label']); ?></a>
            <?php endforeach; ?>
        </div>
        
        <!-- Mobil menü butonu -->
        <div class="md:hidden">
            <button id="mobile-menu-button" class="text-white hover:text-gray-300 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>
</header>

<!-- Mobil menü -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>
<div id="mobile-menu" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden z-50">
    <div class="flex justify-between items-center p-4 border-b">
        <span class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($logo['text']); ?></span>
        <button id="close-mobile-menu" class="text-gray-800 hover:text-gray-600 focus:outline-none">
            <i class="fas fa-times text-2xl"></i>
        </button>
    </div>
    <nav class="flex flex-col">
        <?php foreach ($menuItems as $item): ?>
            <a href="<?php echo htmlspecialchars($item['url']); ?>" class="mobile-nav-link block text-gray-800 text-lg hover:bg-gray-100 transition-colors duration-300 border-b border-gray-200 py-3 px-4"><?php echo htmlspecialchars($item['label']); ?></a>
        <?php endforeach; ?>
    </nav>
</div>
