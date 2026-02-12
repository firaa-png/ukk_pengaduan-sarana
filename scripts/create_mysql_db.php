<?php
// Create the MySQL database defined in the project's .env file if it doesn't exist.
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    echo "Error: .env file not found at $envPath\n";
    exit(1);
}

$contents = file_get_contents($envPath);
$lines = preg_split('/\r?\n/', $contents);
$config = [];
foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#') continue;
    if (strpos($line, '=') === false) continue;
    [$k, $v] = explode('=', $line, 2);
    $config[trim($k)] = trim($v, "\"' ");
}

$driver = $config['DB_CONNECTION'] ?? 'mysql';
if (strtolower($driver) !== 'mysql') {
    echo "Skipping: DB_CONNECTION is not mysql (found: $driver)\n";
    exit(0);
}

$host = $config['DB_HOST'] ?? '127.0.0.1';
$port = $config['DB_PORT'] ?? '3306';
$user = $config['DB_USERNAME'] ?? 'root';
$pass = $config['DB_PASSWORD'] ?? '';
$db   = $config['DB_DATABASE'] ?? 'db_sarana';

try {
    $dsn = "mysql:host=$host;port=$port";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "OK: database `$db` ensured on $host:$port\n";
    exit(0);
} catch (Exception $e) {
    echo "ERROR: Could not create database `$db`: " . $e->getMessage() . "\n";
    exit(1);
}
