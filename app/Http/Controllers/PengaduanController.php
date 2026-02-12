<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with('kategori');

        // Filter berdasarkan tanggal spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan siswa (mencocokkan nama pelapor dengan nama siswa)
        if ($request->filled('siswa_id')) {
            $siswa = \App\Models\Siswa::find($request->siswa_id);
            if ($siswa) {
                $query->where('pelapor', 'like', '%' . $siswa->nama . '%');
            }
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        $pengaduans = $query->get();
        $kategoris = Kategori::all();
        $siswas = \App\Models\Siswa::all(); // Tambahkan data siswa

        // Handle export
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->export($request);
        }

        return view('daftar-pengaduan', compact('pengaduans', 'kategoris', 'siswas'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('pengaduan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelapor' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
        ]);

    Pengaduan::create($request->all());
    return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil ditambahkan');
    }

    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        $kategoris = Kategori::all();
        return view('pengaduan.edit', compact('pengaduan', 'kategoris'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'pelapor' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
                'status' => 'required|in:Dalam Proses,Selesai,Menunggu',
        ]);

    $pengaduan->update($request->all());
    return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil diupdate');
    }

    public function destroy(Pengaduan $pengaduan)
    {
    $pengaduan->delete();
    return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus');
    }

    public function selesai(Pengaduan $pengaduan)
    {
    $pengaduan->update(['status' => 'Selesai']);
    return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil diselesaikan');
    }

    // Admin: update status and feedback
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
                'status' => 'required|in:Dalam Proses,Selesai,Menunggu',
            'feedback' => 'nullable|string',
        ]);

        // Prevent updates if already marked as Selesai
        if (strtolower($pengaduan->status) === 'selesai') {
            return redirect()->route('admin.daftar-pengaduan')
                ->with('error', 'Pengaduan sudah selesai dan tidak dapat diubah');
        }

        $pengaduan->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        // After admin updates status/feedback, send them back to the data pengaduan list
        return redirect()->route('admin.daftar-pengaduan')->with('success', 'Status dan feedback berhasil diperbarui');
    }

    public function export(Request $request)
    {
        // Ambil data pengaduan yang sudah difilter (sama dengan index method)
        $query = Pengaduan::with('kategori');

        // Filter berdasarkan tanggal spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan siswa (mencocokkan nama pelapor dengan nama siswa)
        if ($request->filled('siswa_id')) {
            $siswa = \App\Models\Siswa::find($request->siswa_id);
            if ($siswa) {
                $query->where('pelapor', 'like', '%' . $siswa->nama . '%');
            }
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $pengaduans = $query->get();

        // Untuk sementara, redirect dengan pesan dan info jumlah data
        $message = 'Fitur export PDF akan segera diimplementasikan. ';
        $message .= 'Data yang akan diexport: ' . $pengaduans->count() . ' pengaduan';

        if ($request->filled('kategori_id') || $request->filled('status') || $request->filled('tanggal') || $request->filled('siswa_id')) {
            $message .= ' (dengan filter aktif)';
        }

    return redirect()->route('admin.daftar-pengaduan', $request->query())
            ->with('info', $message);
    }
}
