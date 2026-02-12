<?php
// Usage: php scripts/set_admin_password.php [username] [newpassword]
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$username = $argv[1] ?? 'admin';
$new = $argv[2] ?? '123456';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('name', $username)->orWhere('email', $username)->first();
if (!$user) {
    echo "User not found: $username\n";
    exit(1);
}

$user->password = Hash::make($new);
$user->save();

echo "Password updated for user {$user->id} ({$username})\n"; 
