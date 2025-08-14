<?php
// panel/tools/header.php - Merkezi Panel Üst Bölümü
session_start();

// Bu dosyanın çağrıldığı sayfanın yolunu alalım.
$caller_script_path = debug_backtrace()[0]['file'];

// panel/ dizinine olan göreceli yolu hesaplayalım.
// Bu, login.php'ye doğru yönlendirme yapmak için gereklidir.
$path_to_panel_root = str_repeat('../', substr_count(dirname($caller_script_path), DIRECTORY_SEPARATOR) - substr_count(dirname(__DIR__, 2), DIRECTORY_SEPARATOR));
$login_path = $path_to_panel_root . 'login.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ' . $login_path);
    exit;
}

$username = $_SESSION['username'] ?? 'Kullanıcı';

// Sayfa başlıklarını dinamik olarak ayarlamak için
$page_title = $page_title ?? 'Yönetim Paneli';
$page_subtitle = $page_subtitle ?? 'Genel Bakış';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Horizon Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        // Merkezi Tailwind CSS Yapılandırması
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
    <style>
        body { background-color: #F4F7FE; font-family: 'DM Sans', sans-serif; }
        .sortable-ghost { opacity: 0.4; background: #E9E3FF; border: 2px dashed #4318FF; }
        .handle { cursor: grab; }
        .handle:active { cursor: grabbing; }
        .toast-enter-active, .toast-leave-active { transition: all 0.5s ease; }
        .toast-enter-from, .toast-leave-to { opacity: 0; transform: translateY(-20px); }
        .modal-backdrop { transition: opacity 0.3s ease; }
        .modal-content { transition: transform 0.3s ease; }
    </style>
</head>
<body class="font-sans">
    <div class="flex h-screen bg-brand-light-blue">
        <?php
            // Merkezi sidebar'ı çağırıyoruz. __DIR__ sayesinde yol her zaman doğru çalışır.
            require_once __DIR__ . '/sidebar.php';
        ?>

        <!-- Ana İçerik Alanı -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white/80 backdrop-blur-sm p-6 flex justify-between items-center border-b border-gray-200">
                <div>
                    <p class="text-sm text-brand-gray">Sayfalar / <?php echo htmlspecialchars($page_title); ?></p>
                    <h2 class="text-3xl font-bold text-brand-navy"><?php echo htmlspecialchars($page_subtitle); ?></h2>
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
