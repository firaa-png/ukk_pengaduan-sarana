<?php
$db = new PDO('sqlite:database/database.sqlite');
$stmt = $db->query('SELECT id, name, email, created_at FROM users');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo $r['id'] . " | " . $r['name'] . " | " . $r['email'] . " | " . $r['created_at'] . "\n";
}
?>