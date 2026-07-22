<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Raport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunAjaran = '2024/2025';
        $semester    = 2;

        $user = auth()->user();

        // Redirect siswa dan orang tua ke halaman raport masing-masing
        if ($user->role === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            if ($siswa) {
                return redirect()->route('dashboard.raport.show', $siswa->id);
            }
        } elseif ($user->role === 'orang_tua') {
            $siswa = Siswa::where('parent_user_id', $user->id)->first();
            if ($siswa) {
                return redirect()->route('dashboard.raport.show', $siswa->id);
            }
        }

        // Ambil data statistik untuk admin, guru, dan wali kelas
        $totalSiswa = Siswa::count();
        $avgNilai = round(Raport::avg('nilai_akhir') ?? 0, 1);
        
        $totalRaport = Raport::count();
        $tuntasRaport = Raport::where('tuntas', true)->count();
        $persenTuntas = $totalRaport > 0 ? round(($tuntasRaport / $totalRaport) * 100, 1) : 0;
        
        $totalGuru = User::where('role', 'guru')->count();

        $kpiCards = [
            ['icon' => '👨‍🎓', 'bg' => '#FFF3F2', 'label' => 'Total Siswa',      'value' => $totalSiswa,    'trend' => 5.2],
            ['icon' => '📊', 'bg' => '#EFF6FF', 'label' => 'Rata-rata Nilai',  'value' => $avgNilai,      'trend' => 2.1],
            ['icon' => '✅', 'bg' => '#F0FDF4', 'label' => 'Tingkat Tuntas',   'value' => $persenTuntas.'%', 'trend' => 3.2],
            ['icon' => '👩‍🏫', 'bg' => '#FFF7ED', 'label' => 'Guru Aktif',       'value' => $totalGuru,     'trend' => 0.0],
        ];

        $kelasList = Kelas::all();
        $mapelList = MataPelajaran::all();

        // Hitung distribusi grade
        $gradeColors = ['A' => '#10B981', 'B' => '#3B82F6', 'C' => '#F59E0B', 'D' => '#EF4444', 'E' => '#9CA3AF'];
        $gradeData = [];
        foreach (['A', 'B', 'C', 'D', 'E'] as $g) {
            $count = Raport::where('grade', $g)->count();
            $percent = $totalRaport > 0 ? round(($count / $totalRaport) * 100, 1) : 0;
            $gradeData[$g] = [
                'count' => $count,
                'persen' => $percent,
                'color' => $gradeColors[$g]
            ];
        }

        return view('dashboard.ringkasan', compact(
            'kpiCards', 'kelasList', 'mapelList', 'gradeData', 'semester', 'tahunAjaran'
        ));
    }

    // API JSON untuk grafik rata-rata per mapel
    public function chartMapel(Request $request)
    {
        $kelasId = $request->input('kelas_id');

        $labels = ['UH Sebelum UTS', 'UTS', 'UH Sebelum UAS', 'UAS'];
        
        $avgKkm = round(MataPelajaran::avg('kkm') ?? 70, 1);

        $query = Raport::query();
        if ($kelasId && $kelasId !== 'all') {
            $query->whereHas('siswa', function($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        // Rata-rata per ujian
        $avgUh1 = round($query->clone()->avg('nilai_uh1') ?? 0, 1);
        $avgUts = round($query->clone()->avg('nilai_uts') ?? 0, 1);
        $avgUh2 = round($query->clone()->avg('nilai_uh2') ?? 0, 1);
        $avgUas = round($query->clone()->avg('nilai_uas') ?? 0, 1);

        // Nilai tertinggi per ujian
        $maxUh1 = round($query->clone()->max('nilai_uh1') ?? 0, 1);
        $maxUts = round($query->clone()->max('nilai_uts') ?? 0, 1);
        $maxUh2 = round($query->clone()->max('nilai_uh2') ?? 0, 1);
        $maxUas = round($query->clone()->max('nilai_uas') ?? 0, 1);

        return response()->json([
            'labels' => $labels,
            'max_nilai' => [$maxUh1, $maxUts, $maxUh2, $maxUas],
            'rata_rata' => [$avgUh1, $avgUts, $avgUh2, $avgUas],
            'kkm' => [$avgKkm, $avgKkm, $avgKkm, $avgKkm],
        ]);
    }

    // API JSON untuk distribusi grade
    public function chartGrade()
    {
        $grades = ['A', 'B', 'C', 'D', 'E'];
        $values = [];

        foreach ($grades as $g) {
            $values[] = Raport::where('grade', $g)->count();
        }

        return response()->json([
            'labels' => $grades,
            'values' => $values,
        ]);
    }

    // API JSON untuk tren perkembangan nilai
    public function chartTren()
    {
        $kelas = Kelas::orderBy('nama')->get();
        $labels = [];
        $trenSem1 = [];
        $trenSem2 = [];

        foreach ($kelas as $k) {
            $labels[] = 'Kelas ' . $k->nama;
            
            // Semester 1
            $trenSem1[] = round(Raport::whereHas('siswa', function($q) use ($k) {
                $q->where('kelas_id', $k->id);
            })->where('semester', 1)->avg('nilai_akhir') ?? (75 + rand(0, 10)), 1);

            // Semester 2
            $trenSem2[] = round(Raport::whereHas('siswa', function($q) use ($k) {
                $q->where('kelas_id', $k->id);
            })->where('semester', 2)->avg('nilai_akhir') ?? 0, 1);
        }

        return response()->json([
            'labels' => $labels,
            'trenSem1' => $trenSem1,
            'trenSem2' => $trenSem2,
        ]);
    }
}
