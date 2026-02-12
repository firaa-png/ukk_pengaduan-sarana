<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['nama_kategori' => 'Sarana', 'deskripsi' => 'Sarana'],
            ['nama_kategori' => 'Prasarana', 'deskripsi' => 'Prasarana'],
        ];

        foreach ($items as $it) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $it['nama_kategori']],
                ['deskripsi' => $it['deskripsi']]
            );
        }
    }
}
