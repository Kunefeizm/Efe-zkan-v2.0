<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Yetkisiz erişim.']);
    exit;
}

require_once 'helper.php';

// Gelen JSON verisini al
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['order']) && is_array($input['order'])) {
    $sliderData = getSliderData();
    $newOrder = $input['order'];
    $reorderedData = [];

    // Gelen sıralamaya göre veriyi yeniden düzenle
    foreach ($newOrder as $oldIndex) {
        if (isset($sliderData[$oldIndex])) {
            $reorderedData[] = $sliderData[$oldIndex];
        }
    }

    // Yeni sıralanmış veriyi kaydet
    saveSliderData($reorderedData);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

header('Content-Type: application/json');
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Geçersiz veri.']);
?>
