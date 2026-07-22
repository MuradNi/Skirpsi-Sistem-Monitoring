<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $query = Siswa::with(['kelas', 'user']);

        if ($kelasId && $kelasId !== 'all') {
            $query->where('kelas_id', $kelasId);
        }

        $siswaList = $query->get();
        $kelasList = Kelas::all();

        return view('dashboard.siswa.kelola', compact('siswaList', 'kelasList', 'kelasId'));
    }

    public function create()
    {
        $kelasList = Kelas::all();
        $users = User::where('role', 'siswa')->get();
        $parents = User::where('role', 'orang_tua')->get();

        return view('dashboard.siswa.tambah', compact('kelasList', 'users', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:siswas,nis'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'jenis_kelamin' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'user_id' => ['nullable', 'exists:users,id', 'unique:siswas,user_id'],
            'parent_user_id' => ['nullable', 'exists:users,id'],
            'foto' => ['nullable', 'string'],
        ]);

        if (empty($validated['foto'])) {
            $validated['foto'] = 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . urlencode($validated['nama_lengkap']);
        }

        Siswa::create($validated);

        return redirect()->route('dashboard.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelasList = Kelas::all();
        $users = User::where('role', 'siswa')->get();
        $parents = User::where('role', 'orang_tua')->get();

        return view('dashboard.siswa.ubah', compact('siswa', 'kelasList', 'users', 'parents'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:siswas,nis,' . $siswa->id],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'jenis_kelamin' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'user_id' => ['nullable', 'exists:users,id', 'unique:siswas,user_id,' . $siswa->id],
            'parent_user_id' => ['nullable', 'exists:users,id'],
            'foto' => ['nullable', 'string'],
        ]);

        $siswa->update($validated);

        return redirect()->route('dashboard.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('dashboard.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
