<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(403);
    exit('Yetkisiz erişim.');
}
require_once 'helper.php';

$slideId = isset($_GET['id']) ? (int)$_GET['id'] : -1;
$sliderData = getSliderData();

if ($slideId !== -1 && isset($sliderData[$slideId])) {
    // Görseli URL'den alarak sil (helper fonksiyonu zaten basename işlemini yapıyor)
    if(isset($sliderData[$slideId]['image_url'])) {
        // DÜZELTME: `basename()` çağrısı kaldırıldı, çünkü helper fonksiyonu bunu zaten yapıyor.
        deleteImage($sliderData[$slideId]['image_url']);
    }
    
    // Slaytı veriden kaldır
    array_splice($sliderData, $slideId, 1);
    
    // Güncellenmiş veriyi kaydet
    saveSliderData($sliderData);
    
    header("Location: index.php?status=" . urlencode('Slayt başarıyla silindi.'));
    exit;
} else {
    header("Location: index.php?status=" . urlencode('Hata: Geçersiz slayt ID.'));
    exit;
}
?>
