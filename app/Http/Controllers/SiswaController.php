<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::all();
        return view('data-siswa', compact('siswas'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|digits:10|unique:siswas',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'username' => 'required|unique:siswas,username',
            'password' => 'required|min:6',
        ]);
        // Siswa model hashes password via mutator
    Siswa::create($request->all());
    return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|digits:10|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'username' => 'nullable|unique:siswas,username,' . $siswa->id,
        ]);

        $data = $request->only(['nis','nama','kelas','jurusan','username']);
        if ($request->filled('password')) {
            $data['password'] = $request->password; // mutator will hash
        }

    $siswa->update($data);
    return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diupdate');
    }

    public function destroy(Siswa $siswa)
    {
    $siswa->delete();
    return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}
