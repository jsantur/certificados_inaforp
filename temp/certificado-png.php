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

    // Construir la ruta del archivo de imagen basado en el código del certificado
    $code = $cert['codigo'];
    $possiblePaths = [
        __DIR__ . '/../certificados/' . $code . '/' . $code . '.jpg',
        __DIR__ . '/../certificados/' . $code . '/' . $code . '.png',
        // Fallback genérico (no usado normalmente)
        __DIR__ . '/certificado-png.png',
        __DIR__ . '/../images/401327.jpg',
    ];

$imagePath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $imagePath = $path;
        break;
    }
}

if (!$imagePath) {
    die("Imagen del certificado no encontrada.");
}

// Detectar el tipo de imagen
$ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
switch ($ext) {
    case 'jpg':
    case 'jpeg':
        $contentType = 'image/jpeg';
        break;
    case 'png':
        $contentType = 'image/png';
        break;
    default:
        $contentType = 'image/jpeg';
}

header('Content-Type: ' . $contentType);
header('Content-Disposition: inline; filename="certificado_' . $key . '.' . $ext . '"');
header('Content-Length: ' . filesize($imagePath));
readfile($imagePath);
?>
