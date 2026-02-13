<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pengaduan;

class SiswaAreaController extends Controller
{
    public function dashboard(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        $siswa = Siswa::find($siswaId);
        $total = 0;
        $selesai = 0;
        $last = null;
        $proses = 0;
        // By default, get recent pengaduan (limit 6)
        $otherPengaduans = Pengaduan::with(['kategori','siswa'])->orderBy('created_at','desc')->take(6)->get();

        if ($siswa) {
            $total = Pengaduan::where('pelapor', 'like', "%{$siswa->nama}%")->count();
            $selesai = Pengaduan::where('pelapor', 'like', "%{$siswa->nama}%")->where('status','Selesai')->count();
            $last = Pengaduan::where('pelapor', 'like', "%{$siswa->nama}%")->orderBy('created_at','desc')->first();
            $proses = Pengaduan::where('pelapor', 'like', "%{$siswa->nama}%")->where('status','Dalam Proses')->count();

            // If a siswa is logged in, exclude their own pengaduan from the recent list
            $otherPengaduans = Pengaduan::with(['kategori','siswa'])
                ->where('pelapor', 'not like', "%{$siswa->nama}%")
                ->orderBy('created_at','desc')
                ->take(6)
                ->get();
        }

        return view('siswa.dashboard', compact('siswa','total','selesai','last','proses','otherPengaduans'));
    }

    /**
     * Show paginated list of pengaduan from other students.
     */
    public function others(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        $siswa = $siswaId ? Siswa::find($siswaId) : null;

        // Available filters from query string
        $filterKategori = $request->query('kategori');
        $filterStatus = $request->query('status');
        $filterBulan = $request->query('bulan'); // expect month number '01'..'12'

        $query = Pengaduan::with(['kategori','siswa'])->orderBy('created_at','desc');
        if ($siswa) {
            $query->where('pelapor', 'not like', "%{$siswa->nama}%");
        }

        // Apply kategori filter
        if ($filterKategori) {
            $query->where('kategori_id', $filterKategori);
        }

        // Apply status filter
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        // Apply month filter (by month number)
        if ($filterBulan) {
            $query->whereMonth('created_at', intval($filterBulan));
        }

        // Clone query to get total before pagination
        $total = (clone $query)->count();

        $pengaduans = $query->paginate(12)->withQueryString();

        // load categories for filter select
        $kategoris = \App\Models\Kategori::orderBy('nama_kategori')->get();

        return view('siswa.others', compact('siswa','pengaduans','kategoris','total','filterKategori','filterStatus','filterBulan'));
    }

    public function createAspirasi()
    {
        $siswaId = session('siswa_id');
        $siswa = null;
        $pengaduansNonSelesai = collect();
        if ($siswaId) {
            $siswa = Siswa::find($siswaId);
            if ($siswa) {
                $pengaduansNonSelesai = Pengaduan::where('pelapor','like',"%{$siswa->nama}%")
                    ->where('status','!=','Selesai')
                    ->with('kategori')
                    ->orderBy('created_at','desc')
                    ->get();
            }
        }

        return view('siswa.create-aspirasi', compact('siswa','pengaduansNonSelesai'));
    }

    // Show a dedicated page for adding a new aspirasi (separate from the listing)
    public function tambahAspirasi()
    {
        $siswaId = session('siswa_id');
        $siswa = null;
        if ($siswaId) {
            $siswa = Siswa::find($siswaId);
        }

        $kategoris = \App\Models\Kategori::whereIn('nama_kategori', ['Sarana', 'Prasarana'])->get();
        return view('siswa.tambah-aspirasi', compact('siswa', 'kategoris'));
    }

    public function storeAspirasi(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);
        $siswaId = $request->session()->get('siswa_id');
        if (!$siswaId) {
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Silakan login sebagai siswa terlebih dahulu.']);
        }

        $siswa = Siswa::find($siswaId);
        if (!$siswa) {
            // clear invalid session and ask to login again
            $request->session()->forget('siswa_id');
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Sesi siswa tidak valid, silakan login ulang.']);
        }

        $data = [
            'pelapor' => $siswa->nama,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'status' => 'Dalam Proses',
            'lokasi' => $request->lokasi,
            'siswa_id' => $siswa->id,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $original = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $base = pathinfo($original, PATHINFO_FILENAME);
            $safeBase = preg_replace('/[^A-Za-z0-9-_]/', '_', $base);
            $filename = time() . '_' . $safeBase . '.' . $ext;

            $destDir = public_path('aspirasi');
            if (!file_exists($destDir)) {
                mkdir($destDir, 0755, true);
            }

            $file->move($destDir, $filename);
            $data['gambar'] = 'aspirasi/' . $filename;
        }

    Pengaduan::create($data);

