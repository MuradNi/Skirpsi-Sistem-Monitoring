<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Raport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'nama' => 'Budi Santoso, S.Kom',
            'email' => 'admin@buddhi.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=admin',
        ]);

        $guru1 = User::create([
            'nama' => 'Siti Rahma, S.Pd',
            'email' => 'guru1@buddhi.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=teacher1',
        ]);

        $guru2 = User::create([
            'nama' => 'Hendra Wijaya, S.Pd',
            'email' => 'guru2@buddhi.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=teacher2',
        ]);

        $wali6a = User::create([
            'nama' => 'Dewi Lestari, M.Pd',
            'email' => 'wali6a@buddhi.sch.id',
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=wali',
        ]);

        $orangtua = User::create([
            'nama' => 'Rudi Hermawan',
            'email' => 'orangtua@buddhi.sch.id',
            'no_wa' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=parent',
        ]);

        // 2. Seed Kelas
        $kelas6A = Kelas::create([
            'nama' => '6A',
            'tingkat' => 6,
            'tahun_ajaran' => '2024/2025',
            'wali_kelas_id' => $wali6a->id,
        ]);

        $kelas6B = Kelas::create([
            'nama' => '6B',
            'tingkat' => 6,
            'tahun_ajaran' => '2024/2025',
            'wali_kelas_id' => $guru2->id,
        ]);

        $kelas5A = Kelas::create([
            'nama' => '5A',
            'tingkat' => 5,
            'tahun_ajaran' => '2024/2025',
            'wali_kelas_id' => $guru1->id,
        ]);

        // 3. Seed Mata Pelajaran
        $mpMatematika = MataPelajaran::create(['kode' => 'MTK', 'nama' => 'Matematika', 'kkm' => 75]);
        $mpIndonesia = MataPelajaran::create(['kode' => 'BIN', 'nama' => 'Bahasa Indonesia', 'kkm' => 70]);
        $mpIpa = MataPelajaran::create(['kode' => 'IPA', 'nama' => 'Ilmu Pengetahuan Alam', 'kkm' => 70]);
        $mpIps = MataPelajaran::create(['kode' => 'IPS', 'nama' => 'Ilmu Pengetahuan Sosial', 'kkm' => 70]);
        $mpInggris = MataPelajaran::create(['kode' => 'ING', 'nama' => 'Bahasa Inggris', 'kkm' => 75]);
        $mpAgama = MataPelajaran::create(['kode' => 'AG', 'nama' => 'Pendidikan Agama', 'kkm' => 80]);

        // 4. Seed Siswa
        $sRian = Siswa::create([
            'user_id' => $orangtua->id, // Share same parent user id
            'parent_user_id' => $orangtua->id,
            'nis' => '20240001',
            'nama_lengkap' => 'Rian Hermawan',
            'kelas_id' => $kelas6A->id,
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2013-05-12',
            'foto' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=student',
        ]);

        $sAlya = Siswa::create([
            'nis' => '20240002',
            'nama_lengkap' => 'Alya Putri',
            'kelas_id' => $kelas6A->id,
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2013-08-20',
            'foto' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Alya',
        ]);

        $sDafa = Siswa::create([
            'nis' => '20240003',
            'nama_lengkap' => 'Dafa Alamsyah',
            'kelas_id' => $kelas6A->id,
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2013-03-05',
            'foto' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Dafa',
        ]);

        $sAmelia = Siswa::create([
            'nis' => '20240004',
            'nama_lengkap' => 'Siti Amelia',
            'kelas_id' => $kelas6B->id,
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2013-11-15',
            'foto' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Amelia',
        ]);

        $sBudi = Siswa::create([
            'nis' => '20240005',
            'nama_lengkap' => 'Budi Prakoso',
            'kelas_id' => $kelas6B->id,
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2013-01-22',
            'foto' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Budi',
        ]);

        // 5. Seed Raports & Nilais (Sub-scores)
        // Rian Hermawan
        $this->seedRaportAndNilai($sRian, $mpMatematika, 85, 78, 82, 80, $guru1->id);
        $this->seedRaportAndNilai($sRian, $mpIndonesia, 90, 85, 87, 88, $guru1->id);
        $this->seedRaportAndNilai($sRian, $mpIpa, 78, 72, 76, 75, $guru2->id);
        $this->seedRaportAndNilai($sRian, $mpIps, 82, 80, 81, 84, $guru2->id);
        $this->seedRaportAndNilai($sRian, $mpInggris, 88, 86, 89, 90, $guru1->id);
        $this->seedRaportAndNilai($sRian, $mpAgama, 95, 92, 93, 94, $guru2->id);

        // Alya Putri
        $this->seedRaportAndNilai($sAlya, $mpMatematika, 92, 90, 93, 94, $guru1->id);
        $this->seedRaportAndNilai($sAlya, $mpIndonesia, 88, 82, 84, 85, $guru1->id);
        $this->seedRaportAndNilai($sAlya, $mpIpa, 89, 92, 91, 90, $guru2->id);
        $this->seedRaportAndNilai($sAlya, $mpIps, 78, 75, 79, 80, $guru2->id);
        $this->seedRaportAndNilai($sAlya, $mpInggris, 95, 90, 93, 96, $guru1->id);
        $this->seedRaportAndNilai($sAlya, $mpAgama, 90, 88, 89, 92, $guru2->id);

        // Dafa Alamsyah
        $this->seedRaportAndNilai($sDafa, $mpMatematika, 68, 62, 64, 65, $guru1->id);
        $this->seedRaportAndNilai($sDafa, $mpIndonesia, 72, 70, 73, 74, $guru1->id);
        $this->seedRaportAndNilai($sDafa, $mpIpa, 65, 58, 60, 62, $guru2->id);
        $this->seedRaportAndNilai($sDafa, $mpIps, 74, 71, 73, 72, $guru2->id);
        $this->seedRaportAndNilai($sDafa, $mpInggris, 69, 65, 68, 70, $guru1->id);
        $this->seedRaportAndNilai($sDafa, $mpAgama, 80, 82, 84, 85, $guru2->id);

        // Siti Amelia
        $this->seedRaportAndNilai($sAmelia, $mpMatematika, 80, 78, 81, 82, $guru1->id);
        $this->seedRaportAndNilai($sAmelia, $mpIndonesia, 85, 80, 82, 83, $guru1->id);
        $this->seedRaportAndNilai($sAmelia, $mpIpa, 82, 84, 81, 80, $guru2->id);
        $this->seedRaportAndNilai($sAmelia, $mpIps, 90, 88, 89, 91, $guru2->id);
        $this->seedRaportAndNilai($sAmelia, $mpInggris, 76, 78, 77, 75, $guru1->id);
        $this->seedRaportAndNilai($sAmelia, $mpAgama, 88, 85, 87, 89, $guru2->id);

        // Budi Prakoso
        $this->seedRaportAndNilai($sBudi, $mpMatematika, 60, 58, 61, 62, $guru1->id);
        $this->seedRaportAndNilai($sBudi, $mpIndonesia, 72, 68, 69, 70, $guru1->id);
        $this->seedRaportAndNilai($sBudi, $mpIpa, 68, 62, 64, 65, $guru2->id);
        $this->seedRaportAndNilai($sBudi, $mpIps, 80, 78, 81, 82, $guru2->id);
        $this->seedRaportAndNilai($sBudi, $mpInggris, 62, 60, 64, 65, $guru1->id);
        $this->seedRaportAndNilai($sBudi, $mpAgama, 82, 80, 81, 83, $guru2->id);
    }

    private function seedRaportAndNilai(Siswa $siswa, MataPelajaran $mapel, $uh1, $uts, $uh2, $uas, $guruId)
    {
        // Create Raport (boot method triggers calculation of nilai_akhir and grade)
        Raport::create([
            'siswa_id' => $siswa->id,
            'mata_pelajaran_id' => $mapel->id,
            'semester' => 2,
            'tahun_ajaran' => '2024/2025',
            'nilai_uh1' => $uh1,
            'nilai_uts' => $uts,
            'nilai_uh2' => $uh2,
            'nilai_uas' => $uas,
            'catatan' => 'Sikap belajar terpantau konsisten.',
        ]);

        // Create Sub Nilais
        $components = [
            'uh1' => $uh1,
            'uts' => $uts,
            'uh2' => $uh2,
            'uas' => $uas,
        ];

        foreach ($components as $jenis => $nilaiVal) {
            Nilai::create([
                'siswa_id' => $siswa->id,
                'mata_pelajaran_id' => $mapel->id,
                'guru_id' => $guruId,
                'jenis' => $jenis,
                'semester' => 2,
                'tahun_ajaran' => '2024/2025',
                'nilai' => $nilaiVal,
                'keterangan' => 'Nilai ' . strtoupper($jenis),
                'tanggal' => date('Y-m-d'),
            ]);
        }
    }
}
