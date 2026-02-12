<?php
// Dump first 50 rows from siswas table using MySQL connection values from the env file.
$envPath = __DIR__ . '/../env';
if (!file_exists($envPath)) {
    echo json_encode(["error" => "env file not found", "path" => $envPath]);
    exit(1);
}
$env = file_get_contents($envPath);
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
    $stmt = $pdo->query("SELECT * FROM siswas LIMIT 50");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["count" => count($rows), "rows" => $rows], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit(1);
}
