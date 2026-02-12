<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = $argv[1] ?? null;
$name = $argv[2] ?? null;
if (!$email || !$name) {
    echo "Usage: php scripts/set_user_name.php email newname\n";
    exit(1);
}

$user = User::where('email', $email)->first();
if (!$user) {
    echo "User not found: $email\n";
    exit(1);
}

$user->name = $name;
$user->save();

echo "Updated name for user {$user->id} to {$name}\n";
