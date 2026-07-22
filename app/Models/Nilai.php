<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilais';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'guru_id',
        'jenis',
        'semester',
        'tahun_ajaran',
        'nilai',
        'keterangan',
        'tanggal',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public static function recalculateRaport($siswaId, $mapelId, $semester, $tahunAjaran)
    {
        // 1. Get average UH1
        $uh1Query = self::where('siswa_id', $siswaId)
            ->where('mata_pelajaran_id', $mapelId)
            ->where('jenis', 'uh1')
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran);
        $uh1Exists = $uh1Query->exists();
        $uh1Avg = $uh1Exists ? $uh1Query->avg('nilai') : 0;

        // 2. Get average UH2
        $uh2Query = self::where('siswa_id', $siswaId)
            ->where('mata_pelajaran_id', $mapelId)
            ->where('jenis', 'uh2')
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran);
        $uh2Exists = $uh2Query->exists();
        $uh2Avg = $uh2Exists ? $uh2Query->avg('nilai') : 0;

        // 3. Get UTS
        $utsQuery = self::where('siswa_id', $siswaId)
            ->where('mata_pelajaran_id', $mapelId)
            ->where('jenis', 'uts')
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran);
        $utsExists = $utsQuery->exists();
        $utsVal = $utsExists ? $utsQuery->first()->nilai : 0;

        // 4. Get UAS
        $uasQuery = self::where('siswa_id', $siswaId)
            ->where('mata_pelajaran_id', $mapelId)
            ->where('jenis', 'uas')
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran);
        $uasExists = $uasQuery->exists();
        $uasVal = $uasExists ? $uasQuery->first()->nilai : 0;

        // Update or create Raport record
        \App\Models\Raport::updateOrCreate([
            'siswa_id' => $siswaId,
            'mata_pelajaran_id' => $mapelId,
            'semester' => $semester,
            'tahun_ajaran' => $tahunAjaran,
        ], [
            'nilai_uh1' => $uh1Avg,
            'nilai_uh2' => $uh2Avg,
            'nilai_uts' => $utsVal,
            'nilai_uas' => $uasVal,
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($nilai) {
            self::recalculateRaport(
                $nilai->siswa_id,
                $nilai->mata_pelajaran_id,
                $nilai->semester,
                $nilai->tahun_ajaran
            );
        });

        static::deleted(function ($nilai) {
            self::recalculateRaport(
                $nilai->siswa_id,
                $nilai->mata_pelajaran_id,
                $nilai->semester,
                $nilai->tahun_ajaran
            );
        });
    }
}
