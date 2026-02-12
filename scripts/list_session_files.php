<?php
$dir = __DIR__ . '/../storage/framework/sessions';
if (!is_dir($dir)) { echo "NOT_DIR\n"; exit(1); }
$files = array_diff(scandir($dir), ['.','..','.gitkeep','.gitignore']);
if (!$files) { echo "(no session files)\n"; exit(0); }
foreach ($files as $f) {
    $path = $dir . DIRECTORY_SEPARATOR . $f;
    echo "FILE: $f\n";
    $c = file_get_contents($path);
    echo substr($c,0,800) . PHP_EOL;
    echo str_repeat('-',60) . PHP_EOL;
}
