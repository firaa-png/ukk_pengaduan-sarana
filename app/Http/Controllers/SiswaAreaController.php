<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pengaduan;

class SiswaAreaController extends Controller
{
    public function dashboard(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        $siswa = Siswa::find($siswaId);
        $total = Pengaduan::where('pelapor', 'like', "%{$siswa->nama}%")->count();
        $selesai = Pengaduan::where('pelapor', 'like', "%{$siswa->nama}%")->where('status','Selesai')->count();
        return view('siswa.dashboard', compact('siswa','total','selesai'));
    }

    public function createAspirasi()
    {
        return view('siswa.create-aspirasi');
    }

    public function storeAspirasi(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
        ]);

        $siswaId = $request->session()->get('siswa_id');
        $siswa = Siswa::find($siswaId);

        Pengaduan::create([
            'pelapor' => $siswa->nama,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'status' => 'Dalam Proses',
        ]);

        return redirect()->route('siswa.create-aspirasi')->with('success','Aspirasi berhasil dikirim');
    }

    public function history(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        $siswa = Siswa::find($siswaId);
        $pengaduans = Pengaduan::where('pelapor','like',"%{$siswa->nama}%")->with('kategori')->orderBy('created_at','desc')->get();
        return view('siswa.history', compact('siswa','pengaduans'));
    }

    public function quickLogin(Request $request)
    {
        $request->validate([
            'nis' => 'required|digits:10',
            'kelas' => 'required|string',
        ]);

        $siswa = Siswa::where('nis', $request->nis)->where('kelas', $request->kelas)->first();
        if (!$siswa) {
            return back()->withErrors(['nis' => 'NIS atau kelas tidak ditemukan.'])->withInput();
        }

        session(['siswa_id' => $siswa->id]);
        return redirect()->route('siswa.dashboard');
    }
}
