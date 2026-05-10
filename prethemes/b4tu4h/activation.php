<?php
header('Content-Type: application/json');

// Path file JSON
$jsonFile = __DIR__ . 'https://raw.githubusercontent.com/syabiz/osid/refs/heads/main/prethemes/b4tu4h/clients.json';

if (!file_exists($jsonFile)) {
    echo json_encode(['errors' => 'System error: data not found']);
    exit;
}

// Baca dan parse JSON
$jsonContent = file_get_contents($jsonFile);
$clients = json_decode($jsonContent, true);

if (!$clients) {
    echo json_encode(['errors' => 'Invalid data format']);
    exit;
}

// Ambil parameter
$token = $_GET['token'] ?? '';
$desa_config = $_GET['desa_config'] ?? '';

if (empty($token) || empty($desa_config)) {
    echo json_encode(['errors' => 'Token and desa_config required']);
    exit;
}

// Cari client yang cocok
$found = null;
foreach ($clients as $client) {
    if ($client['token'] === $token && $client['desa_config'] === $desa_config) {
        $found = $client;
        break;
    }
}

if (!$found) {
    echo json_encode(['errors' => 'Invalid token or desa_config']);
    exit;
}

if ($found['status'] != 1) {
    echo json_encode(['errors' => 'Account inactive']);
    exit;
}

if (strtotime($found['expired_at']) < time()) {
    echo json_encode(['errors' => 'License expired']);
    exit;
}

// Sukses
echo json_encode([
    'lisensi' => $found['lisensi'],
    'expired' => $found['expired_at']
]);