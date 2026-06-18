<?php
$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_DATABASE') ?: 'certificados_db';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';

$dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_TIMEOUT            => 10,
];

$maxAttempts = (int)(getenv('DB_CONNECT_RETRIES') ?: 3);
$lastException = null;

for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        $lastException = null;
        break;
    } catch (\PDOException $e) {
        $lastException = $e;
        if ($attempt < $maxAttempts) {
            usleep(250000 * $attempt);
        }
    }
}

if ($lastException instanceof \PDOException) {
    error_log('DB connection failed after ' . $maxAttempts . ' attempts: ' . $lastException->getMessage());
    throw new \PDOException($lastException->getMessage(), (int)$lastException->getCode());
}
