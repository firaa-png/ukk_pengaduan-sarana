<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class HomeController extends Controller
{
    public function index()
    {
        // Count pengaduan based on status
        $totalPengaduanCount = Pengaduan::count(); // Total pengaduan
        $pengaduanSelesaiCount = Pengaduan::where('status', 'Selesai')->count();
        $pengaduanDalamProsesCount = Pengaduan::where('status', 'Dalam Proses')->count();
        // Pengaduan Masuk could mean total or newly submitted, depending on interpretation
        // For now, using total as "masuk" (incoming)
        $pengaduanMasukCount = $totalPengaduanCount;

        // Calculate percentage of completed pengaduan (guard division by zero)
        $persenSelesai = 0;
        if ($totalPengaduanCount > 0) {
            $persenSelesai = (int) round(($pengaduanSelesaiCount / $totalPengaduanCount) * 100);
        }

        return view('index', compact(
            'pengaduanMasukCount',
            'pengaduanSelesaiCount',
            'pengaduanDalamProsesCount',
            'totalPengaduanCount',
            'persenSelesai'
        ));
    }
}