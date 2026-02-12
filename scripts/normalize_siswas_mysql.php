<?php
// Normalize siswas: trim nis and kelas, lowercase kelas
$envPath = __DIR__ . '/../env';
$env = file_exists($envPath) ? file_get_contents($envPath) : '';
$lines = preg_split('/\r?\n/', $env);
$config = [];
foreach ($lines as $line) {
    if (trim($line) === '' || strpos(trim($line), '#') === 0) continue;
    if (!strpos($line, '=')) continue;
    [$k, $v] = explode('=', $line, 2);
    $config[trim($k)] = trim($v, "\"' ");
}
$driver = $config['DB_CONNECTION'] ?? 'mysql';
if ($driver !== 'mysql') {
    echo json_encode(["error" => "DB_CONNECTION in env is not mysql", "DB_CONNECTION" => $driver]);
    exit(1);
}
$host = $config['DB_HOST'] ?? '127.0.0.1';
$port = $config['DB_PORT'] ?? '3306';
$db   = $config['DB_DATABASE'] ?? '';
$user = $config['DB_USERNAME'] ?? '';
$pass = $config['DB_PASSWORD'] ?? '';
try {
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    // Update nis and kelas (trim) and lowercase kelas
    $updates = [];
    $updates[] = "UPDATE siswas SET nis = TRIM(nis) WHERE nis IS NOT NULL";
    $updates[] = "UPDATE siswas SET kelas = LOWER(TRIM(kelas)) WHERE kelas IS NOT NULL";
    foreach ($updates as $sql) {
        $pdo->exec($sql);
    }
    echo json_encode(["status" => "ok", "executed" => $updates], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit(1);
}
