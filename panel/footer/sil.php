<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    exit('Yetkisiz erişim.');
}
require_once 'helper.php';

$type = $_GET['type'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;

if ($id === -1) {
    header("Location: index.php?status=" . urlencode('Hata: Geçersiz ID.'));
    exit;
}

$data = getFooterData();

if ($type === 'column' && isset($data['link_columns'][$id])) {
    array_splice($data['link_columns'], $id, 1);
    saveFooterData($data);
    header("Location: index.php?status=" . urlencode('Sütun başarıyla silindi.'));
    exit;
}

header("Location: index.php?status=" . urlencode('Hata: Silinecek öğe bulunamadı.'));
exit;
