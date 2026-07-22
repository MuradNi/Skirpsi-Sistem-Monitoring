<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Raport;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaportController extends Controller
{
    public function show($siswaId)
    {
        $user = Auth::user();
        
        // Cek hak akses role
        if ($user->role === 'siswa') {
            $matchingSiswa = Siswa::where('user_id', $user->id)->first();
            if (!$matchingSiswa || $matchingSiswa->id !== (int) $siswaId) {
                abort(403, 'Akses ditolak. Anda hanya boleh melihat raport Anda sendiri.');
            }
        } elseif ($user->role === 'orang_tua') {
            $matchingSiswa = Siswa::where('parent_user_id', $user->id)->first();
            if (!$matchingSiswa || $matchingSiswa->id !== (int) $siswaId) {
                abort(403, 'Akses ditolak. Anda hanya boleh melihat raport anak Anda sendiri.');
            }
        }

        $siswa = Siswa::with(['kelas.waliKelas'])->findOrFail($siswaId);
        
        $raports = Raport::where('siswa_id', $siswa->id)
            ->where('semester', 2)
            ->with('mataPelajaran')
            ->get();

        // Hitung rata-rata dan statistik
        $totalSubjects = $raports->count();
        $avgScore = $totalSubjects > 0 ? round($raports->avg('nilai_akhir'), 1) : 0;
        $tuntasCount = $raports->where('tuntas', true)->count();
        $passingRate = $totalSubjects > 0 ? round(($tuntasCount / $totalSubjects) * 100) : 0;

        $gradeAkhir = Raport::hitungGrade($avgScore);

        $siswaList = Siswa::all();

        return view('dashboard.raport.lihat', compact(
            'siswa', 'raports', 'avgScore', 'gradeAkhir', 'passingRate', 'siswaList'
        ));
    }

    // API JSON untuk grafik perkembangan nilai siswa
    public function apiRaport(Request $request, $siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $mapelId = $request->input('mapel_id', 'all');

        $labels = ['UH Sebelum UTS', 'UTS', 'UH Sebelum UAS', 'UAS'];

        if ($mapelId === 'all') {
            // Rata-rata nilai siswa untuk semua mapel
            $raports = Raport::where('siswa_id', $siswa->id)
                ->where('semester', 2)
                ->get();

            $siswaUh1 = round($raports->avg('nilai_uh1') ?? 0, 1);
            $siswaUts = round($raports->avg('nilai_uts') ?? 0, 1);
            $siswaUh2 = round($raports->avg('nilai_uh2') ?? 0, 1);
            $siswaUas = round($raports->avg('nilai_uas') ?? 0, 1);

            // Rata-rata kelas untuk semua mapel
            $classQuery = Raport::whereHas('siswa', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })->where('semester', 2);

            $classUh1 = round($classQuery->clone()->avg('nilai_uh1') ?? 0, 1);
            $classUts = round($classQuery->clone()->avg('nilai_uts') ?? 0, 1);
            $classUh2 = round($classQuery->clone()->avg('nilai_uh2') ?? 0, 1);
            $classUas = round($classQuery->clone()->avg('nilai_uas') ?? 0, 1);

            // Nilai KKM rata-rata
            $kkm = round(MataPelajaran::avg('kkm') ?? 70, 1);

        } else {
            // Berdasarkan mapel tertentu
            $raport = Raport::where('siswa_id', $siswa->id)
                ->where('mata_pelajaran_id', $mapelId)
                ->where('semester', 2)
                ->first();

            $siswaUh1 = $raport ? round($raport->nilai_uh1, 1) : 0;
            $siswaUts = $raport ? round($raport->nilai_uts, 1) : 0;
            $siswaUh2 = $raport ? round($raport->nilai_uh2, 1) : 0;
            $siswaUas = $raport ? round($raport->nilai_uas, 1) : 0;

            // Rata-rata kelas untuk mapel ini
            $classQuery = Raport::where('mata_pelajaran_id', $mapelId)
                ->whereHas('siswa', function($q) use ($siswa) {
                    $q->where('kelas_id', $siswa->kelas_id);
                })->where('semester', 2);

            $classUh1 = round($classQuery->clone()->avg('nilai_uh1') ?? 0, 1);
            $classUts = round($classQuery->clone()->avg('nilai_uts') ?? 0, 1);
            $classUh2 = round($classQuery->clone()->avg('nilai_uh2') ?? 0, 1);
            $classUas = round($classQuery->clone()->avg('nilai_uas') ?? 0, 1);

            // KKM mapel
            $mapelObj = MataPelajaran::find($mapelId);
            $kkm = $mapelObj ? $mapelObj->kkm : 70;
        }

        return response()->json([
            'labels' => $labels,
            'siswa_grades' => [$siswaUh1, $siswaUts, $siswaUh2, $siswaUas],
            'class_averages' => [$classUh1, $classUts, $classUh2, $classUas],
            'kkm' => [$kkm, $kkm, $kkm, $kkm]
        ]);
    }
}
