<?php
// head.php - Web sayfasının başlangıç bölümünü (<head> ve <body> taglarını içerir)
// Panelden genel ayarları çekmek için helper dosyasını dahil et
require_once __DIR__ . '/../panel/ayarlar/helper.php';
$siteSettings = getSiteSettings();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- DİNAMİK SEO & FAVICON BİLGİLERİ -->
    <title><?php echo htmlspecialchars($siteSettings['seo']['title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($siteSettings['seo']['description']); ?>">
    <?php if (!empty($siteSettings['favicon_url'])): ?>
    <link rel="icon" href="<?php echo htmlspecialchars($siteSettings['favicon_url']); ?>">
    <?php endif; ?>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2eT0Wj1dC2R+T7U5hQo5p/aGj9j5h3g1e6+v6/Q5L/y4+V8z5q8bW+p5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- lightGallery CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lightgallery.min.css" xintegrity="sha512-F2E+YYE1gkt0T5TVajAslgDfTEUQKtlu4ralVqIJzUBCPAzTB/BLi5UzaA//AEhdG7JzALMNbCPKqcpKXQEHzA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-thumbnail.min.css" xintegrity="sha512-GRxDpj/bx6/I4y6h2LE5rbGaqCiVOucTxK3elhdJhFHeMU7vilFAvwibFpRjZNksBCDsA9dojDRpaRwRxTB0qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Özel Stiller -->
    <link rel="stylesheet" href="/effect/styles.php">

    <!-- JAVASCRIPT KÜTÜPHANELERİ (defer ile yüklenmeleri en iyi pratiktir) -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/thumbnail/lg-thumbnail.min.js"></script>
    
    <!-- Özel Scriptler -->
    <script src="/effect/script.php"></script>

</head>
<body class="bg-gray-50">
