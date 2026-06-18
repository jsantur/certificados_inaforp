<?php
require_once __DIR__ . '/../config/db.php';

if (!isset($_GET['key'])) {
    die("Key no proporcionada.");
}
$key = $_GET['key'];

$stmt = $pdo->prepare("SELECT * FROM certificados WHERE key_hash = :key");
$stmt->execute(['key' => $key]);
$cert = $stmt->fetch();

if (!$cert) {
    die("Certificado no encontrado.");
}

$code = $cert['codigo'];
    $possiblePaths = [
        __DIR__ . '/../certificados/' . $code . '/' . $code . '.pdf',
        // fallback generic path
        __DIR__ . '/certificado.pdf',
    ];

$pdfPath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $pdfPath = $path;
        break;
    }
}

if (!$pdfPath) {
    die("PDF del certificado no encontrado.");
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="certificado_' . $key . '.pdf"');
header('Content-Length: ' . filesize($pdfPath));
readfile($pdfPath);
?>
