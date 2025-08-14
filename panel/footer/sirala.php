<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Yetkisiz erişim.']);
    exit;
}
require_once 'helper.php';

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['order']) && is_array($input['order'])) {
    $data = getFooterData();
    $newOrder = $input['order'];
    $reorderedData = [];

    // Gelen sıralamaya göre veriyi yeniden düzenle
    foreach ($newOrder as $oldIndex) {
        if (isset($data['link_columns'][$oldIndex])) {
            $reorderedData[] = $data['link_columns'][$oldIndex];
        }
    }
    
    // Eğer eleman sayısı uyuşmuyorsa bir hata vardır, işlemi durdur.
    if(count($reorderedData) !== count($data['link_columns'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Veri uyuşmazlığı.']);
        exit;
    }

    $data['link_columns'] = $reorderedData;
    saveFooterData($data);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Geçersiz veri.']);
