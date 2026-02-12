<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::create([
            'nis' => '12345',
            'nama' => 'Ahmad',
            'kelas' => '12',
            'jurusan' => 'RPL',
            'username' => 'ahmad',
            'password' => 'password123',
        ]);

        Siswa::create([
            'nis' => '12346',
            'nama' => 'Budi',
            'kelas' => '11',
            'jurusan' => 'TKJ',
            'username' => 'budi',
            'password' => 'password123',
        ]);
    }
}
