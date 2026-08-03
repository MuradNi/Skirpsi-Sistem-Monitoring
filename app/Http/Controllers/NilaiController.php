<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Raport;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Jika guru, otomatis batasi hanya ke kelas milik guru tersebut
        if ($user->role === 'guru') {
            $guruKelas = Kelas::where('wali_kelas_id', $user->id)->first();
            $kelasId = $guruKelas ? $guruKelas->id : 1;
            $kelasList = $guruKelas ? collect([$guruKelas]) : Kelas::all();
        } else {
            $kelasId = $request->input('kelas_id', 1);
            $kelasList = Kelas::all();
        }

        $mapelId = $request->input('mata_pelajaran_id', 1);
        $mapelList = MataPelajaran::all();

        $siswaList = Siswa::where('kelas_id', $kelasId)->get();

        $inputGrades = [];
        $selectedMapel = MataPelajaran::find($mapelId);

        foreach ($siswaList as $s) {
            // Fetch all individual Nilai records for this student and mapel
            $allNilais = Nilai::where('siswa_id', $s->id)
                ->where('mata_pelajaran_id', $mapelId)
                ->where('semester', 2)
                ->where('tahun_ajaran', '2024/2025')
                ->get();

            $uh1Scores = $allNilais->where('jenis', 'uh1')->values()->toArray();
            $uh2Scores = $allNilais->where('jenis', 'uh2')->values()->toArray();

            $utsRecord = $allNilais->where('jenis', 'uts')->first();
            $uasRecord = $allNilais->where('jenis', 'uas')->first();

            $uh1Avg = count($uh1Scores) > 0 ? round(collect($uh1Scores)->avg('nilai'), 1) : null;
            $uh2Avg = count($uh2Scores) > 0 ? round(collect($uh2Scores)->avg('nilai'), 1) : null;
            $utsVal = $utsRecord ? $utsRecord->nilai : null;
            $uasVal = $uasRecord ? $uasRecord->nilai : null;

            // Fetch Raport catatan if it exists
            $raport = Raport::where('siswa_id', $s->id)
                ->where('mata_pelajaran_id', $mapelId)
                ->where('semester', 2)
                ->where('tahun_ajaran', '2024/2025')
                ->first();

            $inputGrades[] = [
                'nis' => $s->nis,
                'id' => $s->id,
                'nama_lengkap' => $s->nama_lengkap,
                'nilai_uh1' => $uh1Avg,
                'nilai_uts' => $utsVal,
                'nilai_uh2' => $uh2Avg,
                'nilai_uas' => $uasVal,
                'keterangan' => $raport ? $raport->catatan : '',
                'kkm' => $selectedMapel ? $selectedMapel->kkm : 70,
                'tuntas' => $raport ? $raport->tuntas : false,
                'uh1_scores' => $uh1Scores,
                'uh2_scores' => $uh2Scores,
            ];
        }

        return view('dashboard.nilai.input', compact(
            'kelasList', 'mapelList', 'inputGrades', 'kelasId', 'mapelId', 'selectedMapel'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
            'nilai_uts' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $siswaId = $validated['siswa_id'];
        $kelasId = $validated['kelas_id'];
        $mapelId = $validated['mata_pelajaran_id'];
        $guruId = auth()->id();

        // 1. Process UTS
        if ($validated['nilai_uts'] !== null && $validated['nilai_uts'] !== '') {
            Nilai::updateOrCreate([
                'siswa_id' => $siswaId,
                'mata_pelajaran_id' => $mapelId,
                'jenis' => 'uts',
                'semester' => 2,
                'tahun_ajaran' => '2024/2025',
            ], [
                'guru_id' => $guruId,
                'nilai' => $validated['nilai_uts'],
                'keterangan' => 'Nilai UTS',
                'tanggal' => date('Y-m-d'),
            ]);
        } else {
            Nilai::where('siswa_id', $siswaId)
                ->where('mata_pelajaran_id', $mapelId)
                ->where('jenis', 'uts')
                ->where('semester', 2)
                ->where('tahun_ajaran', '2024/2025')
                ->delete();
        }

        // 2. Process UAS
        if ($validated['nilai_uas'] !== null && $validated['nilai_uas'] !== '') {
            Nilai::updateOrCreate([
                'siswa_id' => $siswaId,
                'mata_pelajaran_id' => $mapelId,
                'jenis' => 'uas',
                'semester' => 2,
                'tahun_ajaran' => '2024/2025',
            ], [
                'guru_id' => $guruId,
                'nilai' => $validated['nilai_uas'],
                'keterangan' => 'Nilai UAS',
                'tanggal' => date('Y-m-d'),
            ]);
        } else {
            Nilai::where('siswa_id', $siswaId)
                ->where('mata_pelajaran_id', $mapelId)
                ->where('jenis', 'uas')
                ->where('semester', 2)
                ->where('tahun_ajaran', '2024/2025')
                ->delete();
        }

        // 3. Process Raport Catatan
        $keterangan = $validated['keterangan'] ?? '';
        
        $raport = Raport::firstOrNew([
            'siswa_id' => $siswaId,
            'mata_pelajaran_id' => $mapelId,
            'semester' => 2,
            'tahun_ajaran' => '2024/2025',
        ]);
        
        $raport->catatan = $keterangan;
        $raport->save();

        // Trigger manual recalculation
        Nilai::recalculateRaport($siswaId, $mapelId, 2, '2024/2025');

        return redirect()->route('dashboard.nilai.index', [
            'kelas_id' => $kelasId,
            'mata_pelajaran_id' => $mapelId,
            'open_siswa_id' => $siswaId,
        ])->with('success', 'Data nilai berhasil disimpan.');
    }

    public function addUh(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
            'jenis' => ['required', 'in:uh1,uh2'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string'],
            'tanggal' => ['required', 'date'],
        ]);

        $siswaId = $validated['siswa_id'];
        $kelasId = $validated['kelas_id'];
        $mapelId = $validated['mata_pelajaran_id'];
        $guruId = auth()->id();

        Nilai::create([
            'siswa_id' => $siswaId,
            'mata_pelajaran_id' => $mapelId,
            'guru_id' => $guruId,
            'jenis' => $validated['jenis'],
            'semester' => 2,
            'tahun_ajaran' => '2024/2025',
            'nilai' => $validated['nilai'],
            'keterangan' => $validated['keterangan'] ?? 'Nilai Harian ' . strtoupper($validated['jenis']),
            'tanggal' => $validated['tanggal'],
        ]);

        // Manually trigger recalculation
        Nilai::recalculateRaport($siswaId, $mapelId, 2, '2024/2025');

        return redirect()->route('dashboard.nilai.index', [
            'kelas_id' => $kelasId,
            'mata_pelajaran_id' => $mapelId,
            'open_siswa_id' => $siswaId,
        ])->with('success', 'Nilai harian berhasil ditambahkan.');
    }

    public function updateUh(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $siswaId = $validated['siswa_id'];
        $kelasId = $validated['kelas_id'];
        $mapelId = $validated['mata_pelajaran_id'];

        $nilai = Nilai::findOrFail($id);
        
        if ($nilai->siswa_id != $siswaId || $nilai->mata_pelajaran_id != $mapelId) {
            abort(403, 'Aksi tidak valid.');
        }

        $nilai->update([
            'nilai' => $validated['nilai'],
            'keterangan' => $validated['keterangan'],
        ]);

        // Manually trigger recalculation
        Nilai::recalculateRaport($siswaId, $mapelId, 2, '2024/2025');

        return redirect()->route('dashboard.nilai.index', [
            'kelas_id' => $kelasId,
            'mata_pelajaran_id' => $mapelId,
            'open_siswa_id' => $siswaId,
        ])->with('success', 'Nilai harian berhasil diperbarui.');
    }

    public function deleteUh(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
        ]);

        $siswaId = $validated['siswa_id'];
        $kelasId = $validated['kelas_id'];
        $mapelId = $validated['mata_pelajaran_id'];

        $nilai = Nilai::findOrFail($id);
        
        if ($nilai->siswa_id != $siswaId || $nilai->mata_pelajaran_id != $mapelId) {
            abort(403, 'Aksi tidak valid.');
        }

        $nilai->delete();

        // Manually trigger recalculation
        Nilai::recalculateRaport($siswaId, $mapelId, 2, '2024/2025');

        return redirect()->route('dashboard.nilai.index', [
            'kelas_id' => $kelasId,
            'mata_pelajaran_id' => $mapelId,
            'open_siswa_id' => $siswaId,
        ])->with('success', 'Nilai harian berhasil dihapus.');
    }
}
