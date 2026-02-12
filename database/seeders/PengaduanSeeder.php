<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaduan::create([
            'pelapor' => 'Ahmad',
            'kategori_id' => 1,
            'deskripsi' => 'Pengaduan tentang fasilitas yang kurang memadai di ruang kelas.',
            'status' => 'Dalam Proses',
        ]);

        Pengaduan::create([
            'pelapor' => 'Budi',
            'kategori_id' => 2,
            'deskripsi' => 'Laporan kerusakan komputer di laboratorium.',
            'status' => 'Selesai',
        ]);
    }
}
