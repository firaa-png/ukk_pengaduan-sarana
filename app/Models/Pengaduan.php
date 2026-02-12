<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = ['pelapor', 'kategori_id', 'deskripsi', 'status', 'lokasi', 'gambar', 'siswa_id', 'feedback', 'aspek', 'sub_aspek'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
