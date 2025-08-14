<?php
session_start();
// Eğer kullanıcı giriş yapmamışsa, aynı dizindeki login sayfasına yönlendir.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
$username = $_SESSION['username'] ?? 'Kullanıcı';

// Örnek istatistikler için slider verisini çekelim
// Bu dosya panel/ dizininde olduğu için slider/helper.php yolu doğrudur.
require_once 'slider/helper.php';
$sliderData = getSliderData();
$totalSlides = count($sliderData);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Panel - Horizon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        // Horizon Teması için standart Tailwind yapılandırması
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['DM Sans', 'sans-serif'], },
                    colors: {
                        'brand-navy': '#1B2559', 'brand-blue': '#2B3674', 'brand-light-blue': '#F4F7FE',
                        'brand-purple': '#4318FF', 'brand-gray': '#A3AED0', 'brand-secondary-gray': '#707EAE',
                        'brand-danger': '#EF4444', 'brand-success': '#01B574', 'brand-paper': '#FFFFFF',
                    },
                    boxShadow: { 'custom': '0px 18px 40px 0px #7090B01F', }
                }
            }
        }
    </script>
    <style> body { background-color: #F4F7FE; font-family: 'DM Sans', sans-serif; } </style>
</head>
<body>
    <div class="flex h-screen bg-brand-light-blue">
        
        <?php 
            // sidebar.php'nin yolu panel/tools/sidebar.php olarak belirtildi.
            include 'tools/sidebar.php'; 
        ?>

        <!-- Ana İçerik Alanı -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white/80 backdrop-blur-sm p-6 flex justify-between items-center border-b border-gray-200">
                <div>
                    <p class="text-sm text-brand-gray">Sayfalar / Ana Panel</p>
                    <h2 class="text-3xl font-bold text-brand-navy">Ana Panel</h2>
                </div>
                 <div class="flex items-center gap-4 bg-white p-2 rounded-full shadow-md">
                    <img src="https://placehold.co/40x40/4318FF/FFFFFF?text=<?php echo strtoupper(substr($username, 0, 1)); ?>" alt="Avatar" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold text-sm text-brand-navy"><?php echo htmlspecialchars(ucfirst($username)); ?></p>
                        <p class="text-xs text-brand-gray">Yönetici</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                <!-- İstatistik Kartları -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Toplam Slayt Kartı -->
                    <div class="bg-brand-paper p-6 rounded-2xl shadow-custom flex items-center gap-5">
                        <div class="bg-brand-light-blue p-3 rounded-full">
                            <i class="fas fa-images text-2xl text-brand-purple"></i>
                        </div>
                        <div>
                            <p class="text-sm text-brand-gray font-medium">Toplam Slayt</p>
                            <p class="text-2xl font-bold text-brand-navy"><?php echo $totalSlides; ?></p>
                        </div>
                    </div>
                    <!-- Örnek İstatistik Kartı: Blog -->
                    <div class="bg-brand-paper p-6 rounded-2xl shadow-custom flex items-center gap-5">
                        <div class="bg-brand-light-blue p-3 rounded-full">
                             <i class="fas fa-newspaper text-2xl text-brand-success"></i>
                        </div>
                        <div>
                            <p class="text-sm text-brand-gray font-medium">Blog Yazıları</p>
                            <p class="text-2xl font-bold text-brand-navy">0</p>
                        </div>
                    </div>
                     <!-- Örnek İstatistik Kartı: Sayfalar -->
                    <div class="bg-brand-paper p-6 rounded-2xl shadow-custom flex items-center gap-5">
                        <div class="bg-brand-light-blue p-3 rounded-full">
                             <i class="fas fa-file-alt text-2xl text-orange-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-brand-gray font-medium">Sayfalar</p>
                            <p class="text-2xl font-bold text-brand-navy">0</p>
                        </div>
                    </div>
                     <!-- Örnek İstatistik Kartı: Mesajlar -->
                    <div class="bg-brand-paper p-6 rounded-2xl shadow-custom flex items-center gap-5">
                        <div class="bg-brand-light-blue p-3 rounded-full">
                             <i class="fas fa-envelope-open-text text-2xl text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-brand-gray font-medium">Gelen Mesajlar</p>
                            <p class="text-2xl font-bold text-brand-navy">0</p>
                        </div>
                    </div>
                </div>

                <!-- Hoşgeldin Mesajı -->
                <div class="bg-brand-paper p-8 rounded-2xl shadow-custom">
                    <h2 class="text-2xl font-bold text-brand-navy mb-3">Hoş Geldin, <?php echo htmlspecialchars(ucfirst($username)); ?>!</h2>
                    <p class="text-brand-secondary-gray">
                        Yönetim paneline hoş geldin. Sitenin içeriğini yönetmek ve genel istatistikleri görmek için sol taraftaki menüyü kullanabilirsin.
                    </p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
