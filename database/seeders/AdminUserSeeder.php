<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@example.com';
        $name = 'Administrator';
        $username = 'admin';
        $password = 'password';

        $user = User::where('email', $email)->orWhere('name', $username)->first();
        if ($user) {
            // update password in case user exists but password unknown
            $user->password = Hash::make($password);
            $user->name = $name;
            $user->email = $email;
            $user->save();
            return;
        }

        User::create([
            'name' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
