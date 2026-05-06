<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$kode = $_GET['kode'] ?? '';

// Daftar kode yang statusnya true
$kode_valid = [
    '3208082007', // Desa Garawangi, Kec. Garawangi, Kab. Kuningan, Jawa Barat
    '3328182006',
    '3328182007',
    '3328182008',
    '3328182009',
    // tambahkan kode lainnya di sini...
];

if (in_array($kode, $kode_valid)) {
    echo json_encode(['status' => true]);
} else {
    echo json_encode(['status' => false]);
}