    // After adding an aspirasi, redirect to the input-aspirasi listing page
    return redirect()->route('siswa.create-aspirasi')->with('success','Aspirasi berhasil dikirim');
    }

    public function history(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        $siswa = Siswa::find($siswaId);
        $pengaduans = collect();

        if ($siswa) {
            $pengaduans = Pengaduan::where('pelapor','like',"%{$siswa->nama}%")->with('kategori')->orderBy('created_at','desc')->get();
        }

        return view('siswa.history', compact('siswa','pengaduans'));
    }

    // Show logged-in siswa profile
    public function profile(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        if (!$siswaId) {
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Silakan login sebagai siswa terlebih dahulu.']);
        }

        $siswa = Siswa::find($siswaId);
        if (!$siswa) {
            $request->session()->forget('siswa_id');
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Sesi siswa tidak valid, silakan login ulang.']);
        }

        return view('siswa.profile', compact('siswa'));
    }

    // Show edit form for siswa profile
    public function editProfile(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        if (!$siswaId) {
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Silakan login sebagai siswa terlebih dahulu.']);
        }

        $siswa = Siswa::find($siswaId);
        if (!$siswa) {
            $request->session()->forget('siswa_id');
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Sesi siswa tidak valid, silakan login ulang.']);
        }

        return view('siswa.edit-profile', compact('siswa'));
    }

    // Handle profile update, including avatar upload
    public function updateProfile(Request $request)
    {
        $siswaId = $request->session()->get('siswa_id');
        if (!$siswaId) {
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Silakan login sebagai siswa terlebih dahulu.']);
        }

        $siswa = Siswa::find($siswaId);
        if (!$siswa) {
            $request->session()->forget('siswa_id');
            return redirect()->route('siswa.dashboard')->withErrors(['login' => 'Sesi siswa tidak valid, silakan login ulang.']);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->jurusan = $request->jurusan;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $ext = $file->getClientOriginalExtension();
            $filename = 'avatar_' . $siswa->id . '_' . time() . '.' . $ext;

            $destDir = public_path('avatars');
            if (!file_exists($destDir)) {
                mkdir($destDir, 0755, true);
            }

            $file->move($destDir, $filename);
            $siswa->avatar = 'avatars/' . $filename;
        }

        // Support base64 cropped avatar (from client-side Cropper) provided in `cropped_avatar`
        if (!$request->hasFile('avatar') && $request->filled('cropped_avatar')) {
            $data = $request->input('cropped_avatar');
            // data:image/jpeg;base64,/....
            if (preg_match('/^data:\w+\/(\w+);base64,/', $data, $m)) {
                $ext = $m[1] === 'jpeg' ? 'jpg' : $m[1];
                $data = substr($data, strpos($data, ',') + 1);
                $decoded = base64_decode($data);
                if ($decoded !== false) {
                    $filename = 'avatar_' . $siswa->id . '_' . time() . '.' . $ext;
                    $destDir = public_path('avatars');
                    if (!file_exists($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    file_put_contents($destDir . DIRECTORY_SEPARATOR . $filename, $decoded);
                    $siswa->avatar = 'avatars/' . $filename;
                }
            }
        }

        $siswa->save();

        return redirect()->route('siswa.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // Siswa: edit their own pengaduan
    public function editPengaduan(Request $request, \App\Models\Pengaduan $pengaduan)
    {
        $siswaId = $request->session()->get('siswa_id');
        if (!$siswaId || $pengaduan->siswa_id != $siswaId) {
            return redirect()->route('siswa.create-aspirasi')->withErrors(['access' => 'Anda tidak memiliki izin untuk mengedit pengaduan ini.']);
        }

        // Prevent editing when pengaduan already finished
        if (strtolower($pengaduan->status) === 'selesai') {
            return redirect()->route('siswa.create-aspirasi')->withErrors(['access' => 'Pengaduan sudah selesai dan tidak dapat diedit.']);
        }

        $kategoris = \App\Models\Kategori::all();
        return view('siswa.edit-pengaduan', compact('pengaduan', 'kategoris'));
    }

    public function updatePengaduan(Request $request, \App\Models\Pengaduan $pengaduan)
    {
        $siswaId = $request->session()->get('siswa_id');
        if (!$siswaId || $pengaduan->siswa_id != $siswaId) {
            return redirect()->route('siswa.create-aspirasi')->withErrors(['access' => 'Anda tidak memiliki izin untuk mengedit pengaduan ini.']);
        }

        // Prevent updating when pengaduan already finished
        if (strtolower($pengaduan->status) === 'selesai') {
            return redirect()->route('siswa.create-aspirasi')->withErrors(['access' => 'Pengaduan sudah selesai dan tidak dapat diubah.']);
        }

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['kategori_id','deskripsi','lokasi']);
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $original = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $base = pathinfo($original, PATHINFO_FILENAME);
            $safeBase = preg_replace('/[^A-Za-z0-9-_]/', '_', $base);
            $filename = time() . '_' . $safeBase . '.' . $ext;

            $destDir = public_path('aspirasi');
            if (!file_exists($destDir)) {
                mkdir($destDir, 0755, true);
            }

            $file->move($destDir, $filename);
            $data['gambar'] = 'aspirasi/' . $filename;
        }

    $pengaduan->update($data);
    return redirect()->route('siswa.create-aspirasi')->with('success','Pengaduan berhasil diupdate');
    }

    public function destroyPengaduan(Request $request, \App\Models\Pengaduan $pengaduan)
    {
        $siswaId = $request->session()->get('siswa_id');
        if (!$siswaId || $pengaduan->siswa_id != $siswaId) {
            return redirect()->route('siswa.create-aspirasi')->withErrors(['access' => 'Anda tidak memiliki izin untuk menghapus pengaduan ini.']);
        }

        // Prevent deleting when pengaduan already finished
        if (strtolower($pengaduan->status) === 'selesai') {
            return redirect()->route('siswa.create-aspirasi')->withErrors(['access' => 'Pengaduan sudah selesai dan tidak dapat dihapus.']);
        }

    $pengaduan->delete();
    return redirect()->route('siswa.create-aspirasi')->with('success','Pengaduan berhasil dihapus');
    }
}
