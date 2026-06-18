<?php
require_once __DIR__ . '/../config/db.php';

// Soportamos tanto 'msg' como 'key'
if (isset($_GET['key'])) {
    $key = $_GET['key'];
} elseif (isset($_GET['msg'])) {
    // Extraer el key del parámetro msg si viene como URL
    preg_match('/key=([A-Fa-f0-9]+)/', $_GET['msg'], $matches);
    $key = $matches[1] ?? null;
} else {
    die("Key no proporcionada.");
}

if (!$key) {
    die("Key no proporcionada.");
}

$stmt = $pdo->prepare("SELECT * FROM certificados WHERE key_hash = :key");
$stmt->execute(['key' => $key]);
$cert = $stmt->fetch();

if (!$cert) {
    die("Certificado no encontrado.");
}

// Buscar la imagen QR existente
$code = $cert['codigo'];
$possiblePaths = [
    __DIR__ . '/../certificados/' . $code . '/QR_' . $code . '.png',
    // fallback generic (unlikely)
    __DIR__ . '/qr.png',
];
$qrPath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $qrPath = $path;
        break;
    }
}

if (!$qrPath) {
    die("Imagen QR no encontrada.");
}

header('Content-Type: image/png');
header('Content-Disposition: inline; filename="qr_' . $key . '.png"');
header('Content-Length: ' . filesize($qrPath));
readfile($qrPath);
?>
