<?php
$path = __DIR__ . '/../database/database.sqlite';
if (!file_exists($path)) {
    echo "MISSING_FILE\n";
    exit(1);
}
try {
    $pdo = new PDO('sqlite:' . realpath($path));
    $stmt = $pdo->query("SELECT id, user_id, ip_address, substr(payload,1,200) as payload_preview, last_activity FROM sessions ORDER BY last_activity DESC LIMIT 10");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
        echo "(no sessions)\n";
        exit(0);
    }
    foreach ($rows as $r) {
        echo "ID: " . $r['id'] . PHP_EOL;
        echo "User ID: " . $r['user_id'] . PHP_EOL;
        echo "IP: " . $r['ip_address'] . PHP_EOL;
        echo "Last activity: " . $r['last_activity'] . PHP_EOL;
        echo "Payload preview: " . $r['payload_preview'] . PHP_EOL;
        echo str_repeat('-',40) . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
