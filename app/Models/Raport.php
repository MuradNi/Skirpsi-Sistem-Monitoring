<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    protected $table = 'raports';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'semester',
        'tahun_ajaran',
        'nilai_uh1',
        'nilai_uts',
        'nilai_uh2',
        'nilai_uas',
        'nilai_akhir',
        'grade',
        'tuntas',
        'catatan',
    ];

    // Weights
    const BOBOT_UH1  = 0.20;
    const BOBOT_UTS  = 0.30;
    const BOBOT_UH2  = 0.20;
    const BOBOT_UAS  = 0.30;

    public static function hitungNilaiAkhir($uh1, $uts, $uh2, $uas): float
    {
        return ($uh1 * self::BOBOT_UH1)
             + ($uts * self::BOBOT_UTS)
             + ($uh2 * self::BOBOT_UH2)
             + ($uas * self::BOBOT_UAS);
    }

    public static function hitungGrade(float $nilai): string
    {
        return match(true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default      => 'E',
        };
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($raport) {
            $raport->nilai_akhir = self::hitungNilaiAkhir(
                $raport->nilai_uh1,
                $raport->nilai_uts,
                $raport->nilai_uh2,
                $raport->nilai_uas
            );
            $raport->grade = self::hitungGrade($raport->nilai_akhir);
            
            // Check against KKM
            if ($raport->mataPelajaran) {
                $raport->tuntas = $raport->nilai_akhir >= $raport->mataPelajaran->kkm;
            } else {
                // Fallback KKM
                $raport->tuntas = $raport->nilai_akhir >= 70;
            }
        });
    }
}
